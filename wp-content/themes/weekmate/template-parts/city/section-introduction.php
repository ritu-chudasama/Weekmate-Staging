<?php
/**
 * Flexible Content Layout: Introduction [introduction]
 * HTML structure mirrors index.html homepage__hr-solutions (two-column).
 * ACF fields: h3 (subtitle), h2 (heading), description, features (title,text), content (wysiwyg)
 * Left column  = header + numbered feature grid
 * Right column = description + WYSIWYG content
 *
 * @package WeekMate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$h3      = (string) get_sub_field( 'h3' );
$h2      = (string) get_sub_field( 'h2' );
$desc    = (string) get_sub_field( 'description' );
$content = (string) get_sub_field( 'content' );

// Highlight last word of heading.
$h2_markup = esc_html( $h2 );
$h2_trim   = trim( $h2 );
if ( '' !== $h2_trim && false !== strrpos( $h2_trim, ' ' ) ) {
	$pos = strrpos( $h2_trim, ' ' );
	$h2_markup = esc_html( substr( $h2_trim, 0, $pos ) ) . '<span class="homepage__business-title-highlight">' . esc_html( substr( $h2_trim, $pos + 1 ) ) . '</span>';
}
?>
<!-- HR Solutions Section -->
<section class="homepage__hr-solutions">
	<div class="container">
		<div class="homepage__hr-solutions-content">
			<div class="homepage__business-left">
				<div class="homepage__business-header">
					<?php if ( '' !== $h2_trim ) : ?>
						<h2 class="homepage__business-title-main"><?php echo $h2_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $h3 ) : ?>
						<p class="homepage__business-subtitle"><?php echo esc_html( $h3 ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( have_rows( 'features' ) ) : ?>
					<div class="homepage__business-features">
						<?php
						$i = 0;
						while ( have_rows( 'features' ) ) :
							the_row();
							$i++;
							$title = (string) get_sub_field( 'title' );
							$text  = (string) get_sub_field( 'text' );
							?>
							<div class="homepage__business-feature">
								<span class="homepage__business-number"><?php echo esc_html( sprintf( '%02d.', $i ) ); ?></span>
								<div class="homepage__business-feature-content">
									<?php if ( '' !== $title ) : ?>
										<h3 class="homepage__business-feature-title"><?php echo esc_html( $title ); ?></h3>
									<?php endif; ?>
									<?php if ( '' !== $text ) : ?>
										<p class="homepage__business-feature-text"><?php echo esc_html( $text ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="homepage__business-right">
				<div class="homepage__business-text-content">
					<?php
					if ( '' !== $desc ) {
						echo wpautop( wp_kses_post( $desc ) );
					}
					if ( '' !== trim( $content ) ) {
						echo wp_kses_post( $content );
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
