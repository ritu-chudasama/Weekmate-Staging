<?php
/**
 * Section: Implementation Steps
 * Layout: implementation_steps
 * Note: Uses existing theme CSS/JS
 */

$heading                  = get_sub_field('heading');
$descripation             = get_sub_field('descripation');
$button                   = get_sub_field('button');
$implementation_repeater  = get_sub_field('implementation_repeater');
?>

<section class="setup-process-section sectionCvr">
    <div class="container">
        <div class="row section-header">
            <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12 col-sm-12">
                <?php if ( ! empty($heading) ) : ?>
                <h2 class="setup-process-title h1 heading-bold text-none"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
            </div>
            <div class="col-xxl-7 col-xl-7 col-lg-12 col-md-12 col-sm-12">
                <?php if ( ! empty($descripation) ) : ?>
                <p><?php echo esc_html($descripation); ?></p>
                <?php endif; ?>
                <?php if ( ! empty($button['url']) ) : ?>
                <a href="<?php echo esc_url($button['url']); ?>" class="btn theme-btn">
                    <?php echo esc_html($button['title']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <?php if ( ! empty($implementation_repeater) ) :
                foreach ( $implementation_repeater as $key => $process ) :
                    $key++; ?>
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-12 col-sm-12 setup-process-item">
                <div class="process-item">
                    <?php if ( ! empty($process['image']['url']) ) : ?>
                    <div class="process-image">
                        <img src="<?php echo esc_url($process['image']['url']); ?>"
                            alt="<?php echo esc_attr($process['image']['alt']); ?>" class="img-fluid">
                    </div>
                    <?php endif; ?>
                    <h3 class="setup-conetnt-process-title heading-bold">
                        <span>#<?php echo $key; ?></span><?php echo esc_html($process['title']); ?>
                    </h3>
                    <p><?php echo esc_html($process['descripation']); ?></p>
                </div>
            </div>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>