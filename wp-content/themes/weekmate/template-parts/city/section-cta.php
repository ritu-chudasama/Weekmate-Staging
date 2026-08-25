<?php
/**
 * Flexible Content Layout: CTA Banner [cta]
 * HTML structure mirrors index.html homepage__cta.
 * ACF fields: heading, subtext, button_label, button_url, image (illustration), background_image
 *
 * @package WeekMate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading      = (string) get_sub_field( 'heading' );
$subtext      = (string) get_sub_field( 'subtext' );
$button_label = (string) get_sub_field( 'button_label' );
$button_url   = (string) get_sub_field( 'button_url' );
$image        = get_sub_field( 'image' );
$bg           = get_sub_field( 'background_image' );

$resolve = static function ( $val, $size = 'large' ) {
	if ( empty( $val ) ) {
		return '';
	}
	if ( is_array( $val ) ) {
		return $val['url'];
	}
	if ( is_numeric( $val ) ) {
		return wp_get_attachment_image_url( (int) $val, $size );
	}
	return (string) $val;
};

$img_src = $resolve( $image, 'large' );
$bg_url  = $resolve( $bg, 'full' );

if ( '' === $heading && '' === $subtext && '' === $button_label && '' === $img_src ) {
	return;
}

$bg_style = '' !== $bg_url ? ' style="background-image:url(' . esc_url( $bg_url ) . ');"' : '';
?>
<!-- CTA Section -->
<section class="homepage__cta">
	<div class="container">
		<div class="homepage__cta-wrapper"<?php echo $bg_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="homepage__cta-illustration-wrapper">
				<?php if ( '' !== $img_src ) : ?>
					<img class="homepage__cta-illustration" src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $heading ); ?>" loading="lazy">
				<?php endif; ?>
			</div>
			<div class="homepage__cta-content">
				<?php if ( '' !== $heading ) : ?>
					<h2 class="homepage__cta-title"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( '' !== $subtext ) : ?>
					<p class="homepage__cta-subtitle"><?php echo esc_html( $subtext ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $button_label ) : ?>
					<a class="homepage__btn homepage__btn--primary homepage__btn--cta" href="<?php echo esc_url( $button_url ?: '#' ); ?>"><?php echo esc_html( $button_label ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
