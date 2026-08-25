<?php
/**
 * Flexible Content Layout: Top Business Hubs [places]
 * HTML structure mirrors index.html homepage__business-areas.
 * ACF fields: h2, description, background_image, items (image, name, description)
 *
 * @package WeekMate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$h2   = (string) get_sub_field( 'h2' );
$desc = (string) get_sub_field( 'description' );
$bg   = get_sub_field( 'background_image' );

if ( '' === $h2 && '' === $desc && ! have_rows( 'items' ) ) {
	return;
}

$bg_url = '';
if ( ! empty( $bg ) ) {
	$bg_url = is_array( $bg ) ? $bg['url'] : ( is_numeric( $bg ) ? wp_get_attachment_image_url( (int) $bg, 'full' ) : (string) $bg );
}
$bg_style = '' !== $bg_url ? ' style="background-image:url(' . esc_url( $bg_url ) . ');"' : '';
?>
<!-- Business Areas Section - Top Locations -->
<section class="homepage__business-areas"<?php echo $bg_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="container">
		<div class="homepage__section-title">
			<?php if ( '' !== $h2 ) : ?>
				<h2><?php echo esc_html( $h2 ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $desc ) : ?>
				<p><?php echo esc_html( $desc ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( have_rows( 'items' ) ) : ?>
			<div class="homepage__business-grid">
				<?php
				while ( have_rows( 'items' ) ) :
					the_row();
					$img  = get_sub_field( 'image' );
					$name = (string) get_sub_field( 'name' );
					$cdes = (string) get_sub_field( 'description' );

					$img_src = '';
					$img_alt = $name;
					if ( ! empty( $img ) ) {
						if ( is_array( $img ) ) {
							$img_src = $img['url'];
							$img_alt = ! empty( $img['alt'] ) ? $img['alt'] : $name;
						} elseif ( is_numeric( $img ) ) {
							$img_src = wp_get_attachment_image_url( (int) $img, 'medium' );
						} else {
							$img_src = (string) $img;
						}
					}
					?>
					<article class="homepage__business-card">
						<div class="homepage__business-icon">
							<?php if ( '' !== $img_src ) : ?>
								<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" width="40" height="40" loading="lazy">
							<?php else : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                fill="none">
                                <mask id="mask0_1350_15011" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0"
                                    y="0" width="40" height="40">
                                    <path d="M0 3.8147e-06H40V40H0V3.8147e-06Z" fill="white" />
                                </mask>
                                <g mask="url(#mask0_1350_15011)">
                                    <path
                                        d="M8.28125 12.8887C8.28125 6.42735 13.5387 1.16992 20 1.16992C26.4613 1.16992 31.7188 6.42735 31.7188 12.8887C31.7188 17.9349 29.9026 19.3089 20 32.6738C10.1191 19.3382 8.28125 17.9359 8.28125 12.8887Z"
                                        stroke="black" stroke-width="2.34375" stroke-miterlimit="10" />
                                    <path
                                        d="M20 17.5781C17.4153 17.5781 15.3125 15.4753 15.3125 12.8906C15.3125 10.3059 17.4153 8.20312 20 8.20312C22.5847 8.20312 24.6875 10.3059 24.6875 12.8906C24.6875 15.4753 22.5847 17.5781 20 17.5781Z"
                                        stroke="black" stroke-width="2.34375" stroke-miterlimit="10" />
                                    <path
                                        d="M22.335 29.5462C27.6884 29.9791 31.7188 31.8716 31.7188 34.1406C31.7188 36.7295 26.4721 38.8281 20 38.8281C13.528 38.8281 8.28125 36.7295 8.28125 34.1406C8.28125 31.8716 12.3116 29.9791 17.665 29.5462"
                                        stroke="black" stroke-width="2.34375" stroke-miterlimit="10" />
                                </g>
                            </svg>
							<?php endif; ?>
						</div>
						<?php if ( '' !== $name ) : ?>
							<h3 class="homepage__business-title"><?php echo esc_html( $name ); ?></h3>
						<?php endif; ?>
						<?php if ( '' !== $cdes ) : ?>
							<p class="homepage__business-text"><?php echo esc_html( $cdes ); ?></p>
						<?php endif; ?>
					</article>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
