<?php
defined('ABSPATH') || exit;

/**
 * Trigger pages mapped to page types (payroll vs HR + any custom types).
 *
 * @return array<string, array{slug: string, page_type: string, label: string}>
 */
function wmcp_get_trigger_configs()
{
	$built_in = array(
		'payroll' => array(
			'slug'      => WMCP_TRIGGER_PAGE_PAYROLL,
			'page_type' => 'payroll',
			'label'     => 'Payroll Software',
		),
		'hr'      => array(
			'slug'      => WMCP_TRIGGER_PAGE_HR,
			'page_type' => 'hr',
			'label'     => 'HR Software',
		),
	);

	$settings     = get_option(WMCP_OPTION_KEY, array());
	$custom_types = $settings['custom_page_types'] ?? array();
	$custom       = array();

	foreach ($custom_types as $key => $ct) {
		$key = sanitize_key($key);
		if ('' === $key || empty($ct['slug'])) {
			continue;
		}
		$custom[ $key ] = array(
			'slug'      => sanitize_title($ct['slug']),
			'page_type' => $key,
			'label'     => sanitize_text_field($ct['label'] ?? $key),
		);
	}

	return array_merge($built_in, $custom);
}

/**
 * Resolve a published trigger page ID by page type or slug.
 *
 * @param string $page_type_or_slug payroll|hr|payroll-software|hr-software
 * @return int
 */
function wmcp_get_trigger_page_id($page_type_or_slug = 'payroll')
{
	static $resolved = array();

	$key = sanitize_key($page_type_or_slug);
	if (isset($resolved[ $key ])) {
		return $resolved[ $key ];
	}

	foreach (wmcp_get_trigger_configs() as $config) {
		if ($config['page_type'] === $page_type_or_slug || $config['slug'] === $page_type_or_slug) {
			$page = get_page_by_path($config['slug'], OBJECT, 'page');
			$resolved[ $key ] = $page ? (int) $page->ID : 0;
			return $resolved[ $key ];
		}
	}

	$resolved[ $key ] = 0;
	return 0;
}

/**
 * Content, URL, and SEO definitions per page type (built-in + custom).
 *
 * @return array<string, array<string, mixed>>
 */
function wmcp_get_page_type_definitions()
{
	$built_in = array(
		'payroll' => array(
			'slug_prefix'      => 'payroll-software-in-',
			'loading_message'  => 'payroll landing page',
			'default_h1'       => 'Payroll Software in %s',
			'keywords'         => array(
				'Payroll Software',
				'Payroll Management',
				'Payroll Processing',
				'Payroll Compliance',
				'Salary Management',
				'Payroll Automation',
			),
		),
		'hr'      => array(
			'slug_prefix'      => 'hr-software-in-',
			'loading_message'  => 'HR software landing page',
			'default_h1'       => 'HR Software in %s',
			'keywords'         => array(
				'HR Software',
				'HRMS Software',
				'Employee Management Software',
				'Attendance Management',
				'Leave Management',
				'Workforce Management',
				'Employee Self Service',
				'HR Automation',
			),
		),
	);

	$settings     = get_option(WMCP_OPTION_KEY, array());
	$custom_types = $settings['custom_page_types'] ?? array();
	$custom       = array();

	foreach ($custom_types as $key => $ct) {
		$key = sanitize_key($key);
		if ('' === $key || empty($ct['slug_prefix'])) {
			continue;
		}
		$label = sanitize_text_field($ct['label'] ?? $key);
		$custom[ $key ] = array(
			'slug_prefix'      => sanitize_title($ct['slug_prefix']),
			'loading_message'  => sanitize_text_field($ct['label'] ?? $key) . ' landing page',
			'default_h1'       => sanitize_text_field($ct['label'] ?? $key) . ' in %s',
			'keywords'         => array_filter(array_map(
				'sanitize_text_field',
				explode(',', $ct['keywords'] ?? '')
			)),
		);
	}

	return array_merge($built_in, $custom);
}

/**
 * @param string $page_type payroll|hr
 * @return array<string, mixed>|null
 */
function wmcp_get_page_type_definition($page_type)
{
	$definitions = wmcp_get_page_type_definitions();
	return $definitions[ $page_type ] ?? null;
}

/**
 * @param string $page_type Raw page type value.
 * @return string Sanitized page type key.
 */
function wmcp_normalize_page_type($page_type)
{
	$page_type = sanitize_key((string) $page_type);

	// Built-in types.
	if ('hr' === $page_type) {
		return 'hr';
	}
	if ('payroll' === $page_type) {
		return 'payroll';
	}

	// Custom page type — check if it exists in saved settings.
	$settings     = get_option(WMCP_OPTION_KEY, array());
	$custom_types = $settings['custom_page_types'] ?? array();
	if (isset($custom_types[ $page_type ])) {
		return $page_type;
	}

	// Unknown type: fall back to payroll for safety.
	return 'payroll';
}

/**
 * Request path relative to the site home (and optional blog base).
 *
 * @return string
 */
function wmcp_get_request_path()
{
	if (empty($_SERVER['REQUEST_URI'])) {
		return '';
	}

	$path = trim((string) parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH), '/');
	$home = trim((string) parse_url(home_url('/'), PHP_URL_PATH), '/');

	if ('' !== $home && ($path === $home || 0 === strpos($path, $home . '/'))) {
		$path = trim(substr($path, strlen($home)), '/');
	}

	$settings  = wmcp_get_settings();
	$blog_base = trim((string) ($settings['base_blog_path'] ?? ''), '/');
	if ('' !== $blog_base && ($path === $blog_base || 0 === strpos($path, $blog_base . '/'))) {
		$path = trim(substr($path, strlen($blog_base)), '/');
	}

	return $path;
}

/**
 * Sanitize a city name into a URL slug segment.
 *
 * @param string $city City name.
 * @return string
 */
function wmcp_city_slug($city)
{
	return sanitize_title($city);
}

/**
 * Build the public city permalink for a page type.
 *
 * @param string $city      City name.
 * @param string $page_type payroll|hr
 * @return string
 */
function wmcp_city_permalink_url($city, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$config    = wmcp_get_page_type_definition($page_type);
	$prefix    = $config['slug_prefix'] ?? 'payroll-software-in-';
	$slug      = $prefix . wmcp_city_slug($city);
	$settings  = wmcp_get_settings();
	$blog_base = trim((string) ($settings['base_blog_path'] ?? ''), '/');
	$path      = ('' !== $blog_base ? $blog_base . '/' : '') . $slug;

	return home_url('/' . $path . '/');
}

/**
 * Convert a city slug from the URL into a display name.
 *
 * @param string $city_slug URL city segment.
 * @return string
 */
function wmcp_city_name_from_slug($city_slug)
{
	$city_slug = trim((string) $city_slug, '/');
	if ('' === $city_slug) {
		return '';
	}

	return ucwords(str_replace('-', ' ', $city_slug));
}

/**
 * Parse /hr-software-in-{city}/ or /payroll-software-in-{city}/ from the request.
 *
 * @return array{page_type: string, city_slug: string, city: string, state: string, post_slug: string}|null
 */
function wmcp_parse_city_permalink_from_request()
{
	$path = wmcp_get_request_path();
	if ('' === $path) {
		return null;
	}

	foreach (wmcp_get_page_type_definitions() as $page_type => $def) {
		$prefix = $def['slug_prefix'] ?? '';
		if ('' === $prefix) {
			continue;
		}

		$pattern = '#^' . preg_quote($prefix, '#') . '([^/]+)/?$#';
		if (! preg_match($pattern, $path, $matches)) {
			continue;
		}

		$city_slug = trim($matches[1], '/');
		if ('' === $city_slug) {
			continue;
		}

		return array(
			'page_type' => $page_type,
			'city_slug' => $city_slug,
			'city'      => wmcp_city_name_from_slug($city_slug),
			'state'     => '',
			'post_slug' => $prefix . $city_slug,
		);
	}

	return null;
}

/**
 * Detect trigger page or city permalink from the request URI (for cache plugins).
 */
function wmcp_request_matches_trigger_post()
{
	if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
		return false;
	}

	if (wmcp_parse_city_permalink_from_request()) {
		return true;
	}

	$path = wmcp_get_request_path();
	if ('' === $path) {
		return false;
	}

	foreach (wmcp_get_trigger_configs() as $config) {
		$slug = $config['slug'];
		if ($path === $slug || preg_match('#(^|/)' . preg_quote($slug, '#') . '/?$#', '/' . $path)) {
			return true;
		}
	}

	return false;
}

/**
 * Resolve page type from the current request URI (before $post exists).
 *
 * @return string payroll|hr
 */
function wmcp_get_page_type_from_request_uri()
{
	$parsed = wmcp_parse_city_permalink_from_request();
	if ($parsed) {
		return $parsed['page_type'];
	}

	$path = wmcp_get_request_path();
	if ('' === $path) {
		return 'payroll';
	}

	foreach (wmcp_get_trigger_configs() as $config) {
		$slug = $config['slug'];
		if ($path === $slug || preg_match('#(^|/)' . preg_quote($slug, '#') . '/?$#', '/' . $path)) {
			return $config['page_type'];
		}
	}

	return 'payroll';
}

/**
 * Prevent full-page cache from serving one city's HTML to every visitor.
 */
function wmcp_disable_page_cache()
{
	if (! defined('DONOTCACHEPAGE')) {
		define('DONOTCACHEPAGE', true);
	}
	if (! defined('DONOTROCKETCACHE')) {
		define('DONOTROCKETCACHE', true);
	}
	if (! defined('LSCACHE_NO_CACHE')) {
		define('LSCACHE_NO_CACHE', true);
	}
}

/**
 * Whether the given post is a trigger page.
 */
function wmcp_is_trigger_page($post)
{
	if (! $post || 'page' !== $post->post_type) {
		return false;
	}

	foreach (wmcp_get_trigger_configs() as $config) {
		$page_id = wmcp_get_trigger_page_id($config['page_type']);
		if ($page_id && (int) $post->ID === $page_id) {
			return true;
		}
		if ($post->post_name === $config['slug']) {
			return true;
		}
	}

	return false;
}

/**
 * Resolve page type from a trigger page object.
 *
 * @param WP_Post|null $post Page object.
 * @return string payroll|hr
 */
function wmcp_get_page_type_from_page($post)
{
	if (! $post) {
		return 'payroll';
	}

	foreach (wmcp_get_trigger_configs() as $config) {
		$page_id = wmcp_get_trigger_page_id($config['page_type']);
		if ((int) $post->ID === $page_id || $post->post_name === $config['slug']) {
			return $config['page_type'];
		}
	}

	return 'payroll';
}

/**
 * Current full request URL.
 *
 * @return string
 */
function wmcp_get_current_request_url()
{
	if (empty($_SERVER['HTTP_HOST']) || empty($_SERVER['REQUEST_URI'])) {
		return home_url('/');
	}

	$scheme = is_ssl() ? 'https' : 'http';

	return $scheme . '://' . wp_unslash($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
}

/**
 * Get the list of allowed city slugs for a page type, read from the ACF
 * field `wmcp_allowed_cities` on the trigger page.
 * Returns an empty array meaning "all cities allowed" (field not set / empty).
 *
 * @param string $page_type payroll|hr|custom
 * @return string[] Array of lowercase sanitized city slugs, or empty = allow all.
 */
function wmcp_get_allowed_cities($page_type)
{
	if (! function_exists('get_field')) {
		return array();
	}

	$page_id = wmcp_get_trigger_page_id($page_type);
	if ($page_id <= 0) {
		return array();
	}

	$rows = get_field('wmcp_allowed_cities', $page_id);

	// Repeater field — each row has 'city_name' sub-field.
	if (is_array($rows) && ! empty($rows)) {
		$cities = array();
		foreach ($rows as $row) {
			$name = trim($row['city_name'] ?? '');
			if ('' !== $name) {
				$cities[] = sanitize_title($name);
			}
		}
		return array_values(array_filter($cities));
	}

	// Fallback: old plain textarea format (comma-separated string).
	if (is_string($rows) && '' !== $rows) {
		$cities = array_map('sanitize_title', array_map('trim', explode(',', $rows)));
		return array_values(array_filter($cities));
	}

	return array();
}

/**
 * Check whether a city slug is allowed for a page type.
 * Returns true if the allowed list is empty (no restriction) or the slug is in the list.
 *
 * @param string $city_slug Sanitized city slug from the URL.
 * @param string $page_type payroll|hr|custom
 * @return bool
 */
function wmcp_city_is_allowed($city_slug, $page_type)
{
	$allowed = wmcp_get_allowed_cities($page_type);

	// Empty list = no restriction = allow all.
	if (empty($allowed)) {
		return true;
	}

	return in_array(sanitize_title($city_slug), $allowed, true);
}
