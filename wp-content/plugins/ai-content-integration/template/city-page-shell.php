<?php
/**
 * City page shell — WordPress header/footer wrapper.
 *
 * Override: copy to themes/your-theme/wmcp/city-page-shell.php
 *
 * @package WeekMate_City_Pages
 */

defined('ABSPATH') || exit;

$data      = isset($GLOBALS['wmcp_city_page_data']) ? $GLOBALS['wmcp_city_page_data'] : array();
$city      = isset($GLOBALS['wmcp_city_page_city']) ? $GLOBALS['wmcp_city_page_city'] : '';
$state     = isset($GLOBALS['wmcp_city_page_state']) ? $GLOBALS['wmcp_city_page_state'] : '';
$page_type = isset($GLOBALS['wmcp_city_page_type']) ? $GLOBALS['wmcp_city_page_type'] : 'payroll';

wmcp_enqueue_city_page_assets();

get_header();
?>
<?php
$content_template = wmcp_locate_template('city-page-content.php');
if ($content_template) {
	include $content_template;
}
?>
<script id="page-data" type="application/json"><?php echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
<?php
get_footer();
