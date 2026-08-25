<?php
/**
 * Section: Testimonials
 * Layout: testimonials_section
 * Note: Uses existing theme CSS/JS (slick slider)
 */

$testimonials_section  = get_field('testimonials_section_copy', 'option');

$heading               = $testimonials_section['heading'];
$testimonials_repeater = $testimonials_section['testimonials_repeater'];

$colorClasses = [
    "light-mint-bg-clr",
    "soft-peach-bg-clr",
    "light-ivory-bg-clr",
    "sky-blue-bg-clr",
    "lavender-mist-bg-clr",
    "off-white-bg-clr",
    "light-lavender-bg-clr"
];
?>

<section class="sectionCvr testimonials-sec">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center title-block">
                    <h2 class="title text-none"><?php echo esc_html($heading); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid g-0">
        <div class="row">
            <div class="col-xxl-11 col-xl-12 col-lg-12 col-md-12 col-sm-12 ms-auto">
                <div class="testimonials-wrapper">
                    <div id="testimonials-slider" class="testimonials-slider">
                        <?php
                        $testi = 0;
                        if ( ! empty($testimonials_repeater) ) :
                            foreach ( $testimonials_repeater as $testiList ) :
                                $testirandomClass = $colorClasses[$testi % count($colorClasses)]; ?>
                        <div class="testimonials-item">
                            <div class="testimonials-block <?php echo esc_attr($testirandomClass); ?>">
                                <div class="testi-img-play">
                                    <p class="testi-img">
                                        <?php if ( ! empty($testiList['client_image']['url']) ) : ?>
                                        <img src="<?php echo esc_url($testiList['client_image']['url']); ?>"
                                            alt="<?php echo esc_attr($testiList['client_image']['alt']); ?>">
                                        <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/test-img-avatar.png"
                                            alt="testimonial">
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="testi-content">
                                    <p><?php echo esc_html($testiList['content']); ?></p>
                                </div>
                                <div class="testi-author">
                                    <p class="author"><?php echo esc_html($testiList['client_name']); ?></p>
                                    <p class="desig"><?php echo esc_html($testiList['designation']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $testi++;
                        endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>