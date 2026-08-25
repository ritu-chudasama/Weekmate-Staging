<?php
defined('ABSPATH') || exit;

/* -------------------------------------------------------------------------
 * City key / cache
 * ------------------------------------------------------------------------- */

function wmcp_city_key($city, $state)
{
	$combined = strtolower(trim($city) . '-' . trim($state));
	return sanitize_title($combined);
}

function wmcp_get_cache($city_key, $page_type = 'payroll')
{
	global $wpdb;
	$table     = $wpdb->prefix . WMCP_TABLE;
	$page_type = wmcp_normalize_page_type($page_type);
	$sql       = $wpdb->prepare(
		"SELECT * FROM {$table} WHERE city_key = %s AND page_type = %s LIMIT 1",
		$city_key,
		$page_type
	);

	wmcp_log('database city cache lookup', array(
		'city_key'  => $city_key,
		'page_type' => $page_type,
		'sql'       => $sql,
	));

	$row = $wpdb->get_row($sql, ARRAY_A);

	wmcp_log('database city cache lookup result', array(
		'city_key'  => $city_key,
		'page_type' => $page_type,
		'found'     => (bool) $row,
		'city'      => is_array($row) ? ($row['city'] ?? '') : '',
		'state'     => is_array($row) ? ($row['state'] ?? '') : '',
	));

	return $row;
}

/**
 * Look up a cached city page by its public permalink slug.
 *
 * @param string $post_slug Permalink slug, e.g. hr-software-in-pune.
 * @param string $page_type payroll|hr
 * @return array<string, mixed>|null
 */
function wmcp_get_cache_by_post_slug($post_slug, $page_type = 'payroll')
{
	global $wpdb;
	$table     = $wpdb->prefix . WMCP_TABLE;
	$page_type = wmcp_normalize_page_type($page_type);
	$post_slug = sanitize_title($post_slug);

	if ('' === $post_slug) {
		return null;
	}

	$sql = $wpdb->prepare(
		"SELECT * FROM {$table} WHERE post_slug = %s AND page_type = %s LIMIT 1",
		$post_slug,
		$page_type
	);

	$row = $wpdb->get_row($sql, ARRAY_A);

	return is_array($row) ? $row : null;
}

function wmcp_save_cache($city_key, $city, $state, $post_slug, $meta_title, $page_html, $page_data, $post_id = 0, $page_type = 'payroll')
{
	global $wpdb;
	$table     = $wpdb->prefix . WMCP_TABLE;
	$page_type = wmcp_normalize_page_type($page_type);

	$wpdb->replace(
		$table,
		array(
			'city_key'   => $city_key,
			'page_type'  => $page_type,
			'city'       => $city,
			'state'      => $state,
			'post_id'    => (int) $post_id,
			'post_slug'  => $post_slug,
			'meta_title' => $meta_title,
			'page_html'  => $page_html,
			'page_data'  => $page_data,
			'created_at' => current_time('mysql'),
		),
		array('%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s')
	);
}

/**
 * HTML stored in the city cache table (primary) or legacy WP post meta.
 */
function wmcp_get_cache_html($cached)
{
	if (! is_array($cached)) {
		return '';
	}

	if (! empty($cached['page_html']) && false !== stripos($cached['page_html'], '<html')) {
		return $cached['page_html'];
	}

	if (wmcp_cache_row_is_renderable($cached)) {
		return 'wp_template';
	}

	if (! empty($cached['post_id'])) {
		$html = wmcp_get_post_html((int) $cached['post_id']);
		if ('' !== $html) {
			return $html;
		}
	}

	return '';
}

function wmcp_delete_cache($city_key, $page_type = null)
{
	global $wpdb;
	$table = $wpdb->prefix . WMCP_TABLE;
	if (null === $page_type) {
		$wpdb->delete($table, array('city_key' => $city_key), array('%s'));
		return;
	}
	$wpdb->delete(
		$table,
		array(
			'city_key'  => $city_key,
			'page_type' => wmcp_normalize_page_type($page_type),
		),
		array('%s', '%s')
	);
}

/**
 * Whether cached city content exists and is renderable.
 */
function wmcp_cache_is_usable($city_key, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$cached    = wmcp_get_cache($city_key, $page_type);
	if (! $cached) {
		wmcp_log('city cache miss (no row)', array(
			'city_key'  => $city_key,
			'page_type' => $page_type,
		));
		return false;
	}

	if (($cached['city_key'] ?? '') !== $city_key) {
		wmcp_log('city cache key mismatch — treating as miss', array(
			'expected' => $city_key,
			'actual'   => $cached['city_key'] ?? '',
		));
		return false;
	}

	if (wmcp_normalize_page_type($cached['page_type'] ?? 'payroll') !== $page_type) {
		wmcp_log('city cache page_type mismatch — treating as miss', array(
			'expected' => $page_type,
			'actual'   => $cached['page_type'] ?? '',
		));
		return false;
	}

	$usable = wmcp_cache_row_is_renderable($cached);
	wmcp_log($usable ? 'city cache hit (renderable)' : 'city cache row exists but content unusable', array(
		'city_key'  => $city_key,
		'page_type' => $page_type,
		'city'      => $cached['city'] ?? '',
	));

	return $usable;
}

/**
 * Legacy: whether an old WP post-based city page is still valid.
 */
function wmcp_is_valid_city_post($post_id)
{
	$post_id = (int) $post_id;
	if ($post_id <= 0) {
		return false;
	}

	$post = get_post($post_id);
	if (! $post || 'post' !== $post->post_type || 'publish' !== $post->post_status) {
		return false;
	}

	if (! get_post_meta($post_id, '_wmcp_generated', true)) {
		return false;
	}

	$html = wmcp_get_post_html($post_id);
	if ('' === $html) {
		$html = wmcp_repair_post_html($post_id);
	}

	return is_string($html) && '' !== $html && false !== stripos($html, '<html');
}

function wmcp_flush_cache()
{
	global $wpdb;
	$table = $wpdb->prefix . WMCP_TABLE;
	$wpdb->query("TRUNCATE TABLE {$table}");
}

function wmcp_get_all_cache($limit = 20)
{
	global $wpdb;
	$table = $wpdb->prefix . WMCP_TABLE;

	return $wpdb->get_results(
		$wpdb->prepare("SELECT * FROM {$table} ORDER BY created_at DESC LIMIT %d", $limit),
		ARRAY_A
	);
}

function wmcp_cache_count()
{
	global $wpdb;
	$table = $wpdb->prefix . WMCP_TABLE;
	return (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
}

/* -------------------------------------------------------------------------
 * Lazy cache refresh — stale-while-revalidate (30-day TTL)
 * ------------------------------------------------------------------------- */

/**
 * Number of seconds before a cached city page is considered stale.
 * Default: 30 days. Override via filter wmcp_cache_ttl_seconds.
 *
 * @return int
 */
function wmcp_cache_ttl()
{
	return (int) apply_filters('wmcp_cache_ttl_seconds', 30 * DAY_IN_SECONDS);
}

/**
 * Whether a cache row's content is older than the TTL.
 *
 * @param array<string, mixed> $cached Cache row from wmcp_get_cache().
 * @return bool
 */
function wmcp_cache_is_stale($cached)
{
	if (empty($cached['created_at'])) {
		return true;
	}

	$created = strtotime($cached['created_at']);
	if (false === $created) {
		return true;
	}

	return (time() - $created) > wmcp_cache_ttl();
}

/**
 * Schedule a background regeneration for a single city after the response
 * has been sent to the browser. Uses the shutdown hook so the visitor never
 * waits. If fastcgi_finish_request() is available (PHP-FPM), the connection
 * is closed immediately; otherwise the regeneration runs at shutdown which
 * may add a small delay visible only to the triggering visitor on Apache/WAMP.
 *
 * Uses a transient lock to prevent concurrent regenerations for the same city.
 *
 * @param string $city      City name.
 * @param string $state     State name.
 * @param string $page_type payroll|hr|custom.
 */
function wmcp_schedule_background_refresh($city, $state, $page_type)
{
	$lock_key = 'wmcp_refresh_' . $page_type . '_' . wmcp_city_key($city, $state);

	// Already refreshing — skip.
	if (get_transient($lock_key)) {
		wmcp_log('background refresh already in progress, skipping', array(
			'city'      => $city,
			'page_type' => $page_type,
		));
		return;
	}

	// Hold the lock for 5 minutes — enough for any API call to finish.
	set_transient($lock_key, 1, 5 * MINUTE_IN_SECONDS);

	wmcp_log('background refresh scheduled', array(
		'city'      => $city,
		'state'     => $state,
		'page_type' => $page_type,
	));

	// Capture values for use inside the closure.
	$_city      = $city;
	$_state     = $state;
	$_page_type = $page_type;
	$_lock_key  = $lock_key;

	add_action('shutdown', function () use ($_city, $_state, $_page_type, $_lock_key) {

		// Close the browser connection before starting the API call.
		if (function_exists('fastcgi_finish_request')) {
			fastcgi_finish_request();
		}

		wmcp_log('background refresh started', array(
			'city'      => $_city,
			'state'     => $_state,
			'page_type' => $_page_type,
		));

		// Delete the stale cache row so wmcp_generate_city_page() forces a
		// fresh API call instead of returning the existing cached content.
		$city_key = wmcp_city_key($_city, $_state);
		wmcp_delete_cache($city_key, $_page_type);

		$data = wmcp_call_groq($_city, $_state, $_page_type);

		if (is_wp_error($data)) {
			wmcp_log('background refresh API call failed — keeping old cache', array(
				'city'      => $_city,
				'page_type' => $_page_type,
				'error'     => $data->get_error_message(),
			));
			delete_transient($_lock_key);
			return;
		}

		$saved = wmcp_save_city_to_cache($data, $_city, $_state, $_page_type);

		if (is_wp_error($saved)) {
			wmcp_log('background refresh save failed', array(
				'city'      => $_city,
				'page_type' => $_page_type,
				'error'     => $saved->get_error_message(),
			));
		} else {
			wmcp_log('background refresh complete — new cache saved', array(
				'city'      => $_city,
				'page_type' => $_page_type,
			));
		}

		delete_transient($_lock_key);
	});
}

/**
 * Save generated content to the city cache table (no new WP post).
 */
function wmcp_save_city_to_cache($data, $city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$city_key  = wmcp_city_key($city, $state);
	$data      = wmcp_prepare_page_data($data, $city, $state, $page_type);
	$slug      = sanitize_title($data['meta']['url_slug'] ?? '');
	$page_json = wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	$title     = $data['meta']['meta_title'] ?? '';

	if (empty($slug) || ! wmcp_is_valid_page_data($data)) {
		return new WP_Error('wmcp_save_fail', 'Could not build city page data.');
	}

	wmcp_save_cache($city_key, $city, $state, $slug, $title, 'wp_template', $page_json, 0, $page_type);

	return array(
		'html'       => 'wp_template',
		'slug'       => $slug,
		'meta_title' => $title,
		'city_key'   => $city_key,
		'page_type'  => $page_type,
	);
}

function wmcp_build_generate_result($source, $cached, $html = '', $expected_city_key = '', $expected_page_type = 'payroll')
{
	if (! is_array($cached)) {
		return new WP_Error('wmcp_cache_miss', 'City cache row missing.');
	}

	$expected_page_type = wmcp_normalize_page_type($expected_page_type);

	if ($expected_city_key && ($cached['city_key'] ?? '') !== $expected_city_key) {
		wmcp_log('refusing cached row — city_key mismatch', array(
			'expected' => $expected_city_key,
			'actual'   => $cached['city_key'] ?? '',
		));
		return new WP_Error('wmcp_city_mismatch', 'Cached content does not match the detected city.');
	}

	if ($expected_page_type && wmcp_normalize_page_type($cached['page_type'] ?? 'payroll') !== $expected_page_type) {
		wmcp_log('refusing cached row — page_type mismatch', array(
			'expected' => $expected_page_type,
			'actual'   => $cached['page_type'] ?? '',
		));
		return new WP_Error('wmcp_page_type_mismatch', 'Cached content does not match the requested page type.');
	}

	if ('' === $html) {
		$html = wmcp_get_cache_html($cached);
	}

	if ('' === $html && ! wmcp_cache_row_is_renderable($cached)) {
		return new WP_Error('wmcp_no_html', 'Cached city page has no renderable content.');
	}

	wmcp_log('serving city content', array(
		'source'    => $source,
		'city_key'  => $cached['city_key'] ?? '',
		'page_type' => $cached['page_type'] ?? $expected_page_type,
		'city'      => $cached['city'] ?? '',
		'state'     => $cached['state'] ?? '',
	));

	return array(
		'source'     => $source,
		'html'       => $html,
		'cached'     => $cached,
		'slug'       => $cached['post_slug'] ?? '',
		'meta_title' => $cached['meta_title'] ?? '',
		'city_key'   => $cached['city_key'] ?? '',
		'page_type'  => $cached['page_type'] ?? $expected_page_type,
		'city'       => $cached['city'] ?? '',
		'state'      => $cached['state'] ?? '',
	);
}

/**
 * Whether a cache row has renderable content (JSON data or legacy full HTML).
 *
 * @param array<string, mixed>|null $cached Cache row.
 */
function wmcp_cache_row_is_renderable($cached)
{
	if (! is_array($cached)) {
		return false;
	}

	if (! empty($cached['page_data'])) {
		$data = json_decode($cached['page_data'], true);
		return is_array($data) && wmcp_is_valid_page_data($data);
	}

	if (! empty($cached['page_html']) && false !== stripos($cached['page_html'], '<html')) {
		return true;
	}

	return false;
}

/**
 * Check cache by city key and permalink slug (handles URL-only city visits).
 *
 * @param string $city City name.
 * @param string $state State name.
 * @param string $page_type payroll|hr
 */
function wmcp_cache_is_usable_for_city($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$city_key  = wmcp_city_key($city, $state);
	$cached    = wmcp_get_cache($city_key, $page_type);

	if ($cached && wmcp_cache_row_is_renderable($cached)) {
		return true;
	}

	$config    = wmcp_get_page_type_definition($page_type);
	$post_slug = ($config['slug_prefix'] ?? 'payroll-software-in-') . wmcp_city_slug($city);
	$cached    = wmcp_get_cache_by_post_slug($post_slug, $page_type);

	return $cached && wmcp_cache_row_is_renderable($cached);
}

/* -------------------------------------------------------------------------
 * Static fallback page data — shown when IP or LLM API fails
 * ------------------------------------------------------------------------- */

/**
 * Returns a fully-structured static page data array matching the AI response
 * format. Used as fallback when geolocation or LLM API fails.
 * City label is always "Indian Businesses" so no city detection is needed.
 *
 * @param string $page_type payroll|hr
 * @return array<string, mixed>
 */
function wmcp_get_fallback_page_data( $page_type = 'payroll' ) {
	$page_type = wmcp_normalize_page_type( $page_type );

	if ( 'hr' === $page_type ) {
		return array(
			'meta' => array(
				'url_slug'         => 'hr-software-for-indian-businesses',
				'h1'               => 'HR Software for Indian Businesses',
				'meta_title'       => 'HR Software for Indian Businesses | WeekMate',
				'meta_description' => 'WeekMate HR Software helps Indian businesses automate attendance, leave, onboarding and workforce management. Book a free demo today.',
			),
			'sections' => array(
				'introduction' => array(
					'h2'   => 'HR Software for Indian Businesses',
					'h3'   => 'Modern HR management for growing teams across India',
					'body' => 'Running HR operations manually is one of the biggest productivity drains for growing Indian businesses. From tracking attendance and managing leave requests to onboarding new employees and handling compliance, the workload adds up fast. WeekMate HRMS brings all of these functions into a single platform — so your HR team spends less time on paperwork and more time on people. Whether you run a 10-person startup or a 500-person enterprise, WeekMate scales with your needs and keeps your workforce organised, compliant and engaged.',
				),
				'places' => array(
					'h2'   => 'Top Business Hubs Across India',
					'h3'   => 'WeekMate serves businesses in every major commercial centre',
					'items' => array(
						array( 'name' => 'Mumbai',     'description' => 'India\'s financial capital and home to thousands of growing enterprises across BFSI, manufacturing and technology.' ),
						array( 'name' => 'Delhi NCR',  'description' => 'A major hub for IT, consulting, government and retail businesses with a rapidly expanding workforce.' ),
						array( 'name' => 'Bengaluru',  'description' => 'India\'s Silicon Valley, hosting the highest concentration of tech startups and mid-size software companies.' ),
						array( 'name' => 'Hyderabad',  'description' => 'A fast-growing IT and pharma corridor with a large pool of skilled professionals and modern business parks.' ),
						array( 'name' => 'Ahmedabad',  'description' => 'A thriving MSME and manufacturing hub with a strong tradition of entrepreneurship and business growth.' ),
					),
				),
				'pain_points' => array(
					'h2'      => 'HR Challenges Indian Businesses Face',
					'h3'      => 'Why manual HR processes break down as teams grow',
					'bullets' => array(
						'Employee records scattered across spreadsheets make audits a time-consuming nightmare.',
						'Manual attendance tracking leads to errors, disputes and hours of reconciliation every month.',
						'Leave requests over WhatsApp and email cause confusion, conflicts and policy inconsistencies.',
						'Lengthy paper-based onboarding slows down new hires and wastes HR bandwidth.',
						'Performance reviews based on gut-feel rather than data result in unfair and inconsistent outcomes.',
					),
				),
				'solutions' => array(
					'h2'      => 'How WeekMate Simplifies HR Management',
					'h3'      => 'One platform that solves every HR challenge',
					'bullets' => array(
						'Centralised employee database keeps all records in one place — accurate, secure and audit-ready.',
						'Automated attendance with biometric and app-based clock-in gives real-time visibility with zero manual effort.',
						'Self-service leave management with custom policies lets employees apply and managers approve in seconds.',
						'Digital onboarding with guided checklists and e-documents gets new hires productive from day one.',
						'Structured performance management with goal tracking and 360 feedback makes appraisals fair and data-driven.',
					),
				),
				'faqs' => array(
					'h2'   => 'HR Software for Indian Businesses: FAQs',
					'h3'   => 'Quick answers before you book a demo',
					'items' => array(
						array( 'question' => 'What is HR software?',                     'answer' => 'HR software is a platform that automates and centralises human resource tasks including attendance, leave, payroll, onboarding and performance management. It replaces manual spreadsheets and disconnected tools with a single system.' ),
						array( 'question' => 'How does WeekMate help Indian businesses?', 'answer' => 'WeekMate is built specifically for Indian compliance requirements including PF, ESI, PT and TDS. It automates routine HR tasks so your team can focus on employee experience and business growth.' ),
						array( 'question' => 'Can HR software manage attendance?',        'answer' => 'Yes. WeekMate supports biometric integration, mobile clock-in and shift management with real-time dashboards and automatic payroll sync.' ),
						array( 'question' => 'Does WeekMate support leave management?',   'answer' => 'Yes. You can configure custom leave policies, approval workflows and leave balances. Employees apply via the self-service portal and managers approve with one click.' ),
						array( 'question' => 'Is WeekMate suitable for small businesses?', 'answer' => 'Absolutely. WeekMate scales from 10 to 5000+ employees. Small businesses get the same powerful features with simple onboarding and transparent per-employee pricing.' ),
					),
				),
			),
		);
	}

	// Default: payroll
	return array(
		'meta' => array(
			'url_slug'         => 'payroll-software-for-indian-businesses',
			'h1'               => 'Payroll Software for Indian Businesses',
			'meta_title'       => 'Payroll Software for Indian Businesses | WeekMate',
			'meta_description' => 'WeekMate Payroll Software automates salary processing, PF, ESI and TDS for Indian businesses. Accurate, compliant and easy to use. Book a free demo.',
		),
		'sections' => array(
			'introduction' => array(
				'h2'   => 'Payroll Software for Indian Businesses',
				'h3'   => 'Accurate, compliant payroll processing for every Indian business',
				'body' => 'Processing payroll manually is error-prone, time-consuming and a compliance risk for any growing Indian business. Between calculating salaries, managing PF and ESI contributions, deducting TDS and generating payslips, the monthly payroll cycle can take days. WeekMate Payroll Software automates the entire process — from attendance data import to final salary disbursement — so you run payroll in minutes, not days. Built for Indian statutory requirements, WeekMate keeps you compliant with PF, ESI, PT and Form 16 without any manual intervention.',
			),
			'places' => array(
				'h2'   => 'Top Business Hubs Across India',
				'h3'   => 'WeekMate serves businesses in every major commercial centre',
				'items' => array(
					array( 'name' => 'Mumbai',     'description' => 'India\'s financial capital and home to thousands of growing enterprises across BFSI, manufacturing and technology.' ),
					array( 'name' => 'Delhi NCR',  'description' => 'A major hub for IT, consulting, government and retail businesses with a rapidly expanding workforce.' ),
					array( 'name' => 'Bengaluru',  'description' => 'India\'s Silicon Valley, hosting the highest concentration of tech startups and mid-size software companies.' ),
					array( 'name' => 'Hyderabad',  'description' => 'A fast-growing IT and pharma corridor with a large pool of skilled professionals and modern business parks.' ),
					array( 'name' => 'Ahmedabad',  'description' => 'A thriving MSME and manufacturing hub with a strong tradition of entrepreneurship and business growth.' ),
				),
			),
			'pain_points' => array(
				'h2'      => 'Payroll Challenges Indian Businesses Face',
				'h3'      => 'Why manual payroll breaks down as your team grows',
				'bullets' => array(
					'Manual salary calculations cause costly errors and last-minute corrections every month.',
					'Staying compliant with PF, ESI and TDS rules requires constant manual tracking and risks penalties.',
					'Generating payslips and Form 16 manually takes days and is prone to mistakes.',
					'Processing full-and-final settlements for exiting employees is time-consuming and error-prone.',
					'Lack of visibility into payroll costs makes workforce budgeting and financial planning difficult.',
				),
			),
			'solutions' => array(
				'h2'      => 'How WeekMate Simplifies Payroll',
				'h3'      => 'Automated, accurate and fully compliant payroll in minutes',
				'bullets' => array(
					'Automated payroll engine processes salaries in one click with zero manual calculation errors.',
					'Built-in PF, ESI, PT and TDS management keeps every payroll run fully compliant automatically.',
					'Auto-generated payslips and Form 16 are available to employees instantly via the self-service portal.',
					'Automated F&F settlement calculations reduce processing time from days to minutes.',
					'Real-time payroll dashboards give management full visibility into salary costs and trends.',
				),
			),
			'faqs' => array(
				'h2'   => 'Payroll Software for Indian Businesses: FAQs',
				'h3'   => 'Quick answers before you book a demo',
				'items' => array(
					array( 'question' => 'What is payroll software?',                      'answer' => 'Payroll software automates the calculation and disbursement of employee salaries including tax deductions, statutory contributions and payslip generation. It replaces error-prone manual processes with a reliable, compliant system.' ),
					array( 'question' => 'Does WeekMate automate payroll?',                'answer' => 'Yes. WeekMate processes the entire payroll cycle automatically — from attendance import to salary calculation, statutory deductions and bank transfer — with a single click.' ),
					array( 'question' => 'Can WeekMate manage PF and ESI?',                'answer' => 'Yes. WeekMate automatically calculates PF and ESI contributions for every employee, generates challans and keeps your statutory records audit-ready at all times.' ),
					array( 'question' => 'How is payroll compliance handled?',             'answer' => 'WeekMate is built for Indian compliance. It handles PF, ESI, PT, TDS and Form 16 automatically, updating rules whenever regulations change so you never miss a deadline.' ),
					array( 'question' => 'Is payroll software suitable for small businesses?', 'answer' => 'Yes. WeekMate scales from 10 to 5000+ employees. Small businesses get the same automation and compliance features with straightforward onboarding and per-employee pricing.' ),
				),
			),
		),
	);
}
