<?php
defined('ABSPATH') || exit;

/**
 * Per-request debug context (IP, city, cache source) for logging and response headers.
 *
 * @var array<string, mixed>
 */
$wmcp_request_context = array();

/**
 * Whether logging is enabled (define WMCP_DEBUG as true in wp-config.php to enable).
 */
function wmcp_logging_enabled()
{
	if (defined('WMCP_DEBUG') && WMCP_DEBUG) {
		return true;
	}

	return (bool) apply_filters('wmcp_enable_logging', defined('WP_DEBUG') && WP_DEBUG && defined('WP_DEBUG_LOG') && WP_DEBUG_LOG);
}

/**
 * Structured log line for IP / city / DB / cache / Groq tracing.
 *
 * @param string               $message Log message.
 * @param array<string, mixed> $context Optional context.
 */
function wmcp_log($message, $context = array())
{
	if (! wmcp_logging_enabled()) {
		return;
	}

	global $wmcp_request_context;
	if (! empty($wmcp_request_context)) {
		$context = array_merge($wmcp_request_context, $context);
	}

	$line = '[WMCP] ' . $message;
	if (! empty($context)) {
		$line .= ' ' . wp_json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}

	error_log($line);
}

/**
 * Store values on the current request for logging and optional debug headers.
 *
 * @param string $key   Context key.
 * @param mixed  $value Context value.
 */
function wmcp_set_request_context($key, $value)
{
	global $wmcp_request_context;
	$wmcp_request_context[ $key ] = $value;
}

/**
 * Optional debug response headers when WMCP_DEBUG is enabled.
 */
function wmcp_send_debug_headers()
{
	if (! defined('WMCP_DEBUG') || ! WMCP_DEBUG || headers_sent()) {
		return;
	}

	global $wmcp_request_context;
	$map = array(
		'ip'           => 'X-WMCP-IP',
		'city'         => 'X-WMCP-City',
		'state'        => 'X-WMCP-State',
		'city_key'     => 'X-WMCP-City-Key',
		'page_type'    => 'X-WMCP-Page-Type',
		'cache_source' => 'X-WMCP-Cache-Source',
	);

	foreach ($map as $key => $header) {
		if (! empty($wmcp_request_context[ $key ])) {
			header($header . ': ' . sanitize_text_field((string) $wmcp_request_context[ $key ]));
		}
	}
}
