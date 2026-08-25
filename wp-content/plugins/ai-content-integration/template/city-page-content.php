<?php
/**
 * City page main content markup.
 *
 * Override: copy to themes/your-theme/wmcp/city-page-content.php
 *
 * @package WeekMate_City_Pages
 */

defined('ABSPATH') || exit;
?>
<div class="wmcp-city-page">
	<main>
		<section class="hero">
			<div class="wrap">
				<span class="eyebrow" data-eyebrow>WeekMate HRMS</span>
				<h1 data-field="meta.h1">—</h1>
				<p class="sub" data-field="meta.meta_description">—</p>
				<div class="cta">
					<a class="btn" href="#demo" data-cta>Book a free demo</a>
					<a class="btn ghost" href="#pricing">View pricing</a>
				</div>
			</div>
		</section>

		<section>
			<div class="wrap">
				<div class="sec-head">
					<h2 data-field="sections.introduction.h2">—</h2>
					<h3 data-field="sections.introduction.h3">—</h3>
				</div>
				<p class="lede" data-field="sections.introduction.body">—</p>
			</div>
		</section>

		<section class="band">
			<div class="wrap">
				<div class="sec-head">
					<h2 data-field="sections.places.h2">—</h2>
					<h3 data-field="sections.places.h3">—</h3>
				</div>
				<ul class="places" data-list="places"></ul>
			</div>
		</section>

		<section class="band-warm">
			<div class="wrap">
				<div class="sec-head">
					<h2 data-field="sections.pain_points.h2">—</h2>
					<h3 data-field="sections.pain_points.h3">—</h3>
				</div>
				<ul class="bullets" data-list="pain"></ul>
			</div>
		</section>

		<section>
			<div class="wrap">
				<div class="sec-head">
					<h2 data-field="sections.solutions.h2">—</h2>
					<h3 data-field="sections.solutions.h3">—</h3>
				</div>
				<ul class="bullets" data-list="fix"></ul>
			</div>
		</section>

		<section class="band">
			<div class="wrap">
				<div class="sec-head">
					<h2 data-field="sections.faqs.h2">—</h2>
					<h3 data-field="sections.faqs.h3">—</h3>
				</div>
				<div data-list="faqs"></div>
			</div>
		</section>

		<section id="demo">
			<div class="wrap">
				<div class="closing">
					<h2>See WeekMate HRMS in action</h2>
					<p>Book a 20-minute walkthrough and run your first payroll cycle on us.</p>
					<a class="btn" href="/demo/">Book a demo</a>
				</div>
			</div>
		</section>
	</main>
</div>
