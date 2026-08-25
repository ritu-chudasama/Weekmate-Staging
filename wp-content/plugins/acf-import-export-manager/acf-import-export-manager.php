<?php
/**
 * Plugin Name: ACF Data Manager
 * Plugin URI:  https://store.elsner.com/
 * Description: Export and Import ACF field data page-wise, post-wise, any cpt-wise, and group-wise.
 * Version:     1.0.0
 * Author:      Elsner
 * Author URI:  https://elsner.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: acf-data-manager
 * Requires PHP: 7.0
 * Requires at least: 6.6
 * Domain Path: /languages
 * 
 * @package ACF_Data_Manager
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'ACF_DM_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_DM_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_DM_VERSION', '1.0.0' );

// Include necessary files
require_once ACF_DM_PATH . 'includes/admin-menu.php';
require_once ACF_DM_PATH . 'includes/export-functions.php';
require_once ACF_DM_PATH . 'includes/import-functions.php';

// Register activation/deactivation hooks
register_activation_hook( __FILE__, 'acf_dm_plugin_activation' );
register_deactivation_hook( __FILE__, 'acf_dm_plugin_deactivation' );
register_uninstall_hook( __FILE__, 'acf_dm_plugin_uninstall' );

/**
 * Plugin activation callback.
 */
function acf_dm_plugin_activation() {
    // Activation code if needed
}

/**
 * Plugin deactivation callback.
 */
function acf_dm_plugin_deactivation() {
    // Deactivation code if needed
}

/**
 * Plugin uninstallation callback.
 */
function acf_dm_plugin_uninstall() {
    // Cleanup options or other data if needed
    // delete_option('some_option');
}

add_action( 'admin_init', 'acf_dm_check_acf_active' );
/**
 * Check if ACF is active.
 */
function acf_dm_check_acf_active() {
    if ( ! class_exists( 'ACF' ) ) {
        // Deactivate this plugin
        deactivate_plugins( plugin_basename( __FILE__ ) );
        
        // Show admin notice
        add_action( 'admin_notices', 'acf_dm_show_admin_notice' );
        
        // Prevent plugin from activating without ACF
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}

/**
 * Show admin notice if ACF is not active.
 */
function acf_dm_show_admin_notice() {
    if ( ! class_exists( 'ACF' ) ) {
        $class = 'notice notice-error is-dismissible';
        $message = __( '<strong>ACF Data Manager</strong> requires Advanced Custom Fields plugin to be installed and active.', 'acf-data-manager' );
        
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
    }
}

add_action( 'plugins_loaded', 'acf_dm_load_textdomain' );
/**
 * Load plugin textdomain.
 */
function acf_dm_load_textdomain() {
    load_plugin_textdomain( 'acf-data-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}