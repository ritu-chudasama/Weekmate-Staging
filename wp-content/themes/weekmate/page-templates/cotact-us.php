<?php
/**
 * Template Name: Contact Page
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */
get_header();
$banner_section = get_field('banner_section');
$contact_form = get_field('contact_form');
$faq_section = get_field('faq_section');
?>
<section class="sectionCvr">
	<div class="container">	
		<div class="row">
			<div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="contact-info-wrapper">
					<div class="row align-items-center contact-us">
						<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="form-content">
								<?php if ($contact_form) : ?>
									<div class="product-badges">
										<?php if (!empty($contact_form['logo'])) : ?>
											<img src="<?php echo esc_url($contact_form['logo']['url']); ?>" alt="WeekMate Logo" class="img-fluid">
										<?php endif; ?>
									</div>
						
									<?php if (!empty($contact_form['heading'])) : ?>
										<h1 class="form-title h1 heading-bold"><?php echo esc_html($contact_form['heading']); ?></h1>
									<?php endif; ?>
						
									<?php if (!empty($contact_form['sub_heading'])) : ?>
										<p class="form-subtitle"><?php echo esc_html($contact_form['sub_heading']); ?></p>
									<?php endif; ?>
						
									<?php if (!empty($contact_form['contacts'])) : ?>
									<ul class="social-icon-wrapper">
										<?php foreach ($contact_form['contacts'] as $row) : 
													$logo  = $row['logo'];
													$value = $row['value'];

													// Detect link type based on value format
													if ( is_email( $value ) ) {
														$href = 'mailto:' . antispambot( $value );
													} elseif ( preg_match('/^[+0-9\s\-()]{7,}$/', $value) ) {
														$tel  = preg_replace('/[^0-9+]/', '', $value);
														$href = 'tel:' . $tel;
													} else {
														$href = '';
													}
												?>
										<li>
											<?php if ($href) : ?>
											<a href="<?php echo esc_attr($href); ?>">
											<?php endif; ?>
												<?php if ($logo) : ?>
												<img src="<?php echo esc_url($logo['url']); ?>"
													alt="<?php echo esc_attr($value); ?>" class="icon">
												<?php endif; ?>
												<span class="social-text"><?php echo esc_html($value); ?></span>
											<?php if ($href) : ?>
											</a>
											<?php endif; ?>
										</li>
										<?php endforeach; ?>
									</ul>
									<?php endif; ?>
						
								<?php endif; ?>
							</div>
						</div>
						<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="contact-form-wrapper">
								<div class="contact-form-inner">
									<div class="contact-title">
										<h2 class="heading-bold">Fill Out the Form</h2>
									</div>
									<?php echo do_shortcode( '[contact-form-7 id="45d284c" title="Contact Form"]');?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="sectionCvr home-banner-sec advtool-sec contact-us-banner">
	<div class="container">	
		<div class="row align-items-center">	
			<div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
			<div class="banner-wrap">
					<div class="banner-rating">
						<ul class="rating-block">
							<li>
								<p class="rating-icon"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/rating-icon-1.png" align="rating-icon"></a></p>
								<p>
									<span class="rating">4.4</span>
									<span class="star-rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa-regular fa-star"></i>
									</span>
								</p>
							</li>
							<li>
								<p class="rating-icon"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/rating-icon-2.png" align="rating-icon"></a></p>
								<p>
									<span class="rating">4.6</span>
									<span class="star-rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa-regular fa-star"></i>
									</span>
								</p>
							</li>
						</ul>
					</div>
					<!-- Heading -->
                <?php if( !empty($banner_section['heading']) ): ?>
                    <h2 class="fw-bold mb-3">
                        <?php echo esc_html($banner_section['heading']); ?>
                    </h2>
                <?php endif; ?>

                <!-- Subheading -->
                <?php if( !empty($banner_section['sub_heading']) ): ?>
                    <p class="text-muted mb-4">
                        <?php echo esc_html($banner_section['sub_heading']); ?>
                    </p>
                <?php endif; ?>

                <!-- Button -->
                <?php if( !empty($banner_section['button']) ): ?>
                    <a href="<?php echo esc_url($banner_section['button']['url']); ?>" 
                       class="btn btn-primary">
                        <?php echo esc_html($banner_section['button']['title']); ?>
                    </a>
                <?php endif; ?>
            </div>
			</div>
			<?php if( !empty($banner_section['banner_section_part_2']) ): ?>
    <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
        <div class="home-banner-tabs">
            <div class="row">
                <?php foreach( $banner_section['banner_section_part_2'] as $item ): 
                    $logo   = $item['logo'];
                    $number = $item['numbers'];
                    $text   = $item['text'];
                ?>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="banner-card">
                            <?php if( !empty($logo) ): ?>
                                <div class="banner-icon">
                                    <img src="<?php echo esc_url($logo['url']); ?>" 
                                         alt="<?php echo esc_attr($logo['alt']); ?>" />
                                </div>
                            <?php endif; ?>
                            <div class="banner-card-content">
                                <?php if( !empty($number) ): ?>
                                    <h3 class="heading-bold card-count"><?php echo esc_html($number); ?></h3>
                                <?php endif; ?>
                                <?php if( !empty($text) ): ?>
                                    <p><?php echo esc_html($text); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

		</div>
	</div>
</section>
<section class="contact-why-choose why-choose-section sectionCvr">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="why-choose-wrap">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="banner-wrap">
					            
					            <div class="banner-details">
						            <div class="banner-title">
                                        <h2 class="heading-bold">Why choose us?</h2>
						            </div>
						            <p class="banner-desc">WeekMate is designed for teams that want SaaS software to be simple, reliable, and affordable. Get full access with WeekMate, no hidden costs, no monthly bills. It helps your team stay organized, communicate better, and get work done faster.</p>
					            </div>
                                <div class="banner-img">
                                    <img src="<?php echo site_url();?>/wp-content/uploads/2025/10/WeekMate_Image_PNG_1_1759488910728.png" alt="banner-img" width="100%" height="100%" />
                                </div>
				            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="accordion accordion-flush faqs-accordion" id="faqLists">
								<div class="accordion-item">
									<h3 class="accordion-header">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqcollapse-1" aria-expanded="false" aria-controls="faqcollapse-1">1. Scalable Pricing, Full Access</button>
									</h3>
									<div id="faqcollapse-1" class="accordion-collapse collapse show" data-bs-parent="#faqLists">
										<div class="accordion-body">
											<p>You make the payment and get full access with clear, upfront pricing and no ongoing fees.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h3 class="accordion-header">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqcollapse-2" aria-expanded="false" aria-controls="faqcollapse-2">2. Built for modern service teams</button>
									</h3>
									<div id="faqcollapse-2" class="accordion-collapse collapse " data-bs-parent="#faqLists">
										<div class="accordion-body">
											<p>WeekMate is built for fast-moving teams like consulting, IT, and support, without any unnecessary features or complexity.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h3 class="accordion-header">
										<button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#faqcollapse-3" aria-expanded="true" aria-controls="faqcollapse-3">3. Quick to set up & easy to use</button>
									</h3>
									<div id="faqcollapse-3" class="accordion-collapse collapse" data-bs-parent="#faqLists">
										<div class="accordion-body">
											<p>No complex onboarding or training required. Your team can start using WeekMate in just a few days.</p>
										</div>
									</div>
								</div>
                                <div class="accordion-item">
									<h3 class="accordion-header">
										<button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#faqcollapse-4" aria-expanded="true" aria-controls="faqcollapse-4">4. Simple design & navigation</button>
									</h3>
									<div id="faqcollapse-4" class="accordion-collapse collapse" data-bs-parent="#faqLists">
										<div class="accordion-body">
											<p>WeekMate keeps things clean and focused, so your team can spend less time figuring out tools and more time getting work done.</p>
										</div>
									</div>
								</div>
                                <div class="accordion-item">
									<h3 class="accordion-header">
										<button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#faqcollapse-5" aria-expanded="true" aria-controls="faqcollapse-5">5. Total data ownership</button>
									</h3>
									<div id="faqcollapse-5" class="accordion-collapse collapse" data-bs-parent="#faqLists">
										<div class="accordion-body">
											<p>You have full control of your data and can choose how to store and manage it securely.</p>
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sectionCvr faq-section ">
	<div class="container">
		<div class="row">
			<div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="row justify-content-between align-items-center">
					<div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9 col-sm-12">
						<div class="title-block-wrapper title-block pb-0 mb-0">
							<h2 class="title"><?php echo $faq_section['heading']; ?></h2>
						</div>
					</div>
					<div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-12">
						<div class="block-cta">
							<?php if ( ! empty( $faq_section['button']['url'] ) && ! empty( $faq_section['button']['title'] ) ) : ?>
								<p class="mb-0">
									<a href="<?php echo esc_url( $faq_section['button']['url'] ); ?>" 
									class="theme-btn mt-0" 
									data-bs-toggle="modal" 
									data-bs-target="#popupModal">
										<?php echo esc_html( $faq_section['button']['title'] ); ?>
									</a>
								</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="faq-qa-wrapper">
					<div class="row">
						<div class="combined" id="faqMain">
						<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="accordion accordion-flush faqs-accordion" id="faqLists2">
                                <?php 
                                $faq1Lists = $faq_section['faq_repeater']; 
                                $faq1 = 0;
                                foreach($faq1Lists as $faq1List) { 
                                    $faq1++;  
                                    // Unique IDs by combining faqLists2 + index
                                    $collapseID = "faqLists2-collapse-" . $faq1;
                                ?>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button <?php echo ($faq1 != 1) ? 'collapsed' : ''; ?>"
                                            type="button" 
                                            data-bs-toggle="collapse"
                                            data-bs-target="#<?php echo $collapseID; ?>"
                                            aria-expanded="<?php echo ($faq1 == 3) ? 'true' : 'false'; ?>"
                                            aria-controls="<?php echo $collapseID; ?>">
                                            <?php echo $faq1List['title']; ?>
                                        </button>
                                    </h3>
                                    <div id="<?php echo $collapseID; ?>" class="accordion-collapse collapse <?php echo ($faq1 == 1) ? 'show' : ''; ?>" data-bs-parent="#faqMain">
                                        <div class="accordion-body">
                                            <?php echo $faq1List['content']; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
						<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="accordion accordion-flush faqs-accordion" id="faqLists1">
								<?php $faq2Lists = $faq_section['faq_repeater_2']; 
								$faq2 = 0;
								foreach($faq2Lists as $faq2List) { $faq2++;  ?>
                                    <div class="accordion-item">
                                        <h3 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1collapse-<?php echo $faq2; ?>" aria-expanded="<?php if($faq2 == 1 ){ echo 'true'; } else { echo "false"; } ?>" aria-controls="faqcollapse-<?php echo $faq2; ?>"><?php echo $faq2List['title']; ?></button>
                                        </h3>
                                        <div id="faq1collapse-<?php echo $faq2; ?>" class="accordion-collapse collapse" data-bs-parent="#faqMain">
                                            <div class="accordion-body">
                                                <?php echo $faq2List['content']; ?>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();