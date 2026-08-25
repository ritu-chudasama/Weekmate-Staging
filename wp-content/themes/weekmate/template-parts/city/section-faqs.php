<?php
/**
 * Flexible Content Layout: FAQ [faq_section]
 * Fields: heading, button (link field: url, title), items (repeater: question, answer)
 *
 * Single repeater, auto-split into two columns. Two-column Bootstrap
 * accordion (accordion-flush) — uses existing theme CSS/JS, no custom
 * toggle script needed. First item opens by default.
 *
 * @package WeekMate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = get_sub_field( 'h2' );
$button_label = (string) get_sub_field( 'button_label' );
$button_url   = (string) get_sub_field( 'button_url' );

$items = array();
if ( have_rows( 'items' ) ) {
	while ( have_rows( 'items' ) ) {
		the_row();
		$q = (string) get_sub_field( 'question' );
		$a = (string) get_sub_field( 'answer' );
		if ( '' === $q && '' === $a ) {
			continue;
		}
		$items[] = array( $q, $a );
	}
}

if ( empty( $heading ) && empty( $button ) && empty( $items ) ) {
	return;
}

$total = count( $items );
$left  = (int) ceil( $total / 2 );
$cols  = array(
	array_slice( $items, 0, $left ),
	array_slice( $items, $left ),
);
$idx   = 0;
?>
<section class="sectionCvr faq-section">
	<div class="container">
		<div class="row">
			<div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="row justify-content-between align-items-center">
					<div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9 col-sm-12">
						<div class="title-block-wrapper title-block pb-0 mb-0">
							<?php if ( ! empty( $heading ) ) : ?>
								<h2 class="title text-none"><?php echo esc_html( $heading ); ?></h2>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-12">
						<?php if ( ! empty( $button_label ) && ! empty( $button_url ) ) : ?>
							<div class="block-cta">
								<p class="mb-0">
									<a href="<?php echo esc_url( $button_url ); ?>"
										class="theme-btn mt-0"
										data-bs-toggle="modal"
										data-bs-target="#popupModal">
										<?php echo esc_html( $button_label ); ?>
									</a>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="row">
				<div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
					<div class="faq-qa-wrapper">
						<div class="row">
							<div class="row" id="faqMain">

								<?php foreach ( $cols as $col_index => $column ) : ?>
									<!-- FAQ Column <?php echo esc_html( $col_index + 1 ); ?> -->
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
										<div class="accordion accordion-flush faqs-accordion">
											<?php
											foreach ( $column as $item ) :
												list( $question, $answer ) = $item;
												$is_open  = ( 0 === $idx );
												$panel_id = 'faqcollapse-' . $idx;
												$idx++;
												?>
												<div class="accordion-item">
													<h3 class="accordion-header">
														<button class="accordion-button <?php echo $is_open ? '' : 'collapsed'; ?>"
															type="button"
															data-bs-toggle="collapse"
															data-bs-target="#<?php echo esc_attr( $panel_id ); ?>"
															aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
															aria-controls="<?php echo esc_attr( $panel_id ); ?>">
															<?php echo esc_html( $question ); ?>
														</button>
													</h3>
													<div id="<?php echo esc_attr( $panel_id ); ?>"
														class="accordion-collapse collapse <?php echo $is_open ? 'show' : ''; ?>"
														data-bs-parent="#faqMain">
														<div class="accordion-body">
															<?php echo wp_kses_post( $answer ); ?>
														</div>
													</div>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endforeach; ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>