<?php
/**
 * Flexible Content Layout: Trust Bar [trust_bar]
 * Fields: logo (left image, url), tagline, badges (repeater: image[url], text)
 *
 * @package WeekMate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$logo       = get_sub_field( 'logo' );    // return_format = url
$tagline    = (string) get_sub_field( 'tagline' );
$has_badges = have_rows( 'badges' );

// Resolve a url-format image field to a src string (guards array/id too).
$resolve = static function ( $val, $size = 'medium' ) {
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

$logo_url = $resolve( $logo, 'thumbnail' );

if ( '' === $logo_url && '' === $tagline && ! $has_badges ) {
	return;
}
?>
<section class="certificate-sec wmcp-trust-bar" aria-label="Certifications">
	<div class="container">
		<div class="certificate-wrapper">
			<div class="row align-items-center justify-content-between">
				<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
					<div class="certificate-title wmcp-trust-brand">
						<?php if ( '' !== $logo_url ) : ?>
							<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $tagline ?: 'WeekMate' ); ?>" class="wmcp-trust-logo-icon" width="62" height="62" loading="lazy">
						<?php endif; ?>
						<?php if ( '' !== $tagline ) : ?>
							<p class="wmcp-trust-text"><?php echo nl2br( esc_html( $tagline ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12">
					<span class="seprator wmcp-trust-divider" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="120" height="6" viewBox="0 0 120 6" fill="none">
							<path d="M120 2.88671L115 -4.2717e-05L115 5.77346L120 2.88671ZM0 2.88672L4.37114e-08 3.38672L115.5 3.38671L115.5 2.88671L115.5 2.38671L-4.37114e-08 2.38672L0 2.88672Z" fill="black"/>
						</svg>
					</span>
				</div>

				<?php if ( $has_badges ) : ?>
					<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
						<div class="certificate-lists wmcp-trust-badges">
							<ul class="certificates">
								<?php
								while ( have_rows( 'badges' ) ) :
									the_row();
									$src  = $resolve( get_sub_field( 'image' ), 'medium' );
									$text = (string) get_sub_field( 'text' );

									if ( '' === $src && '' === $text ) {
										continue;
									}
									?>
									<li class="wmcp-badge">
										<?php if ( '' !== $src ) : ?>
											<img loading="lazy" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $text ); ?>">
										<?php endif; ?>
									</li>
								<?php endwhile; ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>