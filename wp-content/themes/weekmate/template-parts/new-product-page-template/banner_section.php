<?php
/**
 * Section: Banner
 * Layout: banner_section
 * Note: Uses existing theme CSS/JS
 */

$logo          = get_sub_field('logo');
$heading       = get_sub_field('heading');
$description   = get_sub_field('description');
$button        = get_sub_field('button');
$section_image = get_sub_field('section_image');
?>

<section class="product-banner-section sectionCvr">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="banner-conetnt">
                    <?php if ( ! empty($logo['url']) ) : ?>
                    <div class="product-badges">
                        <img src="<?php echo esc_url($logo['url']); ?>"
                            alt="<?php echo esc_attr($logo['alt']); ?>" class="img-fluid">
                    </div>
                    <?php endif; ?>
                    <h1 class="banner-title text-none"><?php echo esc_html($heading); ?></h1>
                    <p class="banner-subtitle"><?php echo esc_html($description); ?></p>
                    <a href="<?php echo esc_url($button['url']); ?>"
                        class="btn theme-btn"
                        target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
                        rel="noopener noreferrer">
                        <?php echo esc_html($button['title']); ?>
                    </a>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                <img src="<?php echo esc_url($section_image['url']); ?>"
                    alt="<?php echo esc_attr($section_image['alt']); ?>" class="img-fluid">
            </div>
        </div>
    </div>
</section>