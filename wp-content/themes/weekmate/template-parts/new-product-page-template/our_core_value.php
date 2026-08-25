<?php
/**
 * Section: Our Core Value
 * Layout: our_core_value
 * Note: Uses existing theme CSS/JS
 */

$our_core_value = get_field('our_core_value', 'option');

$heading     = $our_core_value['heading'];
$description = $our_core_value['description'];
$button      = $our_core_value['button'];
$image       = $our_core_value['image'];
?>

<!-- <section class="ourvalues-sec pdp-ourvalues">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="ourvalues-wrapper">
                    <div class="row">
                        <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                            <div class="ourvalues-column-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12 pe-0">
                                        <div class="ourvalues-img ourvalues-column">
                                            <?php if ( ! empty($image['url']) ) : ?>
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-xxl-7 col-xl-7 col-lg-6 col-md-12 col-sm-12 ps-0">
                                        <div class="ourvalues-wrap ourvalues-column">
                                            <div class="title-block">
                                                <h2 class="title mb-0 text-none"><?php echo esc_html($heading); ?></h2>
                                            </div>
                                            <p class="desc"><?php echo esc_html($description); ?></p>
                                            <?php if ( ! empty($button['url']) ) : ?>
                                            <p class="block-cta mb-0">
                                                <a href="<?php echo esc_url($button['url']); ?>"
                                                    class="theme-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#popupModal">
                                                    <?php echo esc_html($button['title']); ?>
                                                </a>
                                            </p>
                                            <?php endif; ?>
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
</section> -->