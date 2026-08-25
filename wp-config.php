<?php
# Database Configuration
define( 'DB_NAME', 'wp_weekmate' );
define( 'DB_USER', 'weekmate' );
define( 'DB_PASSWORD', 'LEqVxfnRW6P14EWswJOk' );
define( 'DB_HOST', '127.0.0.1:3306' );
define( 'DB_HOST_SLAVE', '127.0.0.1:3306' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         '#6W=Oo6GLlZIn(wG)W5,Hpy&3DKbRnC?zBilZEh5c!8#_aKRGT(?B!3-1,8~qL6^');
define('SECURE_AUTH_KEY',  'KrJTGH&GiQ7XhU+DiI.UoyhMkIRWXP6lLwYPC_&jhnNtVME*!Wi)zn,b+H(JNwwY');
define('LOGGED_IN_KEY',    'ITeUSNRH0uhm0a1i_3o(xl~pwj3n)Z0%CH,e0#RbTB)DPyoQdy.cY*FTgm_1M%hG');
define('NONCE_KEY',        '4ga3*(Y&Aa@&b^=,)oplDBCU?kQAR*fQQN2IpH=uoT,K#AGpMhB$(2qel6S08zB7');
define('AUTH_SALT',        '!1n?6Z!2-X4~c_u.9(K=kSa@.kXc)AyT*bHkNqDHUgtK0Kl6LVsot9!#n_AZ#ePx');
define('SECURE_AUTH_SALT', 'Ue8HoZa2&.PHMqdW7*XE2C^CDp8LHibrcX*Ak27PtZ)Yseuu~_jLNtIn8kE_pFO8');
define('LOGGED_IN_SALT',   '-cx&TQv)Z808ABXyMGAc,ez-LR#PeY9KG,g#Kc.Aa3MDAc6G@KvLzV?N_@C_nc%~');
define('NONCE_SALT',       '8c7LUceh0UnsZGjq-p2mB#JmK+ent&^x)Zpr=-CyOc._R4iFou+Iyh4@%i9jviH8');


# Localized Language Stuff



define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'weekmate' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'WPE_APIKEY', 'c497377d2b0767db5bcdbae4d0797905a1300a28' );

define( 'WPE_CLUSTER_ID', '404135' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_SFTP_ENDPOINT', '34.168.163.159' );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', 250 ); // Configured by WP Engine

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'weekmate.in', 1 => 'weekmate.wpengine.com', 2 => 'weekmate.wpenginepowered.com', 3 => 'www.weekmate.in', );

$wpe_varnish_servers=array ( 0 => '127.0.0.1', );

$wpe_special_ips=array ( 0 => '35.197.101.236', 1 => 'pod-404135-utility.pod-404135.svc.cluster.local', );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );



define( 'WP_CACHE', TRUE );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', __DIR__ . '/');
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_AUTO_UPDATE_CORE', false );
define( 'AUTOMATIC_UPDATER_DISABLED', true );

add_action('current_screen', 'block_cf7_leads_page');
function block_cf7_leads_page($screen) {
    $allowed_users = array(8);
    if (in_array($screen->id, array('toplevel_page_cfdb7-list', 'flamingo_page_flamingo_inbound')) 
        && !in_array(get_current_user_id(), $allowed_users)) {
        wp_die('You do not have permission to access this page.');
    }
}

add_action('admin_menu', 'hide_cf7_leads_menu', 999);
function hide_cf7_leads_menu() {
    $allowed_users = array(8);
    if (!in_array(get_current_user_id(), $allowed_users)) {
        remove_menu_page('cfdb7-list.php'); // CFDB7 top-level menu
    }
}
