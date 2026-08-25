<?php
defined('ABSPATH') || exit;

/**
 * Whether Groq returned the old flat schema (seo_title, slug, introduction…)
 * vs the new nested schema ({ meta: {}, sections: {} }).
 *
 * @param array<string, mixed> $data Parsed JSON.
 */
function wmcp_is_flat_ai_format($data)
{
	if (! is_array($data)) {
		return false;
	}

	// New nested schema has a 'meta' key with 'url_slug'.
	if (isset($data['meta']) && is_array($data['meta'])) {
		return false;
	}

	return isset($data['seo_title']) || isset($data['slug']) || isset($data['introduction']);
}

/**
 * Map flat AI JSON (legacy schema) into the nested structure consumed by city-page.html.
 * If the data already uses the new nested schema ({ meta, sections }), pass it through unchanged.
 *
 * @param array<string, mixed> $data Parsed JSON.
 * @return array<string, mixed>
 */
function wmcp_normalize_ai_response($data)
{
	if (! wmcp_is_flat_ai_format($data)) {
		// Already in the new nested schema — sanitize in place and return.
		if (! is_array($data)) {
			return array();
		}

		// Sanitize meta fields.
		// if (isset($data['meta']) && is_array($data['meta'])) {
		// 	$data['meta']['url_slug']         = sanitize_title($data['meta']['url_slug'] ?? '');
		// 	$data['meta']['h1']               = sanitize_text_field($data['meta']['h1'] ?? '');
		// 	$data['meta']['meta_title']       = sanitize_text_field($data['meta']['meta_title'] ?? '');
		// 	$data['meta']['meta_description'] = sanitize_textarea_field($data['meta']['meta_description'] ?? '');
		// }

		if (isset($data['meta']) && is_array($data['meta'])) {
		$data['meta']['url_slug']         = sanitize_title($data['meta']['url_slug'] ?? '');
		$data['meta']['h1']               = str_replace( array( '—', '–', ' - ' ), ' ', sanitize_text_field($data['meta']['h1'] ?? '') );
		$data['meta']['meta_title']       = str_replace( array( '—', '–' ), '-', sanitize_text_field($data['meta']['meta_title'] ?? '') );
		$data['meta']['meta_description'] = str_replace( array( '—', '–' ), '-', sanitize_textarea_field($data['meta']['meta_description'] ?? '') );
		}


		// Sanitize sections.
		if (isset($data['sections']) && is_array($data['sections'])) {
			// Introduction.
			if (isset($data['sections']['introduction'])) {
				$intro = &$data['sections']['introduction'];
				$intro['h2']   = sanitize_text_field($intro['h2'] ?? '');
				$intro['h3']   = sanitize_text_field($intro['h3'] ?? '');
				if (is_array($intro['body'] ?? null)) {
					$intro['body'] = sanitize_textarea_field(
						implode(' ', array_filter(array_map('trim', $intro['body']), 'strlen'))
					);
				} else {
					$intro['body'] = sanitize_textarea_field($intro['body'] ?? '');
				}
			}

			// Places — array of {name, description}.
			if (isset($data['sections']['places']['items']) && is_array($data['sections']['places']['items'])) {
				$sanitized = array();
				foreach ($data['sections']['places']['items'] as $p) {
					if (! is_array($p)) {
						continue;
					}
					$sanitized[] = array(
						'name'        => sanitize_text_field($p['name'] ?? ''),
						'description' => sanitize_textarea_field($p['description'] ?? ''),
					);
				}
				$data['sections']['places']['items'] = $sanitized;
			}
			$data['sections']['places']['h2'] = sanitize_text_field($data['sections']['places']['h2'] ?? '');
			$data['sections']['places']['h3'] = sanitize_text_field($data['sections']['places']['h3'] ?? '');

			// Pain points — bullets array of plain strings.
			if (isset($data['sections']['pain_points']['bullets']) && is_array($data['sections']['pain_points']['bullets'])) {
				$data['sections']['pain_points']['bullets'] = array_map(
					'sanitize_textarea_field',
					$data['sections']['pain_points']['bullets']
				);
			}
			$data['sections']['pain_points']['h2'] = sanitize_text_field($data['sections']['pain_points']['h2'] ?? '');
			$data['sections']['pain_points']['h3'] = sanitize_text_field($data['sections']['pain_points']['h3'] ?? '');

			// Solutions — bullets array of plain strings.
			if (isset($data['sections']['solutions']['bullets']) && is_array($data['sections']['solutions']['bullets'])) {
				$data['sections']['solutions']['bullets'] = array_map(
					'sanitize_textarea_field',
					$data['sections']['solutions']['bullets']
				);
			}
			$data['sections']['solutions']['h2'] = sanitize_text_field($data['sections']['solutions']['h2'] ?? '');
			$data['sections']['solutions']['h3'] = sanitize_text_field($data['sections']['solutions']['h3'] ?? '');

			// FAQs — array of {question, answer}.
			if (isset($data['sections']['faqs']['items']) && is_array($data['sections']['faqs']['items'])) {
				$sanitized = array();
				foreach ($data['sections']['faqs']['items'] as $f) {
					if (! is_array($f)) {
						continue;
					}
					$sanitized[] = array(
						'question' => sanitize_text_field($f['question'] ?? ''),
						'answer'   => sanitize_textarea_field($f['answer'] ?? ''),
					);
				}
				$data['sections']['faqs']['items'] = $sanitized;
			}
			$data['sections']['faqs']['h2'] = sanitize_text_field($data['sections']['faqs']['h2'] ?? '');
			$data['sections']['faqs']['h3'] = sanitize_text_field($data['sections']['faqs']['h3'] ?? '');
		}

		return $data;
	}

	// ---- Legacy flat schema conversion ----

	$places = array();
	if (is_array($data['places'] ?? null)) {
		foreach ($data['places'] as $place) {
			if (! is_array($place)) {
				continue;
			}
			$places[] = array(
				'name'        => sanitize_text_field($place['name'] ?? ''),
				'description' => sanitize_textarea_field($place['description'] ?? ''),
			);
		}
	}

	$faqs = array();
	if (is_array($data['faqs'] ?? null)) {
		foreach ($data['faqs'] as $faq) {
			if (! is_array($faq)) {
				continue;
			}
			$faqs[] = array(
				'question' => sanitize_text_field($faq['question'] ?? ''),
				'answer'   => sanitize_textarea_field($faq['answer'] ?? ''),
			);
		}
	}

	// Convert old pain_points / solutions (array of objects) to plain-string bullets.
	$pain_bullets = array();
	if (is_array($data['pain_points'] ?? null)) {
		foreach ($data['pain_points'] as $item) {
			if (is_array($item)) {
				$text = trim(($item['title'] ?? '') . (! empty($item['description']) ? ': ' . $item['description'] : ''));
				if ('' !== $text) {
					$pain_bullets[] = sanitize_textarea_field($text);
				}
			} elseif (is_string($item) && '' !== trim($item)) {
				$pain_bullets[] = sanitize_textarea_field($item);
			}
		}
	}

	$solution_bullets = array();
	if (is_array($data['solutions'] ?? null)) {
		foreach ($data['solutions'] as $item) {
			if (is_array($item)) {
				$text = trim(($item['title'] ?? '') . (! empty($item['description']) ? ': ' . $item['description'] : ''));
				if ('' !== $text) {
					$solution_bullets[] = sanitize_textarea_field($text);
				}
			} elseif (is_string($item) && '' !== trim($item)) {
				$solution_bullets[] = sanitize_textarea_field($item);
			}
		}
	}

	return array(
		'meta'     => array(
			'url_slug'         => sanitize_title($data['slug'] ?? ''),
			'h1'               => sanitize_text_field($data['h1'] ?? ''),
			'meta_title'       => sanitize_text_field($data['seo_title'] ?? ''),
			'meta_description' => sanitize_textarea_field($data['meta_description'] ?? ''),
		),
		'sections' => array(
			'introduction' => array(
				'h2'   => '',
				'h3'   => '',
				'body' => sanitize_textarea_field($data['introduction'] ?? ''),
			),
			'places'       => array(
				'h2'    => '',
				'h3'    => '',
				'items' => $places,
			),
			'pain_points'  => array(
				'h2'      => '',
				'h3'      => '',
				'bullets' => $pain_bullets,
			),
			'solutions'    => array(
				'h2'      => '',
				'h3'      => '',
				'bullets' => $solution_bullets,
			),
			'faqs'         => array(
				'h2'    => '',
				'h3'    => '',
				'items' => $faqs,
			),
		),
	);
}

/**
 * @param array<string, mixed> $data Parsed JSON.
 */
/**
 * @param array<string, mixed> $data Parsed JSON.
 */
function wmcp_is_valid_page_data($data)
{
	if (! is_array($data)) {
		return false;
	}

	if (wmcp_is_flat_ai_format($data)) {
		return ! empty($data['introduction']) || ! empty($data['seo_title']);
	}

	// New nested schema: must have meta.url_slug or a non-empty introduction body.
	return ! empty($data['meta']['url_slug'])
		|| ! empty($data['sections']['introduction']['body'])
		|| ! empty($data['meta']['h1']);
}

function wmcp_parse_groq_json($raw, $city = '', $state = '', $page_type = 'payroll')
{
	$raw  = wmcp_strip_markdown_fences($raw);
	$data = json_decode($raw, true);

	if (wmcp_is_valid_page_data($data)) {
		$data = wmcp_normalize_ai_response($data);
		if ($city) {
			$data = wmcp_apply_fixed_headings($data, $city, $state, $page_type);
		}
		return $data;
	}

	if (preg_match('/\{[\s\S]*\}/', $raw, $matches)) {
		$data = json_decode($matches[0], true);
		if (wmcp_is_valid_page_data($data)) {
			$data = wmcp_normalize_ai_response($data);
			if ($city) {
				$data = wmcp_apply_fixed_headings($data, $city, $state, $page_type);
			}
			return $data;
		}
	}

	return new WP_Error('wmcp_invalid_json', 'Groq response was not valid JSON.');
}

function wmcp_call_groq($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$settings  = wmcp_get_settings();
	$provider  = $settings['ai_provider'] ?? 'groq';

	if ('openai' === $provider) {
		return wmcp_call_openai($city, $state, $page_type);
	}

	if ('claude' === $provider) {
		return wmcp_call_claude($city, $state, $page_type);
	}

	// Default: Groq
	return wmcp_call_groq_api($city, $state, $page_type);
}

/**
 * Call the Groq API (Llama models).
 */
function wmcp_call_groq_api($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$settings  = wmcp_get_settings();
	$api_key   = $settings['groq_api_key'];
	if (empty($api_key)) {
		return new WP_Error('wmcp_no_api_key', 'Groq API key is not configured.');
	}

	if ('hr' === $page_type) {
		$system = 'You are an expert SaaS SEO strategist, HR technology consultant, and enterprise content writer for Indian HR software. Respond with a single valid JSON object only — no markdown fences, no explanation, no preamble.';
	} else {
		$system = 'You are an expert SaaS SEO strategist, payroll technology consultant, and enterprise content writer for Indian payroll software. Respond with a single valid JSON object only — no markdown fences, no explanation, no preamble.';
	}

	$response = wp_remote_post(
		'https://api.groq.com/openai/v1/chat/completions',
		array(
			'timeout' => 90,
			'headers' => array(
				'Authorization' => 'Bearer ' . $api_key,
				'Content-Type'  => 'application/json',
			),
			'body'    => wp_json_encode(
				array(
					'model'       => $settings['groq_model'],
					'messages'    => array(
						array('role' => 'system', 'content' => $system),
						array('role' => 'user', 'content' => wmcp_build_prompt($city, $state, $page_type)),
					),
					'temperature' => 0.7,
					'max_tokens'  => 8192,
				)
			),
		)
	);

	if (is_wp_error($response)) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code($response);
	$body = json_decode(wp_remote_retrieve_body($response), true);

	if (200 !== $code || empty($body['choices'][0]['message']['content'])) {
		$msg = $body['error']['message'] ?? 'Groq API request failed.';
		return new WP_Error('wmcp_groq_error', $msg);
	}

	return wmcp_parse_groq_json($body['choices'][0]['message']['content'], $city, $state, $page_type);
}

/**
 * Call the OpenAI API (ChatGPT).
 */
function wmcp_call_openai($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$settings  = wmcp_get_settings();
	$api_key   = $settings['openai_api_key'] ?? '';
	if (empty($api_key)) {
		return new WP_Error('wmcp_no_api_key', 'OpenAI (ChatGPT) API key is not configured.');
	}

	if ('hr' === $page_type) {
		$system = 'You are an expert SaaS SEO strategist, HR technology consultant, and enterprise content writer for Indian HR software. Respond with a single valid JSON object only — no markdown fences, no explanation, no preamble.';
	} else {
		$system = 'You are an expert SaaS SEO strategist, payroll technology consultant, and enterprise content writer for Indian payroll software. Respond with a single valid JSON object only — no markdown fences, no explanation, no preamble.';
	}

	$response = wp_remote_post(
		'https://api.openai.com/v1/chat/completions',
		array(
			'timeout' => 90,
			'headers' => array(
				'Authorization' => 'Bearer ' . $api_key,
				'Content-Type'  => 'application/json',
			),
			'body'    => wp_json_encode(
				array(
					'model'       => $settings['groq_model'],
					'messages'    => array(
						array('role' => 'system', 'content' => $system),
						array('role' => 'user', 'content' => wmcp_build_prompt($city, $state, $page_type)),
					),
					'temperature' => 0.7,
					'max_tokens'  => 8192,
				)
			),
		)
	);

	if (is_wp_error($response)) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code($response);
	$body = json_decode(wp_remote_retrieve_body($response), true);

	if (200 !== $code || empty($body['choices'][0]['message']['content'])) {
		$msg = $body['error']['message'] ?? 'OpenAI API request failed.';
		return new WP_Error('wmcp_openai_error', $msg);
	}

	return wmcp_parse_groq_json($body['choices'][0]['message']['content'], $city, $state, $page_type);
}

/**
 * Call the Anthropic Claude API.
 */
function wmcp_call_claude($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$settings  = wmcp_get_settings();
	$api_key   = $settings['claude_api_key'] ?? '';
	if (empty($api_key)) {
		return new WP_Error('wmcp_no_api_key', 'Claude (Anthropic) API key is not configured.');
	}

	if ('hr' === $page_type) {
		$system = 'You are an expert SaaS SEO strategist, HR technology consultant, and enterprise content writer for Indian HR software. Respond with a single valid JSON object only — no markdown fences, no explanation, no preamble.';
	} else {
		$system = 'You are an expert SaaS SEO strategist, payroll technology consultant, and enterprise content writer for Indian payroll software. Respond with a single valid JSON object only — no markdown fences, no explanation, no preamble.';
	}

	$response = wp_remote_post(
		'https://api.anthropic.com/v1/messages',
		array(
			'timeout' => 90,
			'headers' => array(
				'x-api-key'         => $api_key,
				'anthropic-version' => '2023-06-01',
				'Content-Type'      => 'application/json',
			),
			'body'    => wp_json_encode(
				array(
					'model'      => $settings['groq_model'],
					'max_tokens' => 8192,
					'system'     => $system,
					'messages'   => array(
						array('role' => 'user', 'content' => wmcp_build_prompt($city, $state, $page_type)),
					),
				)
			),
		)
	);

	if (is_wp_error($response)) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code($response);
	$body = json_decode(wp_remote_retrieve_body($response), true);

	if (200 !== $code || empty($body['content'][0]['text'])) {
		$msg = $body['error']['message'] ?? 'Claude API request failed.';
		return new WP_Error('wmcp_claude_error', $msg);
	}

	return wmcp_parse_groq_json($body['content'][0]['text'], $city, $state, $page_type);
}

/**
 * Apply server-side SEO headings and slug; preserve AI body copy where present.
 * Works with the new nested schema: { meta, sections: { introduction, places, pain_points, solutions, faqs } }
 */
function wmcp_apply_fixed_headings($data, $city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);
	$city      = trim($city);
	$slug      = sanitize_title($city);
	$config    = wmcp_get_page_type_definition($page_type);

	if (! is_array($data)) {
		$data = array();
	}
	if (! isset($data['meta']) || ! is_array($data['meta'])) {
		$data['meta'] = array();
	}
	if (! isset($data['sections']) || ! is_array($data['sections'])) {
		$data['sections'] = array();
	}

	// Ensure all required section keys exist with the correct sub-keys.
	$section_defaults = array(
		'introduction' => array( 'h2' => '', 'h3' => '', 'body' => '' ),
		'places'       => array( 'h2' => '', 'h3' => '', 'items' => array() ),
		'pain_points'  => array( 'h2' => '', 'h3' => '', 'bullets' => array() ),
		'solutions'    => array( 'h2' => '', 'h3' => '', 'bullets' => array() ),
		'faqs'         => array( 'h2' => '', 'h3' => '', 'items' => array() ),
	);

	foreach ( $section_defaults as $key => $defaults ) {
		if (! isset($data['sections'][ $key ]) || ! is_array($data['sections'][ $key ])) {
			$data['sections'][ $key ] = $defaults;
		} else {
			$data['sections'][ $key ] = array_merge($defaults, $data['sections'][ $key ]);
		}
	}

	// Canonical slug.
	$data['meta']['url_slug'] = ($config['slug_prefix'] ?? 'payroll-software-in-') . $slug;

	// Read ACF heading overrides from the trigger/settings page (post 3909).
	$topic             = ( 'hr' === $page_type ) ? 'HR Software' : 'Payroll Software';
	$acf_intro_h3      = '';
	$acf_places_h2     = '';
	$acf_places_h3     = '';
	$acf_challenges_h2 = '';
	$acf_challenges_h3 = '';
	$acf_solutions_h2  = '';
	$acf_solutions_h3  = '';
	$acf_faqs_h3       = '';

	if ( function_exists( 'get_field' ) ) {
		$trigger_id = function_exists( 'wmcp_get_trigger_page_id' )
			? (int) wmcp_get_trigger_page_id( $page_type )
			: 4126;
		if ( $trigger_id > 0 ) {
			$acf_intro_h3      = (string) ( get_field( 'wmcp_intro_h3',      $trigger_id ) ?? '' );
			$acf_places_h2     = (string) ( get_field( 'wmcp_places_h2',     $trigger_id ) ?? '' );
			$acf_places_h3     = (string) ( get_field( 'wmcp_places_h3',     $trigger_id ) ?? '' );
			$acf_challenges_h2 = (string) ( get_field( 'wmcp_challenges_h2', $trigger_id ) ?? '' );
			$acf_challenges_h3 = (string) ( get_field( 'wmcp_challenges_h3', $trigger_id ) ?? '' );
			$acf_solutions_h2  = (string) ( get_field( 'wmcp_solutions_h2',  $trigger_id ) ?? '' );
			$acf_solutions_h3  = (string) ( get_field( 'wmcp_solutions_h3',  $trigger_id ) ?? '' );
			$acf_faqs_h3       = (string) ( get_field( 'wmcp_faqs_h3',       $trigger_id ) ?? '' );

			// Replace {city} and {topic} placeholders.
			$find    = array( '{city}', '{topic}' );
			$replace = array( $city, $topic );
			foreach ( array( &$acf_intro_h3, &$acf_places_h2, &$acf_places_h3, &$acf_challenges_h2, &$acf_challenges_h3, &$acf_solutions_h2, &$acf_solutions_h3, &$acf_faqs_h3 ) as &$_val ) {
				$_val = trim( str_replace( $find, $replace, $_val ) );
			}
			unset( $_val );
		}
	}


	if ('hr' === $page_type) {
		// --- meta ---
		if (empty($data['meta']['meta_title'])) {
			$data['meta']['meta_title'] = 'HR Software in ' . $city .  ' | WeekMate' ;
		}
				if ( empty($data['meta']['h1']) ) {
			$data['meta']['h1'] = 'HR Software in ' . $city;
		}
		// --- introduction ---
		if ( empty($data['sections']['introduction']['h2']) ) {
			$data['sections']['introduction']['h2'] = 'HR Software in ' . $city;
		}
		if ( empty($data['sections']['introduction']['h3']) ) {
			$data['sections']['introduction']['h3'] = 'Modern HR management for growing businesses';
		}
		// --- pain points ---
		if ( empty($data['sections']['pain_points']['h2']) ) {
			$data['sections']['pain_points']['h2'] = 'HR Challenges ' . $city . ' Businesses Face';
		}
		if ( empty($data['sections']['pain_points']['h3']) ) {
			$data['sections']['pain_points']['h3'] = 'Why manual HR processes break down as teams grow';
		}
		// --- solutions ---
		if ( empty($data['sections']['solutions']['h2']) ) {
			$data['sections']['solutions']['h2'] = 'How WeekMate Simplifies HR Management in ' . $city;
		}
		if ( empty($data['sections']['solutions']['h3']) ) {
			$data['sections']['solutions']['h3'] = 'One platform for employee management, attendance, leave, and HR automation';
		}
		// --- faqs ---
		if ( empty($data['sections']['faqs']['h2']) ) {
			$data['sections']['faqs']['h2'] = 'HR Software in ' . $city . ': FAQs';
		}
		if ( empty($data['sections']['faqs']['h3']) ) {
			$data['sections']['faqs']['h3'] = 'Quick answers before you book a demo';
		}
	
	} else {
		// --- meta ---
		if (empty($data['meta']['meta_title'])) {
			$data['meta']['meta_title'] = 'Payroll Software in ' . $city . ' | WeekMate';
		}
		if ( empty($data['meta']['h1']) ) {
			$data['meta']['h1'] = 'Payroll Software in ' . $city;
		}
		// --- introduction ---
		if ( empty($data['sections']['introduction']['h2']) ) {
			$data['sections']['introduction']['h2'] = 'Payroll Software in ' . $city;
		}
		if ( empty($data['sections']['introduction']['h3']) ) {
			$data['sections']['introduction']['h3'] = 'Accurate payroll processing for growing businesses';
		}
		// --- pain points ---
		if ( empty($data['sections']['pain_points']['h2']) ) {
			$data['sections']['pain_points']['h2'] = 'Payroll Challenges ' . $city . ' Businesses Face';
		}
		if ( empty($data['sections']['pain_points']['h3']) ) {
			$data['sections']['pain_points']['h3'] = 'Why manual payroll processes break down as teams grow';
		}
		// --- solutions ---
		if ( empty($data['sections']['solutions']['h2']) ) {
			$data['sections']['solutions']['h2'] = 'How WeekMate Simplifies Payroll in ' . $city;
		}
		if ( empty($data['sections']['solutions']['h3']) ) {
			$data['sections']['solutions']['h3'] = 'One platform for salary processing, payroll compliance, and payroll automation';
		}
		// --- faqs ---
		if ( empty($data['sections']['faqs']['h2']) ) {
			$data['sections']['faqs']['h2'] = 'Payroll Software in ' . $city . ': FAQs';
		}
		if ( empty($data['sections']['faqs']['h3']) ) {
			$data['sections']['faqs']['h3'] = 'Quick answers before you book a demo';
		}
	
	}

	return $data;
}
