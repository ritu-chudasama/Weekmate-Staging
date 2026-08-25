<?php
defined('ABSPATH') || exit;

/* -------------------------------------------------------------------------
 * Groq / OpenAI / Claude API — prompt building
 * ------------------------------------------------------------------------- */

function wmcp_build_prompt($city, $state, $page_type = 'payroll')
{
	$page_type = wmcp_normalize_page_type($page_type);

	// Try to read prompt instructions from ACF fields on the trigger page.
	// ACF must be active and the trigger page must exist.
	if ( function_exists('get_field') ) {
		$page_id = wmcp_get_trigger_page_id($page_type);

		if ( $page_id > 0 ) {
			$acf_topic           = get_field('wmcp_topic',              $page_id);
			$acf_keywords        = get_field('wmcp_keywords',           $page_id);
			$acf_hero_heading    = get_field('wmcp_hero_heading',       $page_id);
			$acf_hero_subheading = get_field('wmcp_hero_subheading',    $page_id);
			$acf_intro_heading   = get_field('wmcp_intro_heading',      $page_id);
			$acf_intro_subheading= get_field('wmcp_intro_subheading',   $page_id);
			$acf_intro           = get_field('wmcp_intro_prompt',       $page_id);
			$acf_places_heading  = get_field('wmcp_places_heading',     $page_id);
			$acf_places_subheading = get_field('wmcp_places_subheading',$page_id);
			$acf_places          = get_field('wmcp_places_prompt',      $page_id);
			$acf_cs_heading      = get_field('wmcp_cs_heading',         $page_id);
			$acf_cs_subheading   = get_field('wmcp_cs_subheading',      $page_id);
			$acf_challenges      = get_field('wmcp_challanges_prompt',  $page_id);
			$acf_solutions       = get_field('wmcp_solutions_prompt',   $page_id);
			$acf_faq_heading     = get_field('wmcp_faq_heading',        $page_id);
			$acf_faqs            = get_field('wmcp_faqs_prompt',        $page_id);

			// Use ACF values only if at least topic or intro or challenges is filled.
			if ( ! empty($acf_topic) || ! empty($acf_intro) || ! empty($acf_challenges) ) {
				$tpl = array(
					'topic'              => sanitize_text_field($acf_topic              ?? ''),
					'keywords'           => sanitize_textarea_field($acf_keywords       ?? ''),
					'hero_heading'       => sanitize_textarea_field($acf_hero_heading   ?? ''),
					'hero_subheading'    => sanitize_textarea_field($acf_hero_subheading?? ''),
					'intro_heading'      => sanitize_textarea_field($acf_intro_heading  ?? ''),
					'intro_subheading'   => sanitize_textarea_field($acf_intro_subheading ?? ''),
					'introduction'       => sanitize_textarea_field($acf_intro          ?? ''),
					'places_heading'     => sanitize_textarea_field($acf_places_heading ?? ''),
					'places_subheading'  => sanitize_textarea_field($acf_places_subheading ?? ''),
					'places'             => sanitize_textarea_field($acf_places         ?? ''),
					'cs_heading'         => sanitize_textarea_field($acf_cs_heading     ?? ''),
					'cs_subheading'      => sanitize_textarea_field($acf_cs_subheading  ?? ''),
					'challenges'         => sanitize_textarea_field($acf_challenges     ?? ''),
					'solutions'          => sanitize_textarea_field($acf_solutions      ?? ''),
					'faq_heading'        => sanitize_textarea_field($acf_faq_heading    ?? ''),
					'faqs'               => sanitize_textarea_field($acf_faqs           ?? ''),
				);
				return wmcp_build_dynamic_prompt($city, $state, $page_type, $tpl);
			}
		}
		}
	

	// Fall back to hardcoded prompts.
	if ('hr' === $page_type) {
		return wmcp_build_hr_prompt($city, $state);
	}

	return wmcp_build_payroll_prompt($city, $state);
}

/**
 * Build a dynamic prompt from ACF fields on the trigger page.
 * FAQs are always generated from the hardcoded instruction — no ACF field for them.
 * City and state are injected here; they are NOT part of ACF fields.
 *
 * @param string               $city      City name (detected from IP).
 * @param string               $state     State name (detected from IP).
 * @param string               $page_type Page type key (payroll|hr|custom).
 * @param array<string, mixed> $tpl       Values read from ACF fields.
 * @return string
 */
function wmcp_build_dynamic_prompt($city, $state, $page_type, $tpl)
{
	$city_esc  = esc_html($city);
	$state_esc = esc_html($state);
	$topic     = esc_html(! empty($tpl['topic']) ? $tpl['topic'] : $page_type);
	$keywords  = esc_html($tpl['keywords'] ?? '');

	// Section instructions from ACF — fall back to sensible defaults if empty.
	$intro_instr      = ! empty($tpl['introduction'])
		? $tpl['introduction']
		: "Focus on {$city_esc}'s business character and why {$topic} matters there. 100-120 words.";

	$places_instr     = ! empty($tpl['places'])
		? $tpl['places']
		: "List EXACTLY 5 real, well-known places to visit in {$city_esc}. Each with one concrete sentence.";

	$challenges_instr = ! empty($tpl['challenges'])
		? $tpl['challenges']
		: "List EXACTLY 5 concrete, floor-level pain points for {$city_esc} businesses. No generic filler.";

	$solutions_instr  = ! empty($tpl['solutions'])
		? $tpl['solutions']
		: "List EXACTLY 5 solutions WeekMate provides, mapped 1:1 to the pain points above.";

	// FAQs — use ACF field if filled, otherwise fall back to hardcoded instruction.
	if ( ! empty($tpl['faqs']) ) {
		$faqs_instr = $tpl['faqs'];
	} elseif ('hr' === $page_type) {
		$faqs_instr = "Write EXACTLY 5 FAQs. Each has a question and an answer of 1-3 sentences. "
			. "At least 2 questions must reflect {$city_esc}-specific HR pain points or local compliance context. "
			. "Suggested: What is HR software? How does HRMS help businesses in {$city_esc}? "
			. "Can HR software manage attendance? Does WeekMate support leave management? "
			. "Is HR software suitable for small businesses in {$city_esc}?";
	} else {
		$faqs_instr = "Write EXACTLY 5 FAQs. Each has a question and an answer of 1-3 sentences. "
			. "At least 2 questions must reflect {$city_esc}-specific payroll pain points or local compliance context. "
			. "Suggested: What is payroll software? Does WeekMate automate payroll? "
			. "Can WeekMate manage PF and ESI? How is payroll compliance handled in {$city_esc}? "
			. "Is payroll software suitable for startups in {$city_esc}?";
	}

	$slug_prefix = sanitize_title($topic) . '-in-';


  	// Heading/subheading instructions from ACF — fall back to defaults if empty.
	$hero_h1_instr   = ! empty($tpl['hero_heading'])
		? $tpl['hero_heading']
		: "Must be: \"{$topic} in {$city_esc}\" — include city name and primary keyword.";

	$hero_h3_instr   = ! empty($tpl['hero_subheading'])
		? $tpl['hero_subheading']
		: "One sentence benefit-led subtext about WeekMate in {$city_esc}. 150-160 chars. End with soft CTA.";

	$intro_h2_instr  = ! empty($tpl['intro_heading'])
		? $tpl['intro_heading']
		: "Must contain the primary keyword. Format: \"{$topic} in {$city_esc}\".";

	$intro_h3_instr  = ! empty($tpl['intro_subheading'])
		? $tpl['intro_subheading']
		: "Benefit-led subheading for growing businesses in {$city_esc}.";

	$places_h2_instr = ! empty($tpl['places_heading'])
		? $tpl['places_heading']
		: "A heading about places to visit in {$city_esc}.";

	$places_h3_instr = ! empty($tpl['places_subheading'])
		? $tpl['places_subheading']
		: "A short framing line about {$city_esc}'s most popular attractions.";

	$cs_h2_instr     = ! empty($tpl['cs_heading'])
		? $tpl['cs_heading']
		: "Descriptive heading about challenges {$city_esc} businesses face with {$topic}.";

	$cs_h3_instr     = ! empty($tpl['cs_subheading'])
		? $tpl['cs_subheading']
		: "A short subtitle about why these challenges exist.";

	$faq_h2_instr    = ! empty($tpl['faq_heading'])
		? $tpl['faq_heading']
		: "\"{$topic} in {$city_esc}: FAQs\"";




	return <<<PROMPT
You are an expert SaaS SEO strategist and enterprise content writer for WeekMate (weekmate.in), an Indian HRMS and payroll software product.

Your task: generate a city-specific landing page for "{$topic}" in {$city_esc} WITHOUT becoming thin, templated, or a duplicate "doorway" page.

Output VALID JSON ONLY — no preamble, no explanation, no markdown code fences.

Target Location:
CITY = {$city_esc}
STATE = {$state_esc}
Topic = {$topic}

Use keywords such as: {$keywords}

========================
OUTPUT STRUCTURE (never change section order, count, or purpose)
========================

Section 1 — INTRODUCTION
  - h2: Instructions for h2: {$intro_h2_instr}
  - h3: Instructions for h3: {$intro_h3_instr}
  - body: Instructions: {$intro_instr}

Section 2 — TOP PLACES TO VISIT
  - h2: Instructions for h2: {$places_h2_instr}
  - h3: Instructions for h3: {$places_h3_instr}
  - items: Follow this instruction exactly: {$places_instr}
    Each: { "name": "", "description": "" } — one concrete sentence per description.

Section 3 — COMMON PAIN POINTS
  - h2: Instructions for h2: {$cs_h2_instr}
  - h3: Instructions for h3: {$cs_h3_instr}
  - bullets: EXACTLY 5 plain strings. Instructions: {$challenges_instr}

Section 4 — HOW WEEKMATE FIXES IT
  - h2: "How WeekMate Simplifies {$topic} in {$city_esc}"
  - h3: A short subtitle about WeekMate solving the listed challenges.
  - bullets: EXACTLY 5 plain strings, mapped 1:1 to pain points. Instructions: {$solutions_instr}

Section 5 — FAQS
  - h2: Instructions for h2: {$faq_h2_instr}
  - h3: "Quick answers before you book a demo"
  - items: EXACTLY 5. Instructions: {$faqs_instr}
    Each: { "question": "", "answer": "" } — answers are 1-3 sentences.


========================
SEO RULES
========================
- meta_title: <= 60 characters. Format: "{$topic} in {$city_esc} | WeekMate"
- meta_description: Follow this instruction: {$hero_h3_instr}
- url_slug: lowercase, hyphenated. Format: "{$slug_prefix}{city}"
- h1: Follow this instruction: {$hero_h1_instr}
- Primary keyword appears in: h1, meta_title, meta_description, Introduction h2. Exactly once each. No stuffing.
- Every secondary keyword must appear AT LEAST ONCE, naturally woven into sentences. Never list them.
========================
WRITING RULES
========================
- Vary sentence length heavily. Mix short, blunt sentences with longer ones. Never write three parallel-structured sentences in a row.
- Active voice. Concrete, floor-level detail over generic claims.
- Indian English throughout. Use Indian statutory context naturally: PF, ESI, PT, TDS, F&F, payslip, Form 16.
- BANNED words (never use): "seamless", "robust", "leverage", "elevate", "furthermore", "moreover", "equally", "in today's fast-paced world".
- Mention {$city_esc} naturally throughout — no sentence should read identically if the city name were swapped.
- Business-focused, SEO optimised, unique city-specific content. No keyword stuffing.
- Never insert punctuation between two title fragments.
- Do NOT use "-", "–", "—", ":" or "|" as separators in headings.
- Titles should be plain text only.
========================
LOCAL ACCURACY GUARDRAILS
========================
- State statutory/tax facts only if they are universally applicable across India (PF, ESI, TDS apply nationwide).
- If unsure of a {$state_esc}-specific rule, keep the reference generic. Never invent slabs, rates, or deadlines.
 


========================
RETURN EXACTLY THIS JSON STRUCTURE
========================
{
  "meta": {
    "url_slug": "payroll-software-in-{city}",
    "h1": "Payroll Software in {$city_esc}",
    "meta_title": "Payroll Software in {$city_esc} | WeekMate",
    "meta_description": ""
  },
  "sections": {
    "introduction": {
      "h2": "Payroll Software in {$city_esc}",
      "h3": "",
      "body": ""
    },
    "places": {
      "h2": "Top 5 Places to Visit in {$city_esc}",
      "h3": "",
      "items": [
        { "name": "", "description": "" }
      ]
    },
    "pain_points": {
      "h2": "",
      "h3": "",
      "bullets": ["", "", "", "", ""]
    },
    "solutions": {
      "h2": "How WeekMate Simplifies Payroll in {$city_esc}",
      "h3": "",
      "bullets": ["", "", "", "", ""]
    },
    "faqs": {
      "h2": "Payroll Software in {$city_esc}: FAQs",
      "h3": "Quick answers before you book a demo",
      "items": [
        { "question": "", "answer": "" }
      ]
    }
  },
  "faq_schema": {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": ""
        }
      }
    ]
  },
  "secondary_keywords_used": [""]
}
 
Return ONLY this JSON. No explanations, no markdown, no code fences.
PROMPT;
}
 
 
function wmcp_build_hr_prompt($city, $state)
{
	$city_esc  = esc_html($city);
	$state_esc = esc_html($state);
 
	return <<<PROMPT
You are an expert SaaS SEO strategist, HRMS consultant, payroll consultant, and enterprise content writer for WeekMate (weekmate.in), an Indian HRMS and payroll software product.
 
Your task: generate a city-specific landing page that ranks for "HR software in {$city_esc}" WITHOUT becoming thin, templated, or a duplicate "doorway" page.
 
Output VALID JSON ONLY — no preamble, no explanation, no markdown code fences.
 
Target Location:
CITY = {$city_esc}
STATE = {$state_esc}
POST_ID = 3908
Topic = HR Software
 
Use keywords such as: HR Software, HRMS Software, Human Resource Management Software, Employee Management Software, Attendance Management, Leave Management, Workforce Management, Employee Self Service, HR Automation
 
========================
OUTPUT STRUCTURE (never change section order, count, or purpose)
========================
 
Section 1 — INTRODUCTION
  - h2: MUST contain the primary keyword in title case. Format: "HR Software in {$city_esc}"
  - h3: Benefit-led subheading about modern HR management for growing businesses in {$city_esc}.
  - body: Return a single JSON STRING of EXACTLY 100 words. Explain {$city_esc}'s business environment, workforce challenges, and why businesses need HR software, then describe how WeekMate HRMS helps through HR automation, employee onboarding, attendance management, leave management, performance management, Employee Self Service, and reporting. End with a business-focused benefit relevant to organisations in {$city_esc}. No bullet points, no markdown, no line breaks.
 
Section 2 — TOP 5 PLACES TO VISIT

 - h2: "Top 5 Places to Visit in {$city_esc}"
 - h3: A short framing line about {$city_esc}'s most popular attractions and visitor destinations.
 - items: EXACTLY 5 real, well-known places to visit in {$city_esc}. Each: { "name": "", "description": "" } — one concrete sentence per description.

 
Section 3 — COMMON PAIN POINTS
  - h2: Descriptive heading about HR challenges {$city_esc} businesses face. Do NOT keyword-stuff.
  - h3: A short subtitle about why these HR challenges exist in {$city_esc}.
  - bullets: EXACTLY 5 plain strings. Each is a concrete, floor-level HR pain point for {$city_esc} businesses. No generic filler.
    Example: "Employee records are scattered across spreadsheets, making audits a nightmare."
 
Section 4 — HOW WEEKMATE HRMS FIXES IT
  - h2: "How WeekMate Simplifies HR Management in {$city_esc}"
  - h3: A short subtitle about WeekMate solving the listed HR challenges.
  - bullets: EXACTLY 5 plain strings. Each maps 1:1 to the pain point at the SAME position (bullet 1 solves pain 1, bullet 2 solves pain 2, etc.).
    Example: "Centralised employee database keeps all records in one place, audit-ready at any time."
 
Section 5 — FAQS
  - h2: "HR Software in {$city_esc}: FAQs"
  - h3: "Quick answers before you book a demo"
  - items: EXACTLY 5. Each: { "question": "", "answer": "" } — answers are 1–3 sentences.
    - At least 2 questions must reflect {$city_esc}-specific HR pain points or local compliance context.
    - Suggested questions: What is HR software? How does HRMS help businesses in {$city_esc}? Can HR software manage attendance? Does WeekMate support leave management? Is HR software suitable for small businesses in {$city_esc}?
 
========================
SEO RULES
========================
- meta_title: <= 60 characters. Format: "HR Software in {$city_esc} | WeekMate"
- meta_description: 150–160 characters. Mention WeekMate, {$city_esc}, automation, and a business benefit. End with a soft CTA.
- url_slug: lowercase, hyphenated. Format: "hr-software-in-{city}"
- h1: "HR Software in {$city_esc}"
- Primary keyword appears in: h1, meta_title, meta_description, Introduction h2, the first 100 words of the intro body, and FAQ h2. Exactly once each. No stuffing.
- Every secondary keyword must appear AT LEAST ONCE, naturally woven into sentences across sections. Never list them.
 
========================
WRITING RULES
========================
- Vary sentence length heavily. Mix short, blunt sentences with longer ones. Never write three parallel-structured sentences in a row.
- Active voice. Concrete, floor-level detail over generic claims.
- Indian English throughout. Use Indian statutory context naturally: PF, ESI, PT, TDS, biometric attendance, onboarding, Form 16.
- BANNED words (never use): "seamless", "robust", "leverage", "elevate", "furthermore", "moreover", "equally", "in today's fast-paced world".
- Mention {$city_esc} naturally throughout — no sentence should read identically if the city name were swapped.
- Business-focused, SEO optimised, unique city-specific content. No keyword stuffing.
 
========================
LOCAL ACCURACY GUARDRAILS
========================
- State statutory/tax facts only if they are universally applicable across India (PF, ESI, TDS apply nationwide).
- If unsure of a {$state_esc}-specific rule, keep the reference generic. Never invent slabs, rates, or deadlines.
 
========================
RETURN EXACTLY THIS JSON STRUCTURE
========================
{
  "meta": {
    "url_slug": "hr-software-in-{city} ",
    "h1": "HR Software in {$city_esc}",
    "meta_title": "HR Software in {$city_esc} | WeekMate",
    "meta_description": ""
  },
  "sections": {
    "introduction": {
      "h2": "HR Software in {$city_esc}",
      "h3": "",
      "body": ""
    },
    "places": {
      "h2": "Top 5 Places to Visit in {$city_esc}",
      "h3": "",
      "items": [
        { "name": "", "description": "" }
      ]
    },
    "pain_points": {
      "h2": "",
      "h3": "",
      "bullets": ["", "", "", "", ""]
    },
    "solutions": {
      "h2": "How WeekMate Simplifies HR Management in {$city_esc}",
      "h3": "",
      "bullets": ["", "", "", "", ""]
    },
    "faqs": {
      "h2": "HR Software in {$city_esc}: FAQs",
      "h3": "Quick answers before you book a demo",
      "items": [
        { "question": "", "answer": "" }
      ]
    }
  },
  "faq_schema": {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": ""
        }
      }
    ]
  },
  "secondary_keywords_used": [""]
}
 
Return ONLY this JSON. No explanations, no markdown, no code fences.
PROMPT;
}

function wmcp_strip_markdown_fences($text)
{
	$text = trim($text);
	$text = preg_replace('/^```(?:json)?\s*/i', '', $text);
	$text = preg_replace('/\s*```\s*$/', '', $text);
	return trim($text);
}
