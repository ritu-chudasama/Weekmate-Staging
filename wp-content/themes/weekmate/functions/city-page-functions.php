<?php
/**
 * City page logic — loaded via functions.php.
 * Template file (city-page-template.php) is HTML-only.
 *
 * @package WeekMate
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get the URL of the static fallback page for a page type.
 * hr      → /hr-software-static/
 * payroll → /payroll-software-static/
 *
 * Checks that the page exists and has at least one key ACF field filled.
 * Returns home_url('/') if the page is missing or ACF fields are empty.
 *
 * @param string $page_type payroll|hr
 * @return string URL
 */
function wmcp_get_static_fallback_page_url( $page_type = 'payroll' ) {
	$slug = ( 'hr' === wmcp_normalize_page_type( $page_type ) )
		? 'hr-software-static'
		: 'payroll-software-static';

	$page = get_page_by_path( $slug, OBJECT, 'page' );

	if ( ! $page || 'publish' !== $page->post_status ) {
		return home_url( '/' );
	}

	// Check at least one key ACF field has content.
	// Uses the actual field names stored on the static page.
	if ( function_exists( 'get_field' ) ) {
		$sections = get_field( 'fallback_hr_sections', $page->ID );
		if ( 'hr' !== wmcp_normalize_page_type( $page_type ) ) {
			$sections = get_field( 'fallback_payroll_sections', $page->ID );
		}
		if ( empty( $sections ) ) {
			return home_url( '/' );
		}
	}

	return get_permalink( $page->ID );
}

/**
 * Hook into wmcp_locate_template so the plugin's internal render path
 * (wmcp_render_city_page) uses city-page-template.php instead of the
 * plugin's template/ folder. This lets us delete the plugin's template/ folder.
 */
add_filter( 'wmcp_locate_template', function( $path, $file ) {
	if ( 'city-page-shell.php' === $file ) {
		$tpl = get_template_directory() . '/page-templates/city-page-template.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}
	return $path;
}, 10, 2 );

/**
 * Bootstrap the city page: resolve data, set headers, register wp_head action.
 * Called at the top of city-page-template.php before get_header().
 *
 * Returns array [ $data, $city, $state, $page_type, $img ] on success.
 * Calls get_header()/get_footer() and exits for fallback/redirect cases,
 * so the template can assume it always receives valid data.
 *
 * @return array{ 0: array, 1: string, 2: string, 3: string, 4: string }
 */
function wmcp_theme_bootstrap_city_page() {

	// Plugin inactive — render default page content and stop.
	if ( ! function_exists( 'wmcp_get_page_type_from_page' ) ) {
		get_header();
		if ( have_posts() ) { while ( have_posts() ) { the_post(); the_content(); } }
		get_footer();
		exit;
	}

	wmcp_disable_page_cache();

	// Called internally by plugin (wmcp_render_city_page) — globals pre-set.
	if ( ! empty( $GLOBALS['wmcp_city_page_data'] ) ) {
		$data      = wmcp_prepare_page_data(
			$GLOBALS['wmcp_city_page_data'],
			$GLOBALS['wmcp_city_page_city']  ?? '',
			$GLOBALS['wmcp_city_page_state'] ?? '',
			$GLOBALS['wmcp_city_page_type']  ?? 'payroll'
		);
		$city      = $GLOBALS['wmcp_city_page_city']  ?? '';
		$state     = $GLOBALS['wmcp_city_page_state'] ?? '';
		$page_type = $GLOBALS['wmcp_city_page_type']  ?? 'payroll';

	// Trigger page visit — detect IP, resolve city, redirect.
	} elseif ( ! wmcp_parse_city_permalink_from_request() ) {
		global $post;
		wmcp_theme_handle_trigger_page( $post ); // always exits

	// City permalink visit — resolve/generate data.
	} else {
		$parsed = wmcp_parse_city_permalink_from_request();

		if ( ! wmcp_city_is_allowed( $parsed['city_slug'], $parsed['page_type'] ) ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			nocache_headers();
			include get_query_template( '404' );
			exit;
		}

		$resolved  = wmcp_theme_resolve_city_data( $parsed );
		$data      = $resolved['data'];
		$city      = $resolved['city'];
		$state     = $resolved['state'];
		$page_type = $resolved['page_type'];
	}

	// Re-apply ACF heading overrides at render time so changes to ACF fields
	// take effect immediately without waiting for the cache to expire.
	if ( function_exists( 'wmcp_apply_fixed_headings' ) ) {
		$data = wmcp_apply_fixed_headings( $data, $city, $state, $page_type );
	}

	// SEO + request context.
	wmcp_setup_city_page_seo_filters( $data );
	wmcp_set_request_context( 'city',      $city );
	wmcp_set_request_context( 'state',     $state );
	wmcp_set_request_context( 'page_type', $page_type );

	$img = get_template_directory_uri() . '/images';

	// Expose image base URL to JS.
	add_action( 'wp_head', function() use ( $img ) {
		echo '<script>window.wmcpImgBase=' . wp_json_encode( $img ) . ';</script>' . "\n";
	}, 1 );

	// HTTP headers.
	status_header( 200 );
	nocache_headers();
	wmcp_send_debug_headers();
	header( 'Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0' );
	header( 'Vary: X-Forwarded-For, CF-Connecting-IP' );

	return array( $data, $city, $state, $page_type, $img );
}

/**
 * Resolve and prepare city page data from cache or generate fresh.
 * Returns array with keys: data, city, state, page_type.
 * Calls wmcp_output_error_page() on failure (never returns null).
 *
 * @param array  $parsed  Output of wmcp_parse_city_permalink_from_request().
 * @return array{data: array, city: string, state: string, page_type: string}
 */
function wmcp_theme_resolve_city_data( $parsed ) {
	$page_type = $parsed['page_type'];
	$city      = $parsed['city'];
	$state     = $parsed['state'];

	$cached = wmcp_get_cache_by_post_slug( $parsed['post_slug'], $page_type );
	if ( $cached ) {
		if ( ! empty( $cached['city'] ) && empty( $city ) ) { $city  = $cached['city'];  }
		if ( ! empty( $cached['state'] ) )                   { $state = $cached['state']; }
	}

	if ( $cached && wmcp_cache_row_is_renderable( $cached ) ) {
		if ( wmcp_cache_is_stale( $cached ) ) {
			wmcp_schedule_background_refresh( $city, $state, $page_type );
		}
	} else {
		$result = wmcp_generate_city_page( $city, $state, $page_type );
		if ( is_wp_error( $result ) ) {
			wmcp_output_error_page( $result->get_error_message() );
		}
		$cached = $result['cached']
			?? wmcp_get_cache( wmcp_city_key( $city, $state ), $page_type )
			?: wmcp_get_cache_by_post_slug( $parsed['post_slug'], $page_type );
		if ( ! $cached || ! wmcp_cache_row_is_renderable( $cached ) ) {
			wmcp_output_error_page( 'Page was generated but no content was returned.' );
		}
	}

	$data = wmcp_get_page_data_from_cache_row( $cached );
	if ( ! wmcp_is_valid_page_data( $data ) ) {
		wmcp_output_error_page( 'City page content could not be loaded.' );
	}

	return array(
		'data'      => wmcp_prepare_page_data( $data, $city, $state, $page_type ),
		'city'      => $city,
		'state'     => $state,
		'page_type' => $page_type,
	);
}

/**
 * Handle the trigger page visit (visitor hits /hr-software or /payroll-software).
 * Detects IP, resolves city, checks allowlist, redirects. Never returns normally.
 */
function wmcp_theme_handle_trigger_page( $post ) {
	$page_type = wmcp_get_page_type_from_page( $post );

	$ip = wmcp_get_visitor_ip();
	wmcp_set_request_context( 'ip', $ip );

	$city      = '';
	$state     = '';
	$geo_ok    = false;

	if ( ! empty( $ip ) ) {
		$location = wmcp_resolve_location( $ip );
		if ( ! is_wp_error( $location ) && ! empty( $location['city'] ) ) {
			$city   = $location['city'];
			$state  = $location['state'] ?? '';
			$geo_ok = true;
		}
	}

	// Geolocation failed — render static fallback page in-place (URL unchanged).
	if ( ! $geo_ok ) {
		wmcp_log( 'geolocation failed — rendering static fallback in-place', array( 'page_type' => $page_type ) );
		$fallback_slug = ( 'hr' === wmcp_normalize_page_type( $page_type ) ) ? 'hr-software-static' : 'payroll-software-static';
		$fallback_page = get_page_by_path( $fallback_slug, OBJECT, 'page' );
		if ( $fallback_page && 'publish' === $fallback_page->post_status ) {
			global $post, $wp_query;
			$post = $fallback_page;
			$wp_query->is_page = true; $wp_query->is_singular = true;
			$wp_query->queried_object = $fallback_page; $wp_query->queried_object_id = $fallback_page->ID;
			setup_postdata( $post );
			$tpl  = get_page_template_slug( $fallback_page->ID );
			$file = $tpl ? get_theme_file_path( $tpl ) : get_page_template();
			status_header( 200 ); nocache_headers();
			include( $file ?: get_index_template() );
			exit;
		}
		return; // static page not set up — fall through to WordPress default
	}

	if ( ! wmcp_city_is_allowed( wmcp_city_slug( $city ), $page_type ) ) {
		// City not in allowlist — show the trigger page content as-is.
		get_header();
		if ( have_posts() ) { while ( have_posts() ) { the_post(); the_content(); } }
		get_footer();
		exit;
	}

	wp_safe_redirect( wmcp_city_permalink_url( $city, $page_type ), 302 );
	exit;
}