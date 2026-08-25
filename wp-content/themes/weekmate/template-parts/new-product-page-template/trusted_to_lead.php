<?php
/**
 * Section: Trusted To Lead
 * Layout: trusted_to_lead
 * Note: Uses existing theme CSS/JS
 */

$logo    = get_sub_field('logo');
$tagline = get_sub_field('tagline');
$images  = get_sub_field('images');
?>

<section class="certificate-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="certificate-wrapper">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <div class="certificate-title">
                                <img src="<?php echo esc_url($logo['url']); ?>"
                                    alt="<?php echo esc_attr($logo['alt']); ?>">
                                <p><?php echo esc_html($tagline); ?></p>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12">
                            <span class="seprator">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/sperator-line.png" alt="seprator">
                            </span>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="certificate-lists">
                                <ul class="certificates">
                                    <?php if ( ! empty($images) ) :
                                        foreach ( $images as $image ) : ?>
                                    <li>
                                        <img src="<?php echo esc_url($image['url']); ?>"
                                            alt="<?php echo esc_attr($image['alt']); ?>">
                                    </li>
                                    <?php endforeach;
                                    else : ?>
                                    <p>No images available.</p>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>