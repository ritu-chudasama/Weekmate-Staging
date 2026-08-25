<?php
/**
 * Section: CTA Banner
 * Layout: cta_banner
 * Note: NEW section - has own CSS
 */

$heading          = get_sub_field('heading');
$button           = get_sub_field('button');
$background_image = get_sub_field('background_image');
$cta_stats        = get_sub_field('cta_stats_repeater');
$side_image       = get_sub_field('side_image');
?>

<section class="cta-banner-section sectionCvr container"
    <?php if ( ! empty($background_image['url']) ) : ?>
        style="background-image: url('<?php echo esc_url($background_image['url']); ?>');"
    <?php endif; ?>>
        <div class="cta-banner-section-container">

            <!-- Left Image -->
            <div class="cta-banner-section-container-image">
                <?php if ( ! empty($side_image['url']) ) : ?>
                <div class="cta-left-image">
                    <img src="<?php echo esc_url($side_image['url']); ?>"
                         alt="<?php echo esc_attr($side_image['alt']); ?>">
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Content -->
            <div class="cta-banner-section-container-content">
                <div class="cta-content">

                    <?php if ( $heading ) : ?>
                    <h2 class="text-none"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>

                    <?php if ( ! empty($cta_stats) ) : ?>
                    <ul class="cta-checklist">
                        <?php foreach ( $cta_stats as $stat ) : ?>
                        <li>
                            <span class="check-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M10.8333 0C4.86417 0 0 4.86417 0 10.8333C0 16.8025 4.86417 21.6667 10.8333 21.6667C16.8025 21.6667 21.6667 16.8025 21.6667 10.8333C21.6667 4.86417 16.8025 0 10.8333 0ZM16.0117 8.34167L9.86917 14.4842C9.7175 14.6358 9.51167 14.7225 9.295 14.7225C9.07833 14.7225 8.8725 14.6358 8.72083 14.4842L5.655 11.4183C5.34083 11.1042 5.34083 10.5842 5.655 10.27C5.96917 9.95583 6.48917 9.95583 6.80333 10.27L9.295 12.7617L14.8633 7.19333C15.1775 6.87917 15.6975 6.87917 16.0117 7.19333C16.3258 7.5075 16.3258 8.01667 16.0117 8.34167Z" fill="white"/>
                                </svg>
                            </span>
                            <?php echo esc_html($stat['label']); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <?php if ( ! empty($button['url']) ) : ?>
                    <div class="cta-btn-wrap">
                        <a href="<?php echo esc_url($button['url']); ?>"
                            class="btn"
                            target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                            <?php echo esc_html($button['title']); ?>
                        </a>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
</section>