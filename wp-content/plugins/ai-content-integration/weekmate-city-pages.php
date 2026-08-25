<?php

/**
 * Plugin Name:       Ai Content Integration
 * Plugin URI:        https://weekmate.in
 * Description:       Auto-detects visitor IP, resolves city/state, calls Groq LLM, creates city-specific landing pages, and redirects visitors.
 * Version:           1.1.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            WeekMate
 * License:           GPL-2.0-or-later
 * Text Domain:       ai-content-integration
 */

if (! defined('ABSPATH')) {
	exit;
}

define('WMCP_VERSION', '1.1.0');
define('WMCP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WMCP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WMCP_TRIGGER_PAGE_PAYROLL', 'payroll-software');
define('WMCP_TRIGGER_PAGE_HR', 'hr-software');
define('WMCP_TABLE', 'wmcp_city_cache');
define('WMCP_OPTION_KEY', 'wmcp_settings');

/* -------------------------------------------------------------------------
 * Activation / deactivation
 * ------------------------------------------------------------------------- */

register_activation_hook(__FILE__, 'wmcp_activate');
register_deactivation_hook(__FILE__, 'wmcp_deactivate');

function wmcp_activate()
{
	global $wpdb;
	$table   = $wpdb->prefix . WMCP_TABLE;
	$charset = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$table} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		city_key varchar(191) NOT NULL,
		page_type varchar(20) NOT NULL DEFAULT 'payroll',
		city varchar(191) NOT NULL,
		state varchar(191) NOT NULL,
		post_id bigint(20) unsigned NOT NULL DEFAULT 0,
		post_slug varchar(191) NOT NULL,
		meta_title varchar(255) DEFAULT '',
		page_html longtext NULL,
		page_data longtext NULL,
		created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id),
		UNIQUE KEY city_page (city_key, page_type),
		KEY post_id (post_id),
		KEY page_type (page_type)
	) {$charset};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);
	wmcp_maybe_upgrade_db();

	if (false === get_option(WMCP_OPTION_KEY)) {
		add_option(WMCP_OPTION_KEY, wmcp_default_settings());
	}

	flush_rewrite_rules();
	delete_transient('wmcp_public_ip');
	delete_option('wmcp_migrated_public_ip_transient');

	if (function_exists('rocket_clean_domain')) {
		rocket_clean_domain();
	}
	if (function_exists('rocket_generate_config_file')) {
		rocket_generate_config_file();
	}
}

function wmcp_deactivate()
{
	flush_rewrite_rules();
}

require_once WMCP_PLUGIN_DIR . 'includes/logger.php';
require_once WMCP_PLUGIN_DIR . 'includes/helpers.php';
require_once WMCP_PLUGIN_DIR . 'includes/geo.php';
require_once WMCP_PLUGIN_DIR . 'includes/database.php';
require_once WMCP_PLUGIN_DIR . 'includes/cache.php';
require_once WMCP_PLUGIN_DIR . 'includes/prompts.php';
require_once WMCP_PLUGIN_DIR . 'includes/api.php';
require_once WMCP_PLUGIN_DIR . 'includes/templates.php';
require_once WMCP_PLUGIN_DIR . 'includes/assets.php';
require_once WMCP_PLUGIN_DIR . 'includes/router.php';
require_once WMCP_PLUGIN_DIR . 'admin/settings.php';
require_once WMCP_PLUGIN_DIR . 'admin/menu.php';
