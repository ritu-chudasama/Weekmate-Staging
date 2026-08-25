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
			$acf_topic      = get_field('wmcp_topic',             $page_id);
			$acf_keywords   = get_field('wmcp_keywords',          $page_id);
			$acf_intro      = get_field('wmcp_intro_prompt',      $page_id);
			$acf_places     = get_field('wmcp_places_prompt',     $page_id);
			$acf_challenges = get_field('wmcp_challenges_prompt', $page_id);
			$acf_solutions  = get_field('wmcp_solutions_prompt',  $page_id);
			$acf_faqs       = get_field('wmcp_faqs_prompt',       $page_id);

			// Use ACF values only if at least topic or intro or challenges is filled.
			if ( ! empty($acf_topic) || ! empty($acf_intro) || ! empty($acf_challenges) ) {
				$tpl = array(
					'topic'        => sanitize_text_field($acf_topic         ?? ''),
					'keywords'     => sanitize_textarea_field($acf_keywords  ?? ''),
					'introduction' => sanitize_textarea_field($acf_intro     ?? ''),
					'places'       => sanitize_textarea_field($acf_places    ?? ''),
					'challenges'   => sanitize_textarea_field($acf_challenges ?? ''),
					'solutions'    => sanitize_textarea_field($acf_solutions  ?? ''),
					'faqs'         => sanitize_textarea_field($acf_faqs       ?? ''),
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
		: "Focus on {$city_esc}'s business character and why {$topic} matters there. 70-100 words.";

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
  - h2: Must contain the primary keyword. Format: "{$topic} in {$city_esc}"
  - h3: Benefit-led subheading for growing businesses in {$city_esc}.
  - body: Instructions: {$intro_instr}

Section 2 — TOP PLACES TO VISIT
  - h2: A heading about places to visit in {$city_esc} (use the count from your instructions below).
  - h3: A short framing line about {$city_esc}'s most popular attractions.
  - items: Follow this instruction exactly: {$places_instr}
    Each: { "name": "", "description": "" } — one concrete sentence per description.

Section 3 — COMMON PAIN POINTS
  - h2: Descriptive heading about challenges {$city_esc} businesses face with {$topic}.
  - h3: A short subtitle about why these challenges exist.
  - bullets: EXACTLY 5 plain strings. Instructions: {$challenges_instr}

Section 4 — HOW WEEKMATE FIXES IT
  - h2: "How WeekMate Simplifies {$topic} in {$city_esc}"
  - h3: A short subtitle about WeekMate solving the listed challenges.
  - bullets: EXACTLY 5 plain strings, mapped 1:1 to pain points. Instructions: {$solutions_instr}

Section 5 — FAQS
  - h2: "{$topic} in {$city_esc}: FAQs"
  - h3: "Quick answers before you book a demo"
  - items: EXACTLY 5. Instructions: {$faqs_instr}
    Each: { "question": "", "answer": "" } — answers are 1-3 sentences.

========================
SEO RULES
========================
- meta_title: <= 60 characters. Format: "{$topic} in {$city_esc} | WeekMate"
- meta_description: 150-160 characters. Mention WeekMate, {$city_esc}, and a business benefit. End with a soft CTA.
- url_slug: lowercase, hyphenated. Format: "{$slug_prefix}{city}"
- h1: "{$topic} in {$city_esc}"
- Primary keyword appears in: h1, meta_title, meta_description, Introduction h2. Exactly once each. No stuffing.
- Every secondary keyword must appear AT LEAST ONCE, naturally woven into sentences. Never list them.

========================
WRITING RULES
========================
- Vary sentence length heavily. Mix short, blunt sentences with longer ones.
- Active voice. Concrete, floor-level detail over generic claims.
- Indian English throughout. Use Indian statutory context naturally: PF, ESI, PT, TDS, F&F, payslip, Form 16.
- BANNED words: "seamless", "robust", "leverage", "elevate", "furthermore", "moreover", "equally", "in today's fast-paced world".
- Mention {$city_esc} naturally throughout — no sentence should read identically if the city name were swapped.
- Business-focused, SEO optimised, unique city-specific content. No keyword stuffing.

========================
LOCAL ACCURACY GUARDRAILS
========================
- State statutory/tax facts only if universally applicable across India (PF, ESI, TDS apply nationwide).
- If unsure of a {$state_esc}-specific rule, keep the reference generic. Never invent slabs, rates, or deadlines.

========================
RETURN EXACTLY THIS JSON STRUCTURE
========================
{
  "meta": {
    "url_slug": "{$slug_prefix}{city}",
    "h1": "{$topic} in {$city_esc}",
    "meta_title": "{$topic} in {$city_esc} | WeekMate",
    "meta_description": ""
  },
  "sections": {
    "introduction": { "h2": "", "h3": "", "body": "" },
    "places": {
      "h2": "",
      "h3": "",
      "items": [{ "name": "", "description": "" }]
    },
    "pain_points": { "h2": "", "h3": "", "bullets": ["", "", "", "", ""] },
    "solutions": { "h2": "", "h3": "", "bullets": ["", "", "", "", ""] },
    "faqs": {
      "h2": "{$topic} in {$city_esc}: FAQs",
      "h3": "Quick answers before you book a demo",
      "items": [{ "question": "", "answer": "" }]
    }
  }
}

Return ONLY this JSON. No explanations, no markdown, no code fences.
PROMPT;
}

function wmcp_build_payroll_prompt($city, $state)
{
	$city_esc  = esc_html($city);
	$state_esc = esc_html($state);


return <<<PROMPT
You are an expert SaaS SEO strategist, HRMS consultant, payroll consultant, and enterprise content writer for WeekMate (weekmate.in), an Indian HRMS and payroll software product.
 
Your task: generate a city-specific landing page that ranks for "payroll software in {$city_esc}" WITHOUT becoming thin, templated, or a duplicate "doorway" page.
 
Output VALID JSON ONLY — no preamble, no explanation, no markdown code fences.
 
Target Location:
CITY = {$city_esc}
STATE = {$state_esc}
POST_ID = 3899
Topic = Payroll Software
 
Use keywords such as: Payroll Software, Payroll Management, Payroll Processing, Salary Management, Payroll Compliance, Payroll Automation, PF Management, ESI Management, TDS Management
 
========================
OUTPUT STRUCTURE (never change section order, count, or purpose)
========================
 
Section 1 — INTRODUCTION
  - h2: MUST contain the primary keyword in title case. Format: "Payroll Software in {$city_esc}"  Built for India's Fastest-Moving Workforce
  - h3: Benefit-led subheading about accurate payroll processing for growing businesses in {$city_esc}.
  - body: 70-100 words. Focus on {$city_esc}'s business character and why payroll software matters there. Cover salary processing, payroll compliance, PF, ESI, TDS, automation, and employee self-service naturally. No tourist references.
 
Section 2 — TOP 5 PLACES TO VISIT

  - h2: "Top 5 Places to Visit in {$city_esc}"
  - h3: A short framing line about {$city_esc}'s most popular attractions and visitor destinations.
  - items: EXACTLY 5 real, well-known places to visit in {$city_esc}. Each: { "name": "", "description": "" } — one concrete sentence per description.

 
Section 3 — COMMON PAIN POINTS
  - h2: Descriptive heading about payroll challenges {$city_esc} businesses face. Do NOT keyword-stuff.
  - h3: A short subtitle about why these payroll challenges exist in {$city_esc}.
  - bullets: EXACTLY 5 plain strings. Each is a concrete, floor-level payroll pain point for {$city_esc} businesses. No generic filler.
    Example: "Manual payroll calculations cause costly errors and last-minute corrections every month."
 
Section 4 — HOW WEEKMATE HRMS FIXES IT
  - h2: "How WeekMate Simplifies Payroll in {$city_esc}"
  - h3: A short subtitle about WeekMate solving the listed payroll challenges.
  - bullets: EXACTLY 5 plain strings. Each maps 1:1 to the pain point at the SAME position (bullet 1 solves pain 1, bullet 2 solves pain 2, etc.).
    Example: "Automated payroll engine eliminates manual errors with one-click salary processing."
 
Section 5 — FAQS
  - h2: "Payroll Software in {$city_esc}: FAQs"
  - h3: "Quick answers before you book a demo"
  - items: EXACTLY 5. Each: { "question": "", "answer": "" } — answers are 1–3 sentences.
    - At least 2 questions must reflect {$city_esc}-specific payroll pain points or local compliance context.
    - Suggested questions: What is payroll software? Does WeekMate automate payroll? Can WeekMate manage PF and ESI? How is payroll compliance handled? Is payroll software suitable for startups in {$city_esc}?
 
========================
SEO RULES
========================
- meta_title: <= 60 characters. Format: "Payroll Software in {$city_esc} | WeekMate"
- meta_description: 150–160 characters. Mention WeekMate, {$city_esc}, automation, and a business benefit. End with a soft CTA.
- url_slug: lowercase, hyphenated. Format: "payroll-software-in-{city}"
- h1: "Payroll Software in {$city_esc}"
- Primary keyword appears in: h1, meta_title, meta_description, Introduction h2, the first 100 words of the intro body, and FAQ h2. Exactly once each. No stuffing.
- Every secondary keyword must appear AT LEAST ONCE, naturally woven into sentences across sections. Never list them.
 
========================
WRITING RULES
========================
- Vary sentence length heavily. Mix short, blunt sentences with longer ones. Never write three parallel-structured sentences in a row.
- Active voice. Concrete, floor-level detail over generic claims.
- Indian English throughout. Use Indian statutory context naturally: PF, ESI, PT, TDS, F&F, payslip, Form 16.
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
    "url_slug": "payroll-software-in-{city}",
    "h1": "Payroll Software in {$city_esc} Built for India's Fastest-Moving Workforce",
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
  - h2: MUST contain the primary keyword in title case. Format: "HR Software in {$city_esc}"  Built for India's Fastest-Moving Workforce
  - h3: Benefit-led subheading about modern HR management for growing businesses in {$city_esc}.
  - body: 70-100 words. Focus on {$city_esc}'s business character and why HR software matters there. Cover employee management, attendance, leave management, onboarding, performance management, workforce management, and HR automation naturally. No tourist references.
 
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
    "h1": "HR Software in {$city_esc} Built for India's Fastest-Moving Workforce",
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
