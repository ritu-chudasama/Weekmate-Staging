<?php
defined('ABSPATH') || exit;

/* -------------------------------------------------------------------------
 * WordPress post creation
 * ------------------------------------------------------------------------- */

function wmcp_update_city_post($post_id, $data, $city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$config    = wmcp_get_page_type_definition($page_type);
	$settings  = wmcp_get_settings();
	$slug      = sanitize_title($data['meta']['url_slug'] ?? '');
	$html      = wmcp_hydrate_template($data, $city, $state, $page_type);
	$default_h1 = sprintf($config['default_h1'] ?? 'Payroll Software in %s', $city);

	if (empty($slug)) {
		return new WP_Error('wmcp_no_slug', 'Generated content missing url_slug.');
	}

	$updated = wp_update_post(
		array(
			'ID'           => $post_id,
			'post_title'   => $data['meta']['h1'] ?? $default_h1,
			'post_name'    => $slug,
			'post_content' => '<!-- WeekMate city page -->',
			'post_status'  => $settings['post_status'],
		),
		true
	);

	if (is_wp_error($updated)) {
		return $updated;
	}

	update_post_meta($post_id, '_wmcp_html', $html);
	update_post_meta($post_id, '_wmcp_page_data', wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

	$meta_title = $data['meta']['meta_title'] ?? '';
	$meta_desc  = $data['meta']['meta_description'] ?? '';

	update_post_meta($post_id, '_yoast_wpseo_title', $meta_title);
	update_post_meta($post_id, '_yoast_wpseo_metadesc', $meta_desc);
	update_post_meta($post_id, 'rank_math_title', $meta_title);
	update_post_meta($post_id, 'rank_math_description', $meta_desc);
	update_post_meta($post_id, '_wmcp_city', $city);
	update_post_meta($post_id, '_wmcp_state', $state);
	update_post_meta($post_id, '_wmcp_page_type', $page_type);
	update_post_meta($post_id, '_wmcp_generated', 1);

	return $post_id;
}

function wmcp_create_city_post($data, $city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$config    = wmcp_get_page_type_definition($page_type);
	$existing  = wmcp_find_city_post($city, $state, $page_type);
	if ($existing) {
		return wmcp_update_city_post($existing->ID, $data, $city, $state, $page_type);
	}
	$settings   = wmcp_get_settings();
	$slug       = sanitize_title($data['meta']['url_slug'] ?? '');
	$default_h1 = sprintf($config['default_h1'] ?? 'Payroll Software in %s', $city);

	if (empty($slug)) {
		return new WP_Error('wmcp_no_slug', 'Generated content missing url_slug.');
	}

	$html    = wmcp_hydrate_template($data, $city, $state, $page_type);
	$cat_id  = wmcp_ensure_category($settings['category_slug']);

	// post_content is kses-stripped by WordPress (removes <style>, <script>, <!DOCTYPE>).
	// Store the full HTML in post meta and keep a minimal placeholder in post_content.
	$postarr = array(
		'post_title'   => $data['meta']['h1'] ?? $default_h1,
		'post_name'    => $slug,
		'post_content' => '<!-- WeekMate city page -->',
		'post_status'  => $settings['post_status'],
		'post_type'    => 'post',
		'post_author'  => get_current_user_id() ?: 1,
	);

	if ($cat_id) {
		$postarr['post_category'] = array($cat_id);
	}

	$post_id = wp_insert_post($postarr, true);
	if (is_wp_error($post_id)) {
		return $post_id;
	}

	update_post_meta($post_id, '_wmcp_html', $html);
	update_post_meta($post_id, '_wmcp_page_data', wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

	$meta_title = $data['meta']['meta_title'] ?? '';
	$meta_desc  = $data['meta']['meta_description'] ?? '';

	update_post_meta($post_id, '_yoast_wpseo_title', $meta_title);
	update_post_meta($post_id, '_yoast_wpseo_metadesc', $meta_desc);
	update_post_meta($post_id, 'rank_math_title', $meta_title);
	update_post_meta($post_id, 'rank_math_description', $meta_desc);
	update_post_meta($post_id, '_wmcp_city', $city);
	update_post_meta($post_id, '_wmcp_state', $state);
	update_post_meta($post_id, '_wmcp_page_type', $page_type);
	update_post_meta($post_id, '_wmcp_generated', 1);

	return $post_id;
}

/**
 * Full HTML for a generated city page (stored in meta to avoid kses stripping).
 */
function wmcp_get_post_html($post_id)
{
	$html = get_post_meta($post_id, '_wmcp_html', true);
	if (is_string($html) && '' !== $html) {
		return $html;
	}

	// Legacy fallback: content saved before meta-storage fix.
	$post = get_post($post_id);
	if ($post && is_string($post->post_content)) {
		return $post->post_content;
	}

	return '';
}

/**
 * Re-hydrate HTML from stored JSON for posts created before the meta fix.
 */
function wmcp_repair_post_html($post_id)
{
	$raw = get_post_meta($post_id, '_wmcp_page_data', true);
	if (! is_string($raw) || '' === $raw) {
		return false;
	}
	$data = json_decode($raw, true);
	if (! is_array($data) || empty($data['meta']['url_slug'])) {
		return false;
	}
	$city      = get_post_meta($post_id, '_wmcp_city', true);
	$state     = get_post_meta($post_id, '_wmcp_state', true);
	$page_type = wmcp_normalize_page_type(get_post_meta($post_id, '_wmcp_page_type', true));
	$html      = wmcp_hydrate_template($data, $city, $state, $page_type);
	update_post_meta($post_id, '_wmcp_html', $html);
	return $html;
}

/* -------------------------------------------------------------------------
 * Full-width city pages (strip theme wrapper when possible)
 * ------------------------------------------------------------------------- */

add_filter('the_content', 'wmcp_filter_city_page_content', 1);

function wmcp_filter_city_page_content($content)
{
	if (! is_singular('post')) {
		return $content;
	}
	global $post;
	if (! $post || ! get_post_meta($post->ID, '_wmcp_generated', true)) {
		return $content;
	}
	// Never pass raw HTML through the theme content filters.
	return '';
}

add_action('template_redirect', 'wmcp_render_full_page', 99);

function wmcp_render_full_page()
{
	if (! is_singular('post')) {
		return;
	}
	global $post;
	if (! $post || ! get_post_meta($post->ID, '_wmcp_generated', true)) {
		return;
	}

	$content = wmcp_get_post_html($post->ID);

	// Auto-repair posts generated before HTML was stored in meta.
	if ('' === $content || false === strpos($content, '<!DOCTYPE html>')) {
		$repaired = wmcp_repair_post_html($post->ID);
		if ($repaired) {
			$content = $repaired;
		}
	}

	if ('' === $content) {
		$city      = get_post_meta($post->ID, '_wmcp_city', true);
		$state     = get_post_meta($post->ID, '_wmcp_state', true);
		$page_type = wmcp_normalize_page_type(get_post_meta($post->ID, '_wmcp_page_type', true));
		if ($city) {
			wmcp_delete_cache(wmcp_city_key($city, $state), $page_type);
		}
		$trigger_slug = 'hr' === $page_type ? WMCP_TRIGGER_PAGE_HR : WMCP_TRIGGER_PAGE_PAYROLL;
		wmcp_output_error_page(
			'This city page is missing its HTML content. Visit the trigger page to regenerate it: ' .
				esc_html(home_url('/' . $trigger_slug . '/'))
		);
	}

	status_header(200);
	nocache_headers();
	header('Content-Type: text/html; charset=utf-8');
	echo $content;
	exit;
}
