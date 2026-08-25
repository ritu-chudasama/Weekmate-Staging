<?php
/**
 * Section: Setup Process
 * Layout: setup_process
 * Note: Uses existing theme CSS/JS
 */

$heading                = get_sub_field('heading');
$subheading             = get_sub_field('subheading');
$setup_process_repeater = get_sub_field('setup_process_repeater');
?>


<section class="setup-process sectionCvr ecrm-grid-features">
    <div class="container">

        <div class="row ecrm-grid-features__header">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <?php if ( ! empty($heading) ) : ?>
                <h2 class="ecrm-grid-features__title h1 heading-bold text-none">
                    <?php echo esc_html($heading); ?>
                </h2>
                <?php endif; ?>
                <?php if ( ! empty($subheading) ) : ?>
                <p class="ecrm-grid-features__subtitle">
                    <?php echo esc_html($subheading); ?>
                </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <?php if ( ! empty($setup_process_repeater) ) :
                foreach ( $setup_process_repeater as $process ) : ?>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 ecrm-grid-features__item">
                <div class="ecrm-grid-features__inner">
                    <?php if ( ! empty($process['image']['url']) ) : ?>
                    <img src="<?php echo esc_url($process['image']['url']); ?>"
                        alt="<?php echo esc_attr($process['image']['alt']); ?>"
                        class="ecrm-grid-features__icon img-fluid">
                    <?php endif; ?>
                    <?php if ( ! empty($process['title']) ) : ?>
                    <h3 class="ecrm-grid-features__item-title heading-bold">
                        <?php echo esc_html($process['title']); ?>
                    </h3>
                    <?php endif; ?>
                    <?php if ( ! empty($process['description']) ) : ?>
                    <p class="ecrm-grid-features__desc">
                        <?php echo esc_html($process['description']); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach;
            endif; ?>
        </div>

    </div>
</section>