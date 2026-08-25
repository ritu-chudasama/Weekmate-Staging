<?php
/**
 * Flexible Content Layout: Challenges & Solutions [challenges_solutions]
 * HTML structure mirrors index.html homepage__challenges.
 * ACF fields: h2, content (wysiwyg), pain_bullets (image,title,text), solution_bullets (image,title,text)
 *
 * @package WeekMate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$h2      = (string) get_sub_field( 'h2' );
$content = (string) get_sub_field( 'content' );
?>
<!-- HR Challenges & Solutions Section -->
<section class="homepage__challenges">
	<div class="container">
		<div class="homepage__challenges-header">
			<?php if ( '' !== $h2 ) : ?>
				<h2 class="homepage__challenges-title"><?php echo nl2br( esc_html( $h2 ) ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== trim( $content ) ) : ?>
				<div class="homepage__challenges-description"><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>
		</div>

		<div class="homepage__challenges-panels">
			<?php if ( have_rows( 'pain_bullets' ) ) : ?>
				<!-- Left Panel - Pain Points -->
				<div class="homepage__challenges-panel homepage__challenges-panel--pain">
					<div class="homepage__challenges-panel-header">
						<h3 class="homepage__challenges-panel-title">Pain Points</h3>
					</div>
					<div class="homepage__challenges-rows">
						<?php
						while ( have_rows( 'pain_bullets' ) ) :
							the_row();
							$img   = get_sub_field( 'image' );
							$title = (string) get_sub_field( 'title' );
							$text  = (string) get_sub_field( 'text' );
							$src   = '';
							$alt   = $title;
							if ( ! empty( $img ) ) {
								if ( is_array( $img ) ) { $src = $img['url']; $alt = ! empty( $img['alt'] ) ? $img['alt'] : $title; }
								elseif ( is_numeric( $img ) ) { $src = wp_get_attachment_image_url( (int) $img, 'thumbnail' ); }
								else { $src = (string) $img; }
							}
							?>
							<div class="homepage__challenges-row">
								<div class="homepage__challenges-icon homepage__challenges-icon--pain">
									<?php if ( '' !== $src ) : ?>
										<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="22" height="22" loading="lazy">
									<?php endif; ?>
								</div>
								<div class="homepage__challenges-text">
									<?php if ( '' !== $title ) : ?>
										<h4 class="homepage__challenges-row-title"><?php echo esc_html( $title ); ?></h4>
									<?php endif; ?>
									<?php if ( '' !== $text ) : ?>
										<p class="homepage__challenges-row-description"><?php echo esc_html( $text ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( have_rows( 'solution_bullets' ) ) : ?>
				<!-- Right Panel - Solutions -->
				<div class="homepage__challenges-panel homepage__challenges-panel--solution">
					<div class="homepage__challenges-panel-header">
						<h3 class="homepage__challenges-panel-title">Solutions</h3>
					</div>
					<div class="homepage__challenges-rows">
						<?php
						while ( have_rows( 'solution_bullets' ) ) :
							the_row();
							$img   = get_sub_field( 'image' );
							$title = (string) get_sub_field( 'title' );
							$text  = (string) get_sub_field( 'text' );
							$src   = '';
							$alt   = $title;
							if ( ! empty( $img ) ) {
								if ( is_array( $img ) ) { $src = $img['url']; $alt = ! empty( $img['alt'] ) ? $img['alt'] : $title; }
								elseif ( is_numeric( $img ) ) { $src = wp_get_attachment_image_url( (int) $img, 'thumbnail' ); }
								else { $src = (string) $img; }
							}
							?>
							<div class="homepage__challenges-row">
								<div class="homepage__challenges-icon homepage__challenges-icon--solution">
									<?php if ( '' !== $src ) : ?>
										<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="22" height="22" loading="lazy">
									<?php else : ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                                        fill="none">
                                        <g clip-path="url(#clip0_1344_13435)">
                                            <mask id="mask0_1344_13435" style="mask-type:luminance"
                                                maskUnits="userSpaceOnUse" x="0" y="0" width="22" height="22">
                                                <path d="M0 1.90735e-06H22V22H0V1.90735e-06Z" fill="white" />
                                            </mask>
                                            <g mask="url(#mask0_1344_13435)">
                                                <path d="M15.5078 21.3555H1.32812V16.1992H15.5078V21.3555Z"
                                                    stroke="white" stroke-width="1.28906" stroke-miterlimit="10" />
                                                <path d="M1.32812 16.1992V11.043H15.5078V16.1992" stroke="white"
                                                    stroke-width="1.28906" stroke-miterlimit="10" />
                                                <path d="M1.32812 11.043V5.88672H10.3516" stroke="white"
                                                    stroke-width="1.28906" stroke-miterlimit="10" />
                                            </g>
                                            <path d="M3.26562 8.46484H4.55469" stroke="white" stroke-width="1.28906"
                                                stroke-miterlimit="10" />
                                            <path d="M5.84375 8.46484H7.13281" stroke="white" stroke-width="1.28906"
                                                stroke-miterlimit="10" />
                                            <path d="M3.26562 13.6211H4.55469" stroke="white" stroke-width="1.28906"
                                                stroke-miterlimit="10" />
                                            <path d="M5.84375 13.6211H7.13281" stroke="white" stroke-width="1.28906"
                                                stroke-miterlimit="10" />
                                            <path d="M3.26562 18.7773H4.55469" stroke="white" stroke-width="1.28906"
                                                stroke-miterlimit="10" />
                                            <path d="M5.84375 18.7773H7.13281" stroke="white" stroke-width="1.28906"
                                                stroke-miterlimit="10" />
                                            <mask id="mask1_1344_13435" style="mask-type:luminance"
                                                maskUnits="userSpaceOnUse" x="0" y="0" width="22" height="22">
                                                <path d="M0 1.90735e-06H22V22H0V1.90735e-06Z" fill="white" />
                                            </mask>
                                            <g mask="url(#mask1_1344_13435)">
                                                <path
                                                    d="M20.6719 5.80078C20.6719 8.64849 18.3633 10.957 15.5156 10.957C12.6679 10.957 10.3594 8.64849 10.3594 5.80078C10.3594 2.95307 12.6679 0.644531 15.5156 0.644531C18.3633 0.644531 20.6719 2.95307 20.6719 5.80078Z"
                                                    stroke="white" stroke-width="1.28906" stroke-miterlimit="10" />
                                                <path
                                                    d="M16.7969 4.51172C16.7969 5.22367 16.2197 5.80078 15.5078 5.80078C14.7959 5.80078 14.2188 5.22367 14.2188 4.51172C14.2188 3.79977 14.7959 3.22266 15.5078 3.22266C16.2197 3.22266 16.7969 3.79977 16.7969 4.51172Z"
                                                    stroke="white" stroke-width="1.28906" stroke-miterlimit="10" />
                                                <path
                                                    d="M18.0938 10.2656V9.66638C18.0938 8.24253 16.9395 7.08826 15.5156 7.08826C14.0918 7.08826 12.9375 8.24253 12.9375 9.66638V10.2656"
                                                    stroke="white" stroke-width="1.28906" stroke-miterlimit="10" />
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1344_13435">
                                                <rect width="22" height="22" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
									<?php endif; ?>
								</div>
								<div class="homepage__challenges-text">
									<?php if ( '' !== $title ) : ?>
										<h4 class="homepage__challenges-row-title"><?php echo esc_html( $title ); ?></h4>
									<?php endif; ?>
									<?php if ( '' !== $text ) : ?>
										<p class="homepage__challenges-row-description"><?php echo esc_html( $text ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
