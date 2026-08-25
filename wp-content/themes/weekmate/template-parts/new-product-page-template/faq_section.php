<?php
/**
 * Section: FAQ
 * Layout: faq_section
 * Note: Uses existing theme CSS/JS (bootstrap accordion)
 */

$heading       = get_sub_field('heading');
$button        = get_sub_field('button');
$faq_repeater  = get_sub_field('faq_repeater');
$faq_repeater_2 = get_sub_field('faq_repeater_2');
?>

<section class="sectionCvr faq-section pt-0">
    <div class="container">
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9 col-sm-12">
                        <div class="title-block-wrapper title-block pb-0 mb-0">
                            <h2 class="title text-none"><?php echo esc_html($heading); ?></h2>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-12">
                        <?php if ( ! empty($button['url']) && ! empty($button['title']) ) : ?>
                        <div class="block-cta">
                            <p class="mb-0">
                                <a href="<?php echo esc_url($button['url']); ?>"
                                    class="theme-btn mt-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#popupModal">
                                    <?php echo esc_html($button['title']); ?>
                                </a>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="faq-qa-wrapper">
                    <div class="row">
                        <div class="combined" id="faqMain">
                        <!-- FAQ Column 1 -->
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="accordion accordion-flush faqs-accordion">
                                <?php
                                $faq1 = 0;
                                if ( ! empty($faq_repeater) ) :
                                    foreach ( $faq_repeater as $faq1List ) :
                                        $faq1++; ?>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button <?php echo ( $faq1 != 1 ) ? 'collapsed' : ''; ?>"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faqcollapse-<?php echo $faq1; ?>"
                                            aria-expanded="<?php echo ( $faq1 == 1 ) ? 'true' : 'false'; ?>"
                                            aria-controls="faqcollapse-<?php echo $faq1; ?>">
                                            <?php echo esc_html($faq1List['title']); ?>
                                        </button>
                                    </h3>
                                    <div id="faqcollapse-<?php echo $faq1; ?>"
                                        class="accordion-collapse collapse <?php echo ( $faq1 == 1 ) ? 'show' : ''; ?>"
                                        data-bs-parent="#faqMain">
                                        <div class="accordion-body">
                                            <?php echo wp_kses_post($faq1List['content']); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;
                                endif; ?>
                            </div>
                        </div>
                        <!-- FAQ Column 2 -->
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="accordion accordion-flush faqs-accordion">
                                <?php
                                $faq2 = 0;
                                if ( ! empty($faq_repeater_2) ) :
                                    foreach ( $faq_repeater_2 as $faq2List ) :
                                        $faq2++; ?>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq1collapse-<?php echo $faq2; ?>"
                                            aria-expanded="false"
                                            aria-controls="faq1collapse-<?php echo $faq2; ?>">
                                            <?php echo esc_html($faq2List['title']); ?>
                                        </button>
                                    </h3>
                                    <div id="faq1collapse-<?php echo $faq2; ?>"
                                        class="accordion-collapse collapse"
                                        data-bs-parent="#faqMain">
                                        <div class="accordion-body">
                                            <?php echo wp_kses_post($faq2List['content']); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;
                                endif; ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>