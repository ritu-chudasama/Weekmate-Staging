<?php
defined('ABSPATH') || exit;

function wmcp_default_settings()
{
	return array(
		'groq_api_key'       => '',
		'groq_model'         => 'llama-3.3-70b-versatile',
		'post_status'        => 'publish',
		'base_blog_path'     => '',
		'category_slug'      => 'blog',
		'ai_provider'        => 'groq',
		'openai_api_key'     => '',
		'claude_api_key'     => '',
		'custom_page_types'  => array(),
	);
}

function wmcp_get_settings()
{
	return wp_parse_args(get_option(WMCP_OPTION_KEY, array()), wmcp_default_settings());
}

add_action('plugins_loaded', 'wmcp_maybe_upgrade_db');

/**
 * Add page_html / page_data / page_type columns on existing installs.
 */
function wmcp_maybe_upgrade_db()
{
	global $wpdb;
	$table = $wpdb->prefix . WMCP_TABLE;
	if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table)) !== $table) {
		return;
	}
	$cols = $wpdb->get_col("DESCRIBE {$table}", 0);
	if (! in_array('page_html', $cols, true)) {
		$wpdb->query("ALTER TABLE {$table} ADD COLUMN page_html LONGTEXT NULL AFTER meta_title");
	}
	if (! in_array('page_data', $cols, true)) {
		$wpdb->query("ALTER TABLE {$table} ADD COLUMN page_data LONGTEXT NULL AFTER page_html");
	}
	if (! in_array('page_type', $cols, true)) {
		$wpdb->query("ALTER TABLE {$table} ADD COLUMN page_type varchar(20) NOT NULL DEFAULT 'payroll' AFTER city_key");
		$indexes = $wpdb->get_results("SHOW INDEX FROM {$table}", ARRAY_A);
		$key_names = array();
		foreach ($indexes as $index) {
			$key_names[ $index['Key_name'] ] = true;
		}
		if (! empty($key_names['city_key'])) {
			$wpdb->query("ALTER TABLE {$table} DROP INDEX city_key");
		}
		if (empty($key_names['city_page'])) {
			$wpdb->query("ALTER TABLE {$table} ADD UNIQUE KEY city_page (city_key, page_type)");
		}
	}

	// One-time fix: clear the stored base_blog_path if it was set to 'blog'
	// (the old default), so city URLs are no longer prefixed with /blog/.
	if (! get_option('wmcp_migrated_clear_blog_base')) {
		$saved = get_option(WMCP_OPTION_KEY, array());
		if (is_array($saved) && isset($saved['base_blog_path']) && 'blog' === $saved['base_blog_path']) {
			$saved['base_blog_path'] = '';
			update_option(WMCP_OPTION_KEY, $saved);
		}
		update_option('wmcp_migrated_clear_blog_base', 1, false);
	}
}

function wmcp_ensure_category($slug)
{
	$term = get_term_by('slug', $slug, 'category');
	if ($term) {
		return (int) $term->term_id;
	}
	$result = wp_insert_term(ucfirst($slug), 'category', array('slug' => $slug));
	if (is_wp_error($result)) {
		return 0;
	}
	return (int) $result['term_id'];
}

function wmcp_find_city_post($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$posts     = get_posts(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_query'             => array(
				'relation' => 'AND',
				array(
					'key'   => '_wmcp_city',
					'value' => $city,
				),
				array(
					'key'   => '_wmcp_state',
					'value' => $state,
				),
				array(
					'key'   => '_wmcp_page_type',
					'value' => $page_type,
				),
			),
		)
	);

	return ! empty($posts[0]) ? $posts[0] : null;
}
