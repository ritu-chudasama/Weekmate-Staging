<?php
defined('ABSPATH') || exit;

add_action('plugins_loaded', 'wmcp_bootstrap', 0);

/**
 * Early bootstrap: purge stale global IP transient, disable full-page cache on trigger URL.
 */
function wmcp_bootstrap()
{
	// One-time cleanup: legacy site-wide transient pinned one IP for all visitors.
	if (! get_option('wmcp_migrated_public_ip_transient')) {
		delete_transient('wmcp_public_ip');
		update_option('wmcp_migrated_public_ip_transient', 1, false);
	}

	if (wmcp_request_matches_trigger_post()) {
		wmcp_disable_page_cache();
	}
}

add_action('init', 'wmcp_init_cache_bypass', 0);

function wmcp_init_cache_bypass()
{
	if (wmcp_request_matches_trigger_post()) {
		wmcp_disable_page_cache();
	}
}

add_filter('rocket_cache_reject_uri', 'wmcp_rocket_cache_reject_uri');
add_filter('rocket_exclude_current_page', 'wmcp_rocket_exclude_current_page');

/**
 * @param string[] $uris WP Rocket URI reject patterns.
 * @return string[]
 */
function wmcp_rocket_cache_reject_uri($uris)
{
	if (! is_array($uris)) {
		$uris = array();
	}

	foreach (wmcp_get_trigger_configs() as $config) {
		$slug   = preg_quote($config['slug'], '#');
		$uris[] = '/(.*/)?' . $slug . '/?(\\?.*)?$';
	}

	foreach (wmcp_get_page_type_definitions() as $def) {
		$prefix = preg_quote($def['slug_prefix'] ?? '', '#');
		if ('' !== $prefix) {
			$uris[] = '/(.*/)?' . $prefix . '[^/]+/?(\\?.*)?$';
		}
	}

	return array_unique($uris);
}

/**
 * @param bool $exclude Current exclusion flag.
 * @return bool
 */
function wmcp_rocket_exclude_current_page($exclude)
{
	if ($exclude || ! wmcp_request_matches_trigger_post()) {
		return $exclude;
	}

	return true;
}

add_action('litespeed_control_init', 'wmcp_litespeed_no_cache');

function wmcp_litespeed_no_cache()
{
	if (wmcp_request_matches_trigger_post() && class_exists('LiteSpeed_Cache_API')) {
		LiteSpeed_Cache_API::set_nocache('Ai Content Integration are IP/city dynamic.');
	}
}

/* -------------------------------------------------------------------------
 * Core generation flow
 * ------------------------------------------------------------------------- */

function wmcp_generate_city_page($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$city_key  = wmcp_city_key($city, $state);
	wmcp_log('generate_city_page start', array(
		'city'      => $city,
		'state'     => $state,
		'city_key'  => $city_key,
		'page_type' => $page_type,
	));

	$cached = wmcp_get_cache($city_key, $page_type);

	if ($cached && wmcp_cache_is_usable($city_key, $page_type)) {
		return wmcp_build_generate_result('cache', $cached, '', $city_key, $page_type);
	}

	$config    = wmcp_get_page_type_definition($page_type);
	$post_slug = ($config['slug_prefix'] ?? 'payroll-software-in-') . wmcp_city_slug($city);
	$cached    = wmcp_get_cache_by_post_slug($post_slug, $page_type);
	if ($cached && wmcp_cache_row_is_renderable($cached)) {
		return wmcp_build_generate_result('cache', $cached, '', '', $page_type);
	}

	$cached = wmcp_get_cache($city_key, $page_type);

	// Migrate legacy WP-post rows into DB storage before dropping stale cache.
	if ($cached && empty($cached['page_html']) && ! empty($cached['post_id']) && wmcp_is_valid_city_post((int) $cached['post_id'])) {
		$html = wmcp_get_post_html((int) $cached['post_id']);
		$data = get_post_meta((int) $cached['post_id'], '_wmcp_page_data', true);
		if ('' !== $html) {
			wmcp_save_cache(
				$city_key,
				$city,
				$state,
				$cached['post_slug'] ?? sanitize_title($city),
				$cached['meta_title'] ?? '',
				$html,
				is_string($data) ? $data : '',
				(int) $cached['post_id'],
				$page_type
			);
			return wmcp_build_generate_result('cache', wmcp_get_cache($city_key, $page_type), $html, $city_key, $page_type);
		}
	}

	if ($cached && ! wmcp_cache_row_is_renderable($cached)) {
		wmcp_delete_cache($city_key, $page_type);
	}

	$lock_key = 'wmcp_lock_' . $page_type . '_' . sanitize_title($post_slug);
	if (get_transient($lock_key)) {
		wmcp_log('generation lock active, waiting', array(
			'city_key'  => $city_key,
			'page_type' => $page_type,
		));
		sleep(2);
		if (wmcp_cache_is_usable_for_city($city, $state, $page_type)) {
			$cached = wmcp_get_cache($city_key, $page_type);
			if (! $cached) {
				$cached = wmcp_get_cache_by_post_slug($post_slug, $page_type);
			}
			return wmcp_build_generate_result('cache', $cached, '', '', $page_type);
		}
		delete_transient($lock_key);
	}

	set_transient($lock_key, 1, 120);
	wmcp_log('calling Groq API', array(
		'city'      => $city,
		'state'     => $state,
		'city_key'  => $city_key,
		'page_type' => $page_type,
	));

	// $data = wmcp_call_groq($city, $state, $page_type);
	// if (is_wp_error($data)) {
	// 	wmcp_log('Groq API failed — redirecting to static fallback page', array('error' => $data->get_error_message(), 'city' => $city, 'page_type' => $page_type));
	// 	delete_transient($lock_key);
	// 	wp_safe_redirect( wmcp_get_static_fallback_page_url( $page_type ), 302 );
	// 	exit;
	// }
	$data = wmcp_call_groq($city, $state, $page_type);
	if (is_wp_error($data)) {
		wmcp_log('Groq API failed — signalling static fallback redirect', array('error' => $data->get_error_message(), 'city' => $city, 'page_type' => $page_type));
		delete_transient($lock_key);
		return array( 'source' => 'static_fallback', 'page_type' => $page_type );
	}


	$saved = wmcp_save_city_to_cache($data, $city, $state, $page_type);
	if (is_wp_error($saved)) {
		wmcp_log('save to city cache failed', array('error' => $saved->get_error_message()));
		delete_transient($lock_key);
		// Return fallback data directly even if cache save failed.
		return array(
			'source'    => 'fallback',
			'html'      => 'wp_template',
			'cached'    => null,
			'slug'      => $post_slug,
			'meta_title'=> '',
			'city_key'  => $city_key,
			'page_type' => $page_type,
			'city'      => $city,
			'state'     => $state,
			'data'      => $data,
		);
	}

	delete_transient($lock_key);
	wmcp_log('Groq content saved to database', array(
		'city_key'  => $city_key,
		'page_type' => $page_type,
	));

	$cached = wmcp_get_cache($city_key, $page_type);
	if (! $cached) {
		$cached = wmcp_get_cache_by_post_slug($post_slug, $page_type);
	}

	$built = wmcp_build_generate_result('groq', $cached, 'wp_template', $city_key, $page_type);
	if (is_wp_error($built)) {
		return $built;
	}

	return array_merge(
		$built,
		array(
			'source' => 'groq',
		)
	);
}


add_action('template_redirect', 'wmcp_maybe_render_fallback_flag', -10);

/**
 * If this exact URL was flagged (during a failed generation) to render
 * static fallback content in-place, do that now — before any other
 * template_redirect logic runs — and stop.
 */
function wmcp_maybe_render_fallback_flag()
{
	if (is_admin() || wp_doing_ajax() || wp_doing_cron() || (defined('REST_REQUEST') && REST_REQUEST)) {
		return;
	}

	$fallback_flag_key = 'wmcp_fallback_flag_' . md5(wmcp_get_current_request_url());
	$flagged_page_type = get_transient($fallback_flag_key);

	if (false === $flagged_page_type) {
		return; // not flagged, let normal flow continue
	}

	delete_transient($fallback_flag_key);

	$page_type     = wmcp_normalize_page_type($flagged_page_type);
	$fallback_slug = ('hr' === $page_type) ? 'hr-software-static' : 'payroll-software-static';
	$fallback_page = get_page_by_path($fallback_slug, OBJECT, 'page');

	if (! $fallback_page || 'publish' !== $fallback_page->post_status) {
		return; // nothing to render, fall through to normal flow
	}

	global $post, $wp_query;
	$post                         = $fallback_page;
	$wp_query->is_page            = true;
	$wp_query->is_singular        = true;
	$wp_query->queried_object     = $fallback_page;
	$wp_query->queried_object_id  = $fallback_page->ID;
	set_transient( 'wmcp_static_render_type_' . $fallback_page->ID, $page_type, 60 );
	setup_postdata($post);
	$template      = get_page_template_slug($fallback_page->ID);
	$template_file = $template ? get_theme_file_path($template) : get_page_template();

	status_header(200);
	nocache_headers();
	include($template_file && file_exists($template_file) ? $template_file : get_index_template());
	exit;
}




/* -------------------------------------------------------------------------
 * template_redirect — visitor flow
 * ------------------------------------------------------------------------- */

add_action('template_redirect', 'wmcp_template_redirect_city_permalink', 0);
add_action('template_redirect', 'wmcp_template_redirect', 1);

/**
 * Generate or serve a city page (shared by permalink and trigger flows).
 *
 * @param string $city      City name.
 * @param string $state     State name.
 * @param string $page_type payroll|hr
 * @param bool   $allow_loading Whether to show the loading spinner.
 */
function wmcp_serve_city_page($city, $state, $page_type = 'payroll', $allow_loading = true)
{
	$page_type = wmcp_normalize_page_type($page_type);

	wmcp_disable_page_cache();
	wmcp_set_request_context('city', $city);
	wmcp_set_request_context('state', $state);
	wmcp_set_request_context('page_type', $page_type);

	if (empty($city)) {
		wmcp_output_error_page('City is required.');
	}

	$city_key = wmcp_city_key($city, $state);
	wmcp_set_request_context('city_key', $city_key);

	wmcp_log('city page request started', array(
		'city'      => $city,
		'state'     => $state,
		'city_key'  => $city_key,
		'page_type' => $page_type,
	));

	@set_time_limit(180);

	$showed_loading = false;
	if ($allow_loading && ! wmcp_cache_is_usable_for_city($city, $state, $page_type)) {
		wmcp_output_loading_page($city, $state, $page_type);
		$showed_loading = true;
	}

	// $result = wmcp_generate_city_page($city, $state, $page_type);
	// if (is_wp_error($result)) {
	// 	if ($showed_loading) {
	// 		wmcp_finish_with_error($result->get_error_message());
	// 	}
	// 	wmcp_output_error_page($result->get_error_message());
	// }

		$result = wmcp_generate_city_page($city, $state, $page_type);
	if (is_wp_error($result)) {
		if ($showed_loading) {
			wmcp_finish_with_error($result->get_error_message());
		}
		wmcp_output_error_page($result->get_error_message());
	}
	// API failed — render static fallback page in-place (URL stays the same).
	if ( isset( $result['source'] ) && 'static_fallback' === $result['source'] ) {
		// $fallback_url  = wmcp_get_static_fallback_page_url( $result['page_type'] ?? $page_type );
		$fallback_slug = ( 'hr' === wmcp_normalize_page_type( $result['page_type'] ?? $page_type ) )
			? 'hr-software-static'
			: 'payroll-software-static';
		$fallback_page = get_page_by_path( $fallback_slug, OBJECT, 'page' );

		if ( $fallback_page && 'publish' === $fallback_page->post_status ) {
			if ( $showed_loading ) {
				// Reload the SAME URL (not the fallback URL) so address bar stays correct.
				// Mark this request so the reload renders fallback content instead of re-triggering generation.
				// CORRECT — stores the actual page_type so the flag handler knows which static page to load
				set_transient( 'wmcp_fallback_flag_' . md5( wmcp_get_current_request_url() ), $result['page_type'] ?? $page_type, 60 );
				wmcp_finish_with_redirect( wmcp_get_current_request_url() );;
			}
			// No loader shown — render fallback content in-place, URL unchanged.
			global $post, $wp_query;
			$post                      = $fallback_page;
			$wp_query->is_page         = true;
			$wp_query->is_singular     = true;
			$wp_query->queried_object    = $fallback_page;
			$wp_query->queried_object_id = $fallback_page->ID;
			set_transient( 'wmcp_static_render_type_' . $fallback_page->ID, wmcp_normalize_page_type( $result['page_type'] ?? $page_type ), 60 );
			setup_postdata( $post );
			$template      = get_page_template_slug( $fallback_page->ID );
			$template_file = $template ? get_theme_file_path( $template ) : get_page_template();
			status_header( 200 );
			nocache_headers();
			include( $template_file && file_exists( $template_file ) ? $template_file : get_index_template() );
			exit;
		}

		// Static page not available — redirect to its URL or home as last resort.
			$fallback_url = wmcp_get_static_fallback_page_url( $result['page_type'] ?? $page_type );
		if ( $showed_loading ) {
			wmcp_finish_with_redirect( $fallback_url );
		}
		wp_safe_redirect( $fallback_url, 302 );
		exit;
	}


	$cached_row = $result['cached'] ?? null;
	if (! $cached_row && ! empty($result['city_key'])) {
		$cached_row = wmcp_get_cache($result['city_key'], $result['page_type'] ?? $page_type);
	}
	if (! $cached_row) {
		$config    = wmcp_get_page_type_definition($page_type);
		$post_slug = ($config['slug_prefix'] ?? 'payroll-software-in-') . wmcp_city_slug($city);
		$cached_row = wmcp_get_cache_by_post_slug($post_slug, $page_type);
	}

	if (! $cached_row || ! wmcp_cache_row_is_renderable($cached_row)) {
		if ($showed_loading) {
			wmcp_finish_with_error('Page was generated but no content was returned.');
		}
		wmcp_output_error_page('Page was generated but no content was returned.');
	}

	wmcp_set_request_context('cache_source', $result['source'] ?? 'unknown');
	wmcp_log('city page request complete', array(
		'source'    => $result['source'] ?? '',
		'city_key'  => $result['city_key'] ?? $city_key,
		'page_type' => $result['page_type'] ?? $page_type,
		'city'      => $result['city'] ?? $city,
	));

	if ($showed_loading) {
		wmcp_finish_with_redirect(wmcp_get_current_request_url());
	}

	wmcp_output_city_page($cached_row);
}

/**
 * Serve /hr-software-in-{city}/ and /payroll-software-in-{city}/ directly from the URL.
 */
function wmcp_template_redirect_city_permalink()
{
	if (is_admin() || wp_doing_ajax() || wp_doing_cron() || (defined('REST_REQUEST') && REST_REQUEST)) {
		return;
	}

	$parsed = wmcp_parse_city_permalink_from_request();
	if (! $parsed) {
		return;
	}


	$page_type = $parsed['page_type'];
	$city      = $parsed['city'];
	$state     = $parsed['state'];

	wmcp_log('city permalink request', $parsed);

	// Check if this city is in the allowed list for this page type.
	if (! wmcp_city_is_allowed($parsed['city_slug'], $page_type)) {
		wmcp_log('city not in allowed list — returning 404', array(
			'city_slug' => $parsed['city_slug'],
			'page_type' => $page_type,
		));
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
		nocache_headers();
		include get_query_template('404');
		exit;
	}

	$cached = wmcp_get_cache_by_post_slug($parsed['post_slug'], $page_type);
	if ($cached) {
		if (! empty($cached['city']) && empty($city)) {
			$city = $cached['city'];
		}
		if (! empty($cached['state'])) {
			$state = $cached['state'];
		}

		if (wmcp_cache_row_is_renderable($cached)) {
			wmcp_set_request_context('city', $city);
			wmcp_set_request_context('state', $state);
			wmcp_set_request_context('page_type', $page_type);
			wmcp_set_request_context('city_key', $cached['city_key']);
			wmcp_set_request_context('cache_source', 'cache');

			// Stale-while-revalidate: serve the cached page immediately.
			// If the content is older than the TTL, trigger a background
			// refresh so the NEXT visitor gets fresh content.
			if (wmcp_cache_is_stale($cached)) {
				wmcp_log('cache is stale — serving old content and scheduling background refresh', array(
					'city'       => $city,
					'page_type'  => $page_type,
					'created_at' => $cached['created_at'] ?? '',
				));
				wmcp_schedule_background_refresh($city, $state, $page_type);
			}

			wmcp_output_city_page($cached);
		}
	}

	wmcp_serve_city_page($city, $state, $page_type);
}

function wmcp_template_redirect()
{
	if (is_admin() || wp_doing_ajax() || wp_doing_cron() || (defined('REST_REQUEST') && REST_REQUEST)) {
		return;
	}

	if (! is_page()) {
		return;
	}

	global $post;
	if (! wmcp_is_trigger_page($post)) {
		return;
	}

	// If the page has the theme's "WeekMate City Page" template assigned,
	// let WordPress load that template file instead — do not intercept here.
	$assigned_template = get_page_template_slug($post->ID);
	if ($assigned_template && false !== strpos($assigned_template, 'city-page-template.php')) {
		return;
	}

	$page_type = wmcp_get_page_type_from_page($post);

	wmcp_disable_page_cache();
	wmcp_log('trigger page request started', array(
		'page_id'   => $post->ID,
		'slug'      => $post->post_name,
		'page_type' => $page_type,
	));

	$ip = wmcp_get_visitor_ip();
	wmcp_set_request_context('ip', $ip);

	$city  = '';
	$state = '';

	if ( ! empty( $ip ) ) {
		$location = wmcp_resolve_location( $ip );
		if ( ! is_wp_error( $location ) && ! empty( $location['city'] ) ) {
			$city  = $location['city'];
			$state = $location['state'] ?? '';
		}
	}

	// Geolocation failed — render static fallback page in-place.
	if ( empty( $city ) ) {
		wmcp_log( 'geolocation failed — rendering static fallback page in-place', array( 'page_type' => $page_type ) );
		$fallback_slug = ( 'hr' === wmcp_normalize_page_type( $page_type ) )
			? 'hr-software-static'
			: 'payroll-software-static';
		$fallback_page = get_page_by_path( $fallback_slug, OBJECT, 'page' );
		if ( $fallback_page && 'publish' === $fallback_page->post_status ) {
			global $post, $wp_query;
			$post     = $fallback_page;
			$wp_query->is_page     = true;
			$wp_query->is_singular = true;
			$wp_query->queried_object    = $fallback_page;
			$wp_query->queried_object_id = $fallback_page->ID;
			set_transient( 'wmcp_static_render_type_' . $fallback_page->ID, $page_type, 60 );
			setup_postdata( $post );
			$template      = get_page_template_slug( $fallback_page->ID );
			$template_file = $template ? get_theme_file_path( $template ) : get_page_template();
			status_header( 200 );
			nocache_headers();
			if ( $template_file && file_exists( $template_file ) ) {
				include $template_file;
			} else {
				include get_index_template();
			}
			exit;
		}
		// Static page not set up — fall through to WordPress default rendering.
		return;
	}

	wmcp_set_request_context('city', $city);
	wmcp_set_request_context('state', $state);
	wmcp_set_request_context('page_type', $page_type);

	wmcp_log('resolved visitor location', array(
		'ip'        => $ip,
		'city'      => $city,
		'state'     => $state,
		'page_type' => $page_type,
	));

	// If an allowed cities list is set for this page type, only redirect to
	// a city that is in the list. For disallowed cities, show a generic page
	// rather than redirecting to a URL that would 404.
	if (! wmcp_city_is_allowed(wmcp_city_slug($city), $page_type)) {
		wmcp_log('visitor city not in allowed list — not redirecting', array(
			'city'      => $city,
			'page_type' => $page_type,
		));
		// Fall through to WordPress default rendering of the trigger page.
		return;
	}

	wp_safe_redirect(wmcp_city_permalink_url($city, $page_type), 302);
	exit;
}

/* -------------------------------------------------------------------------
 * REST API
 * ------------------------------------------------------------------------- */

add_action('rest_api_init', 'wmcp_register_rest_routes');

function wmcp_register_rest_routes()
{
	register_rest_route(
		'wmcp/v1',
		'/generate',
		array(
			'methods'             => 'POST',
			'callback'            => 'wmcp_rest_generate',
			'permission_callback' => function () {
				return current_user_can('manage_options');
			},
			'args'                => array(
				'city'      => array('required' => true, 'type' => 'string'),
				'state'     => array('required' => true, 'type' => 'string'),
				'page_type' => array(
					'required' => false,
					'type'     => 'string',
					'enum'     => array('payroll', 'hr'),
					'default'  => 'payroll',
				),
			),
		)
	);
}

function wmcp_rest_generate(WP_REST_Request $request)
{
	$city      = sanitize_text_field($request->get_param('city'));
	$state     = sanitize_text_field($request->get_param('state'));
	$page_type = wmcp_normalize_page_type($request->get_param('page_type') ?: 'payroll');

	if (empty($city)) {
		return new WP_Error('wmcp_missing_city', 'City is required.', array('status' => 400));
	}

	$result = wmcp_generate_city_page($city, $state, $page_type);
	if (is_wp_error($result)) {
		return $result;
	}

	return rest_ensure_response(
		array(
			'source'     => $result['source'],
			'city'       => $city,
			'state'      => $state,
			'page_type'  => $page_type,
			'slug'       => $result['slug'] ?? '',
			'meta_title' => $result['meta_title'] ?? '',
			'cached'     => ('cache' === ($result['source'] ?? '')),
		)
	);
}
