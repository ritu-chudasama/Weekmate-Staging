<?php
defined('ABSPATH') || exit;

/* -------------------------------------------------------------------------
 * IP detection
 * ------------------------------------------------------------------------- */

function wmcp_is_local_or_private_ip($ip)
{
	if (empty($ip)) {
		return true;
	}
	if (in_array($ip, array('127.0.0.1', '::1'), true)) {
		return true;
	}
	return ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
}

/**
 * Dev override: define WMCP_TEST_IP in wp-config.php or use filter wmcp_test_ip_override.
 */
function wmcp_get_test_ip_override()
{
	if (defined('WMCP_TEST_IP') && filter_var(WMCP_TEST_IP, FILTER_VALIDATE_IP)) {
		return WMCP_TEST_IP;
	}

	$override = apply_filters('wmcp_test_ip_override', '');
	if (is_string($override) && filter_var($override, FILTER_VALIDATE_IP)) {
		return $override;
	}

	return '';
}

/**
 * Public IP via ipify — fallback when REMOTE_ADDR is private (localhost/WAMP).
 * Intentionally NOT stored in transients: a site-wide IP cache caused every
 * visitor to share the first resolved city until the transient expired.
 *
 * @see https://api.ipify.org/
 */
function wmcp_fetch_public_ip()
{
	static $request_ip = null;

	if (null !== $request_ip) {
		return $request_ip;
	}

	$response = wp_remote_get(
		'https://api.ipify.org/',
		array('timeout' => 10)
	);

	if (is_wp_error($response)) {
		wmcp_log('ipify lookup failed', array('error' => $response->get_error_message()));
		$request_ip = '';
		return $request_ip;
	}

	$ip = trim(wp_remote_retrieve_body($response));
	if (! filter_var($ip, FILTER_VALIDATE_IP)) {
		wmcp_log('ipify returned invalid IP', array('body' => $ip));
		$request_ip = '';
		return $request_ip;
	}

	wmcp_log('ipify public IP resolved (per-request, not cached globally)', array('ip' => $ip));
	$request_ip = $ip;
	return $request_ip;
}

function wmcp_get_visitor_ip()
{
	$override = wmcp_get_test_ip_override();
	if ($override) {
		wmcp_log('visitor IP from test override', array('ip' => $override, 'source' => 'override'));
		return $override;
	}

	$headers = array(
		'HTTP_CF_CONNECTING_IP',
		'HTTP_X_FORWARDED_FOR',
		'HTTP_X_REAL_IP',
		'REMOTE_ADDR',
	);

	$ip     = '';
	$source = '';
	foreach ($headers as $header) {
		if (empty($_SERVER[ $header ])) {
			continue;
		}
		$raw = sanitize_text_field(wp_unslash($_SERVER[ $header ]));
		if ('HTTP_X_FORWARDED_FOR' === $header) {
			$parts = array_map('trim', explode(',', $raw));
			$raw   = $parts[0];
		}
		if (filter_var($raw, FILTER_VALIDATE_IP)) {
			$ip     = $raw;
			$source = $header;
			break;
		}
	}

	if (wmcp_is_local_or_private_ip($ip)) {
		wmcp_log('private/local IP detected, trying ipify fallback', array('ip' => $ip, 'source' => $source));
		$public = wmcp_fetch_public_ip();
		if ($public) {
			wmcp_log('visitor IP resolved', array('ip' => $public, 'source' => 'ipify'));
			return $public;
		}
	}

	wmcp_log('visitor IP resolved', array('ip' => $ip, 'source' => $source ?: 'none'));
	return $ip;
}

/* -------------------------------------------------------------------------
 * Geolocation
 * ------------------------------------------------------------------------- */

function wmcp_resolve_location($ip)
{
	if (empty($ip)) {
		return new WP_Error('wmcp_no_ip', 'Could not detect visitor IP. Check outbound HTTP access.');
	}

	if (wmcp_is_local_or_private_ip($ip)) {
		$public = wmcp_fetch_public_ip();
		if ($public) {
			$ip = $public;
		} else {
			return new WP_Error('wmcp_local_ip', 'Local IP and public IP lookup (ipify.org) both failed.');
		}
	}

	$cache_key = 'wmcp_loc_' . md5($ip);
	$cached    = get_transient($cache_key);
	if (is_array($cached) && ! empty($cached['city'])) {
		wmcp_log('geolocation transient hit', array(
			'ip'        => $ip,
			'cache_key' => $cache_key,
			'city'      => $cached['city'],
			'state'     => $cached['state'] ?? '',
		));
		return $cached;
	}

	wmcp_log('geolocation transient miss', array('ip' => $ip, 'cache_key' => $cache_key));

	$location = wmcp_fetch_ipapi($ip);
	if (is_wp_error($location)) {
		wmcp_log('ipapi.co failed, trying ip-api.com', array('ip' => $ip, 'error' => $location->get_error_message()));
		$location = wmcp_fetch_ip_api_com($ip);
	}

	if (is_wp_error($location)) {
		wmcp_log('geolocation failed', array('ip' => $ip, 'error' => $location->get_error_message()));
		return $location;
	}

	wmcp_log('geolocation resolved from API', array(
		'ip'    => $ip,
		'city'  => $location['city'],
		'state' => $location['state'] ?? '',
	));

	set_transient($cache_key, $location, 6 * HOUR_IN_SECONDS);
	return $location;
}

function wmcp_fetch_ipapi($ip)
{
	$response = wp_remote_get(
		'https://ipapi.co/' . rawurlencode($ip) . '/json/',
		array('timeout' => 10)
	);

	if (is_wp_error($response)) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code($response);
	$body = json_decode(wp_remote_retrieve_body($response), true);

	if (200 !== $code || empty($body['city'])) {
		return new WP_Error('wmcp_ipapi_fail', 'ipapi.co lookup failed.');
	}

	return array(
		'city'  => sanitize_text_field($body['city']),
		'state' => sanitize_text_field($body['region'] ?? $body['region_code'] ?? ''),
	);
}

function wmcp_fetch_ip_api_com($ip)
{
	$response = wp_remote_get(
		'http://ip-api.com/json/' . rawurlencode($ip) . '?fields=status,city,regionName',
		array('timeout' => 10)
	);

	if (is_wp_error($response)) {
		return $response;
	}

	$body = json_decode(wp_remote_retrieve_body($response), true);
	if (empty($body['status']) || 'success' !== $body['status'] || empty($body['city'])) {
		return new WP_Error('wmcp_ip_api_fail', 'ip-api.com lookup failed.');
	}

	return array(
		'city'  => sanitize_text_field($body['city']),
		'state' => sanitize_text_field($body['regionName'] ?? ''),
	);
}
