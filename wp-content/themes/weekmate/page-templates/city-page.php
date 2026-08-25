<?php
/**
 * Template Name: City Page Template
 *
 * Renders the ACF "City Page Fallback Content" flexible-content sections.
 * Field group location: page_template == page-templates/city-page-template.php
 *
 * Each flexible-content layout is rendered by a matching template part in
 * /template-parts/city/section-{layout}.php
 *
 * @package WeekMate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * The field group exposes two flexible-content fields:
 *   - fallback_hr_sections
 *   - fallback_payroll_sections
 *
 * We let the page choose which one to render. Default = HR.
 * Override per-page with a "page_variant" custom field set to "payroll",
 * or filter 'wmcp_city_sections_field' if you prefer programmatic control.
 */
$variant       = get_post_meta( get_the_ID(), 'page_variant', true );
$sections_field = ( 'payroll' === $variant ) ? 'fallback_payroll_sections' : 'fallback_hr_sections';
$sections_field = apply_filters( 'wmcp_city_sections_field', $sections_field, get_the_ID() );
?>

<main id="primary" class="city-page" role="main">
	<div class="homepage">
		<?php
		if ( have_rows( $sections_field ) ) :
			while ( have_rows( $sections_field ) ) :
				the_row();
				$layout = get_row_layout();

				/**
				 * Locate the section partial. Layout names map 1:1 to file names:
				 * hero, trust_bar, introduction, places, challenges_solutions, cta, faqs
				 */
				$part = locate_template( 'template-parts/city/section-' . $layout . '.php' );

				if ( $part ) {
					include $part;
				}
			endwhile;
		else :
			// No sections configured: render normal page content as a graceful fallback.
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</div>
</main>

<?php
get_footer();
