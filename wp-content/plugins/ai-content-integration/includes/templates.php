<?php
defined('ABSPATH') || exit;

/* -------------------------------------------------------------------------
 * Template hydration & reusable city page templates
 * ------------------------------------------------------------------------- */

/**
 * Locate a city page template file (theme override: themes/your-theme/wmcp/{file}).
 *
 * @param string $file Template filename.
 * @return string Absolute path or empty string.
 */
function wmcp_locate_template($file)
{
	$theme_path = locate_template('wmcp/' . $file);
	if ($theme_path) {
		return (string) apply_filters('wmcp_locate_template', $theme_path, $file);
	}

	$plugin_path = WMCP_PLUGIN_DIR . 'template/' . $file;
	if (file_exists($plugin_path)) {
		return (string) apply_filters('wmcp_locate_template', $plugin_path, $file);
	}

	return (string) apply_filters('wmcp_locate_template', '', $file);
}

/**
 * @param string $file Template filename.
 * @return string Public URL or empty string.
 */
function wmcp_locate_template_uri($file)
{
	if (locate_template('wmcp/' . $file)) {
		return get_stylesheet_directory_uri() . '/wmcp/' . $file;
	}

	$plugin_path = WMCP_PLUGIN_DIR . 'template/' . $file;
	if (file_exists($plugin_path)) {
		return WMCP_PLUGIN_URL . 'template/' . $file;
	}

	return '';
}

/**
 * Normalize and apply fixed SEO headings for a city page.
 *
 * @param array<string, mixed> $data Page data.
 * @param string               $city City name.
 * @param string               $state State name.
 * @param string               $page_type payroll|hr
 * @return array<string, mixed>
 */
function wmcp_prepare_page_data($data, $city = '', $state = '', $page_type = 'payroll')
{
	$data = wmcp_normalize_ai_response($data);
	if ($city) {
		$data = wmcp_apply_fixed_headings($data, $city, $state, $page_type);
	}

	return $data;
}

/**
 * Register document title, meta description, and FAQ JSON-LD for city pages.
 *
 * @param array<string, mixed> $data Page data.
 */
function wmcp_setup_city_page_seo_filters($data)
{
	static $done = false;
	if ($done) {
		return;
	}
	$done = true;

	add_filter(
		'document_title_parts',
		function ($parts) use ($data) {
			if (! empty($data['meta']['meta_title'])) {
				$parts['title'] = wp_strip_all_tags($data['meta']['meta_title']);
			}
			return $parts;
		},
		20
	);

	add_filter(
		'pre_get_document_title',
		function ($title) use ($data) {
			if (! empty($data['meta']['meta_title'])) {
				return wp_strip_all_tags($data['meta']['meta_title']);
			}
			return $title;
		},
		20
	);

	add_action(
		'wp_head',
		function () use ($data) {
			if (! empty($data['meta']['meta_description'])) {
				echo '<meta name="description" content="' . esc_attr($data['meta']['meta_description']) . "\" />\n";
			}
		},
		1
	);

	add_action(
		'wp_head',
		function () use ($data) {
			$faq_ld = wmcp_build_faq_jsonld($data);
			echo '<script type="application/ld+json">' . wp_json_encode($faq_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
		},
		20
	);
}

/**
 * Enqueue reusable city page assets (override CSS/JS via theme wmcp/ folder).
 */
function wmcp_enqueue_city_page_assets()
{
	wp_enqueue_style(
		'wmcp-city-page-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap',
		array(),
		null
	);

	$css_uri = wmcp_locate_template_uri('city-page-styles.css');
	if ($css_uri) {
		wp_enqueue_style('wmcp-city-page', $css_uri, array('wmcp-city-page-fonts'), WMCP_VERSION);
	}

	$js_uri = wmcp_locate_template_uri('city-page-hydrate.js');
	if ($js_uri) {
		wp_enqueue_script('wmcp-city-page-hydrate', $js_uri, array(), WMCP_VERSION, true);
	}
}

/**
 * Render a city page using get_header() / get_footer() and reusable templates.
 *
 * @param array<string, mixed> $data Page data.
 * @param string               $city City name.
 * @param string               $state State name.
 * @param string               $page_type payroll|hr
 */
function wmcp_render_city_page($data, $city = '', $state = '', $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$data      = wmcp_prepare_page_data($data, $city, $state, $page_type);

	$GLOBALS['wmcp_city_page_data']      = $data;
	$GLOBALS['wmcp_city_page_city']      = $city;
	$GLOBALS['wmcp_city_page_state']     = $state;
	$GLOBALS['wmcp_city_page_type']      = $page_type;
	$GLOBALS['wmcp_city_page_rendering'] = true;

	wmcp_setup_city_page_seo_filters($data);

	$shell = wmcp_locate_template('city-page-shell.php');
	if (! $shell) {
		wmcp_output_error_page('City page template is missing.');
	}

	include $shell;
}

/**
 * @param array<string, mixed> $cached Cache row.
 * @return array<string, mixed>
 */
function wmcp_get_page_data_from_cache_row($cached)
{
	$data = array();
	if (! empty($cached['page_data'])) {
		$decoded = json_decode($cached['page_data'], true);
		if (is_array($decoded)) {
			$data = $decoded;
		}
	}

	if (! empty($data) && ! empty($cached['city'])) {
		$data = wmcp_prepare_page_data(
			$data,
			$cached['city'],
			$cached['state'] ?? '',
			$cached['page_type'] ?? 'payroll'
		);
	}

	return $data;
}

/**
 * @param array<string, mixed> $cached Cache row.
 */
function wmcp_render_city_page_from_cache_row($cached)
{
	$data = wmcp_get_page_data_from_cache_row($cached);
	if (! wmcp_is_valid_page_data($data)) {
		wmcp_output_error_page('City page content could not be loaded.');
	}

	wmcp_render_city_page(
		$data,
		$cached['city'] ?? '',
		$cached['state'] ?? '',
		$cached['page_type'] ?? 'payroll'
	);
}

function wmcp_get_template_html()
{
	$path = WMCP_PLUGIN_DIR . 'template/city-page.html';
	if (file_exists($path)) {
		return file_get_contents($path);
	}
	return wmcp_fallback_template();
}

/**
 * Legacy HTML builder (used by post-repair helpers).
 */
function wmcp_hydrate_template($data, $city = '', $state = '', $page_type = 'payroll')
{
	ob_start();
	wmcp_render_city_page($data, $city, $state, $page_type);
	return ob_get_clean();
}

function wmcp_build_faq_jsonld($data)
{
	$items = $data['sections']['faqs']['items'] ?? array();
	$entities = array();

	foreach ($items as $faq) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $faq['question'] ?? '',
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $faq['answer'] ?? '',
			),
		);
	}

	return array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	);
}

function wmcp_fallback_template()
{
	return '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/><title>WeekMate HRMS</title><meta name="description" content=""/></head><body><main><h1 data-field="meta.h1"></h1><p data-field="meta.meta_description"></p></main><script id="page-data" type="application/json">{}</script></body></html>';
}

function wmcp_output_loading_page($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$config    = wmcp_get_page_type_definition($page_type);
	$label     = $config['loading_message'] ?? 'city landing page';

	status_header(200);
	nocache_headers();
	header('Content-Type: text/html; charset=utf-8');
	header('X-Accel-Buffering: no');

	$city_esc  = esc_html($city);
	$state_esc = esc_html($state);

	// Send spinner HTML but keep the connection open (no fastcgi_finish_request).
	// Generation runs on the same request; we append a JS redirect when done.
	while (ob_get_level()) {
		ob_end_flush();
	}

	echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>';
	echo '<title>Generating your city page…</title>';
	echo '<style>body{font-family:system-ui,sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;background:#F5F7FB;color:#14203B}';
	echo '.box{text-align:center;padding:40px;max-width:420px}.spin{width:40px;height:40px;border:3px solid #E4E8F1;border-top-color:#3551E6;border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 20px}';
	echo '@keyframes spin{to{transform:rotate(360deg)}}p{color:#5A6680;line-height:1.6}</style></head><body><div class="box" id="wmcp-box">';
	echo '<div class="spin" id="wmcp-spin"></div><h1></h1>';
	// echo "<p>Creating a {$label} for <strong>{$city_esc}, {$state_esc}</strong>. This usually takes 15–45 seconds on first visit.</p>";
	echo '</div>';

	// Pad so Apache/proxy buffers flush the spinner to the browser immediately.
	echo str_repeat(' ', 2048);
	flush();
}

/**
 * Complete a loading-page response by redirecting to the city permalink.
 */
function wmcp_finish_with_html($html = '')
{
	unset($html);
	wmcp_finish_with_redirect(wmcp_get_current_request_url());
}

/**
 * Output a city landing page with theme header/footer and stop WordPress theme rendering.
 *
 * @param array<string, mixed>|string $cached_or_html Cache row or legacy full HTML.
 */
function wmcp_output_city_page($cached_or_html)
{
	status_header(200);
	nocache_headers();
	wmcp_send_debug_headers();
	header('Content-Type: text/html; charset=utf-8');
	header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0');
	header('Vary: X-Forwarded-For, CF-Connecting-IP');

	if (is_string($cached_or_html)) {
		if ('wp_template' === $cached_or_html) {
			wmcp_output_error_page('City page data is missing.');
		}
		if (false !== stripos($cached_or_html, '<html')) {
			echo $cached_or_html;
			exit;
		}
	}

	if (is_array($cached_or_html)) {
		if (! empty($cached_or_html['page_html']) && false !== stripos($cached_or_html['page_html'], '<html')) {
			echo $cached_or_html['page_html'];
			exit;
		}

		wmcp_render_city_page_from_cache_row($cached_or_html);
		exit;
	}

	wmcp_output_error_page('City page could not be rendered.');
}

/**
 * Complete a loading-page response with a client-side redirect (same HTTP connection).
 */
function wmcp_finish_with_redirect($url)
{
	$safe_url = esc_url_raw($url);
	echo '<script>window.location.replace(' . wp_json_encode($safe_url) . ');</script>';
	echo '</body></html>';
	exit;
}

/**
 * Show an error on the loading page without requiring a refresh.
 */
function wmcp_finish_with_error($message)
{
	$msg = esc_js(wp_strip_all_tags($message));
	echo '<script>';
	echo 'var b=document.getElementById("wmcp-box");';
	echo 'if(b){b.innerHTML="<h1>Could not generate page</h1><p>' . $msg . '</p>";}';
	echo 'var s=document.getElementById("wmcp-spin");if(s){s.remove();}';
	echo '</script></body></html>';
	exit;
}

function wmcp_output_error_page($message)
{
	status_header(503);
	nocache_headers();
	header('Content-Type: text/html; charset=utf-8');

	$msg     = esc_html($message);
	$is_admin = current_user_can('manage_options');
	$settings_link = $is_admin
		? '<p><a href="' . esc_url(admin_url('options-general.php?page=weekmate-city-pages')) . '">Open Ai Content Integration settings</a></p>'
		: '';

	echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>';
	echo '<title>City page could not be generated</title>';
	echo '<style>body{font-family:system-ui,sans-serif;max-width:520px;margin:60px auto;padding:0 24px;color:#14203B;line-height:1.6}';
	echo 'code{background:#F5F7FB;padding:2px 6px;border-radius:4px}</style></head><body>';
	echo '<h1>City page could not be generated</h1><p>' . $msg . '</p>' . $settings_link;
	echo '</body></html>';
	exit;
}
