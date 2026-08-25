<?php
/**
 * Flexible Content Layout: Hero Section [hero]
 * HTML structure mirrors index.html homepage__hero.
 * Fields: h1, subtext, button_primary_label/url, button_secondary_label/url, background_image
 *
 * @package WeekMate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$h1              = (string) get_sub_field( 'h1' );
$subtext         = (string) get_sub_field( 'subtext' );
$primary_label   = (string) get_sub_field( 'button_primary_label' );
$primary_url     = (string) get_sub_field( 'button_primary_url' );
$secondary_label = (string) get_sub_field( 'button_secondary_label' );
$secondary_url   = (string) get_sub_field( 'button_secondary_url' );
$bg              = get_sub_field( 'background_image' );

$bg_url = '';
if ( ! empty( $bg ) ) {
	$bg_url = is_array( $bg ) ? $bg['url'] : ( is_numeric( $bg ) ? wp_get_attachment_image_url( (int) $bg, 'full' ) : (string) $bg );
}
$bg_style = '' !== $bg_url ? ' style="background-image:url(' . esc_url( $bg_url ) . ');"' : '';

// Highlight last word.
$h1_markup = esc_html( $h1 );
$h1_trim   = trim( $h1 );
if ( '' !== $h1_trim && false !== strrpos( $h1_trim, ' ' ) ) {
	$pos = strrpos( $h1_trim, ' ' );
	$h1_markup = esc_html( substr( $h1_trim, 0, $pos ) ) . ' <span class="homepage__hero-highlight">' . esc_html( substr( $h1_trim, $pos + 1 ) ) . '</span>';
}
?>
<!-- Hero Section -->
<section class="homepage__hero" id="hero"<?php echo $bg_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="homepage__hero-background"></div>
	<div class="homepage__hero-container">
		<div class="homepage__hero-content">
			<?php if ( '' !== $h1_trim ) : ?>
				<h1 class="homepage__hero-title">
					<?php echo $h1_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</h1>
			<?php endif; ?>
			<?php if ( '' !== $subtext ) : ?>
				<p class="homepage__hero-description">
					<?php echo esc_html( $subtext ); ?>
				</p>
			<?php endif; ?>
			<?php if ( '' !== $primary_label || '' !== $secondary_label ) : ?>
				<div class="homepage__hero-buttons">
					<?php if ( '' !== $primary_label ) : ?>
						<a class="homepage__btn homepage__btn--primary" href="<?php echo esc_url( $primary_url ?: '#' ); ?>"><?php echo esc_html( $primary_label ); ?></a>
					<?php endif; ?>
					<?php if ( '' !== $secondary_label ) : ?>
						<a class="homepage__btn homepage__btn--secondary" href="<?php echo esc_url( $secondary_url ?: '#' ); ?>"><?php echo esc_html( $secondary_label ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
