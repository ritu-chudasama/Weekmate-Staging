<?php
/**
 * Section: Banner
 * Layout: banner_section
 */

$heading          = get_sub_field('title');
$description      = get_sub_field('description');
$button           = get_sub_field('button');
$section_image    = get_sub_field('image');
$background_image = get_sub_field('background_image');
$social_icons     = get_sub_field('social_icons');
$icon_label     = get_sub_field('icon_label');

?>

<section class="mcp-banner-section sectionCvr"
    <?php if ($background_image) : ?>
        style="background-image:url('<?php echo esc_url($background_image['url']); ?>');"
    <?php endif; ?>>
    
    <div class="container">
        <div class="row align-items-center justify-content-center">

            <div class="col-lg-7">
                <div class="banner-content">

                    <?php if ($heading) : ?>
                        <h1 class="banner-title">
                            <?php echo esc_html($heading); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if ($description) : ?>
                        <div class="banner-subtitle">
                            <?php echo wp_kses_post($description); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($button) : ?>
                        <a href="<?php echo esc_url($button['url']); ?>"
                           class="btn theme-btn"
                           target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                            <?php echo esc_html($button['title']); ?>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7">
            <?php if ($section_image) : ?>
                <img
                    src="<?php echo esc_url($section_image['url']); ?>"
                    alt="<?php echo esc_attr($section_image['alt']); ?>"
                    class="img-fluid">
            <?php endif; ?>
        </div>
        <?php
            if ($social_icons) : ?>
                <div class="bottom-content-wrapper">
                            <?php if ($icon_label) : ?>
                                <span class="banner-social-title">
                                    <?php echo esc_html($icon_label); ?>
                                </span>
                            <?php endif; ?>
                    <div class="banner-social-icons">
                        <?php foreach ($social_icons as $item) : 

                            $icon = $item['icon']; 
                            if ($icon) :
                        ?>
                            <img
                                src="<?php echo esc_url($icon['url']); ?>"
                                alt="<?php echo esc_attr($icon['alt']); ?>"
                                class="social-icon">
                        <?php
                            endif;
                        endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>