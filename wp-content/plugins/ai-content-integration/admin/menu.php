<?php
defined('ABSPATH') || exit;

/* -------------------------------------------------------------------------
 * Dashboard widget
 * ------------------------------------------------------------------------- */

add_action('wp_dashboard_setup', 'wmcp_dashboard_widget');

function wmcp_dashboard_widget()
{
	if (! current_user_can('edit_posts')) {
		return;
	}
	wp_add_dashboard_widget('wmcp_stats', 'Ai Content Integration — Stats', 'wmcp_dashboard_widget_render');
}

function wmcp_dashboard_widget_render()
{
	$count = wmcp_cache_count();
	$rows  = wmcp_get_all_cache(20);

	echo '<p><strong>' . esc_html($count) . '</strong> cities generated.</p>';

	if (empty($rows)) {
		echo '<p>No city pages yet.</p>';
		return;
	}

	echo '<table class="widefat striped"><thead><tr><th>City</th><th>State</th><th>Type</th><th>Generated</th><th>Storage</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		$stored    = ! empty($row['page_html']) ? 'database' : 'legacy post';
		$page_type = wmcp_normalize_page_type($row['page_type'] ?? 'payroll');
		$page_id   = wmcp_get_trigger_page_id($page_type);
		$trigger_url = $page_id ? get_permalink($page_id) : home_url('/' . ('hr' === $page_type ? WMCP_TRIGGER_PAGE_HR : WMCP_TRIGGER_PAGE_PAYROLL) . '/');
		$city_url  = '';
		if (! empty($row['post_slug'])) {
			$settings  = wmcp_get_settings();
			$blog_base = trim((string) ($settings['base_blog_path'] ?? ''), '/');
			$path      = ('' !== $blog_base ? $blog_base . '/' : '') . $row['post_slug'];
			$city_url  = home_url('/' . $path . '/');
		}
		echo '<tr>';
		echo '<td>' . esc_html($row['city']) . '</td>';
		echo '<td>' . esc_html($row['state']) . '</td>';
		echo '<td>' . esc_html($page_type) . '</td>';
		echo '<td>' . esc_html($row['created_at']) . '</td>';
		echo '<td>' . esc_html($stored);
		if ($city_url) {
			echo ' &middot; <a href="' . esc_url($city_url) . '">View city page</a>';
		} else {
			echo ' &middot; <a href="' . esc_url($trigger_url) . '">Preview</a>';
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}
