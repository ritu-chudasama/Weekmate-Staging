<?php
/**
 * Section: Why To Choose Accordion
 * Layout: why_to_choose_accordion
 * Note: Uses existing theme CSS/JS
 */
 
$heading                = get_sub_field('heading');
$subheading             = get_sub_field('subheading');
$button                 = get_sub_field('button');
$why_to_choose_repeater = get_sub_field('why_to_choose_repeater');
?>
 
<section class="why-to-choose-accordion-sec sectionCvr">
    <div class="container">
        <div class="row section-header align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <?php if ( ! empty($heading) ) : ?>
                <h2 class="setup-process-title h1 heading-bold text-none"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ( ! empty($subheading) ) : ?>
                <p><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 text-md-end">
                <?php if ( ! empty($button['url']) ) : ?>
                <a href="<?php echo esc_url($button['url']); ?>" class="btn theme-btn mt-0">
                    <?php echo esc_html($button['title']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
 
        <div class="row why-to-choose-accordion">
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12 col-sm-12">
                <div class="accordion-selector">
                    <?php if ( ! empty($why_to_choose_repeater) ) :
                        foreach ( $why_to_choose_repeater as $key => $accordion ) :
                            $active_class = ( $key == 0 ) ? 'active' : '';
                            $checkbox     = ! empty($accordion['checkbox']);
                            $sub_group    = ! empty($accordion['sub_group']) ? $accordion['sub_group'] : array();
                        ?>
 
                        <div class="<?php echo $active_class; ?> accordion-item<?php echo ( $checkbox && ! empty($sub_group) ) ? ' has-subs' : ''; ?>" data-target="accordion_content_<?php echo $key; ?>">
                            <div class="accordion-item-head">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 52 52" fill="none">
                                        <circle cx="27" cy="27" r="21" fill="white"></circle>
                                        <path d="M23.1839 36.545C23.6078 36.545 24.0316 36.3888 24.3663 36.0542L32.2413 28.1791C32.8883 27.5322 32.8883 26.4614 32.2413 25.8144L24.3663 17.9393C23.7193 17.2924 22.6485 17.2924 22.0015 17.9393C21.3546 18.5863 21.3546 19.6571 22.0015 20.3041L28.6942 26.9968L22.0015 33.6895C21.3546 34.3364 21.3546 35.4073 22.0015 36.0542C22.3138 36.3888 22.7377 36.545 23.1839 36.545Z" fill="#005282"></path>
                                    </svg>
                                </span>
                                <h3 class="accordion-header"><?php echo esc_html($accordion['title']); ?></h3>
                            </div>
                        </div>
 
                        <?php // Sub-titles as sibling items, shown only when their parent title is active ?>
                        <?php if ( $checkbox && ! empty($sub_group) ) : ?>
                            <?php foreach ( $sub_group as $sub_key => $sub ) :
                                $sub_active = ( $sub_key == 0 ) ? 'active' : ''; ?>
                                <div class="accordion-subtitle <?php echo $sub_active; ?>"
                                    data-parent="accordion_content_<?php echo $key; ?>"
                                    data-sub-target="sub_content_<?php echo $key; ?>_<?php echo $sub_key; ?>">
                                    <div class="accordion-item-head">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 52 52" fill="none">
                                                <circle cx="27" cy="27" r="21" fill="white"></circle>
                                                <path d="M23.1839 36.545C23.6078 36.545 24.0316 36.3888 24.3663 36.0542L32.2413 28.1791C32.8883 27.5322 32.8883 26.4614 32.2413 25.8144L24.3663 17.9393C23.7193 17.2924 22.6485 17.2924 22.0015 17.9393C21.3546 18.5863 21.3546 19.6571 22.0015 20.3041L28.6942 26.9968L22.0015 33.6895C21.3546 34.3364 21.3546 35.4073 22.0015 36.0542C22.3138 36.3888 22.7377 36.545 23.1839 36.545Z" fill="#005282"></path>
                                            </svg>
                                        </span>
                                        <h3 class="accordion-header"><?php echo esc_html($sub['sub_title']); ?></h3>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
 
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
 
            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                <div class="accordion-body">
                    <?php if ( ! empty($why_to_choose_repeater) ) :
                        foreach ( $why_to_choose_repeater as $key => $accordion ) :
                            $hide_content = ( $key !== 0 ) ? 'display:none;' : '';
                            $checkbox     = ! empty($accordion['checkbox']);
                            $sub_group    = ! empty($accordion['sub_group']) ? $accordion['sub_group'] : array();
                        ?>
                    <div class="accordion-item-content" id="accordion_content_<?php echo $key; ?>" style="<?php echo $hide_content; ?>">
 
                        <?php if ( $checkbox && ! empty($sub_group) ) : ?>
 
                            <?php foreach ( $sub_group as $sub_key => $sub ) :
                                $sub_hide = ( $sub_key !== 0 ) ? 'display:none;' : ''; ?>
                                <div class="accordion-sub-content" id="sub_content_<?php echo $key; ?>_<?php echo $sub_key; ?>" style="<?php echo $sub_hide; ?>">
                                    <h3 class="accordion-header heading-bold"><?php echo esc_html($sub['sub_title']); ?></h3>
                                    <div class="rich-text">
                                        <p><?php echo esc_html($sub['sub_description']); ?></p>
                                    </div>
                                    <?php if ( ! empty($sub['sub_image']['url']) ) : ?>
                                        <img src="<?php echo esc_url($sub['sub_image']['url']); ?>"
                                             alt="<?php echo esc_attr($sub['sub_image']['alt']); ?>" class="img-fluid">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
 
                        <?php else : ?>
 
                            <h3 class="accordion-header heading-bold"><?php echo esc_html($accordion['title']); ?></h3>
                            <div class="rich-text">
                                <p><?php echo esc_html($accordion['description']); ?></p>
                            </div>
                            <?php if ( ! empty($accordion['image']['url']) ) : ?>
                                <img src="<?php echo esc_url($accordion['image']['url']); ?>"
                                     alt="<?php echo esc_attr($accordion['image']['alt']); ?>" class="img-fluid">
                            <?php endif; ?>
 
                        <?php endif; ?>
 
                    </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
 
<style>
/* icon + title on one row (applies to main items and sub items) */
.accordion-selector .accordion-item-head {
    display: flex;
    align-items: center;
    gap: 14px;
}
 
/* sub-title item: looks like an accordion card, hidden until its parent is active */
.accordion-selector .accordion-subtitle {
    display: none;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 5px;
    border-radius: 40px;
    padding: 5px 15px;
    cursor: pointer;
    gap: 1rem;
    transition: all 0.4s ease-in;
    margin-left: 50px;

}

.accordion-selector .accordion-item-head .icon {
    height: 44px;
    width: 44px;
}
 
.accordion-selector .accordion-subtitle.is-visible {
    display: flex;
}

.accordion-selector .accordion-item-head .icon svg {
    width: 100%;
    height: 100%;
}
 
.accordion-selector .accordion-subtitle:hover {
    background: #F4F9FF;
}
 
.accordion-selector .accordion-subtitle .accordion-header {
    flex: 1;
    font-size: 16px;
    font-weight: 500;
}


.accordion-selector .accordion-item:has(.accordion-subtitle) .accordion-item-head .icon svg {
    transform: rotate(90deg);
    transition: transform 0.3s ease;
}

 
/* active sub-title: navy card, white text (matches main active style) */
.accordion-selector .accordion-subtitle.active {
    background: #005282;
    border-color: #005282;
}
 
.accordion-selector .accordion-subtitle.active .accordion-header {
    color: #ffffff;
}
 

</style>
 
<script>
jQuery(function ($) {

    function showSubtitles(targetId) {
        
        $('.accordion-subtitle').removeClass('is-visible');
        $('.accordion-subtitle[data-parent="' + targetId + '"]').addClass('is-visible');
    }

    var $activeItem = $('.accordion-item.active').first();
    if ($activeItem.length) {
        showSubtitles($activeItem.data('target'));
    }

    // $('.accordion-item')
    //     .off('click.accordionMain')
    //     .on('click.accordionMain', function () {
    //         var $item = $(this);

    //         $('.accordion-item').removeClass('active');
    //         $item.addClass('active');

    //         var targetId = $item.data('target');
    //         showSubtitles(targetId);

    //         if ($item.hasClass('has-subs')) {
    //             return;
    //         }

    //         var targetContent = $('#' + targetId);
    //         if (!targetContent.is(':visible')) {
    //             $('.accordion-item-content').stop(true, true).slideUp();
    //             targetContent.stop(true, true).slideDown();
    //         }
    //     });

        //19th August 2026
$(document)
    .off('click.accordionMain', '.accordion-item')
    .on('click.accordionMain', '.accordion-item', function () {

        var $item = $(this);
        var targetId = $item.data('target');

        $('.accordion-item').removeClass('active');
        $item.addClass('active');

        $('.accordion-subtitle').removeClass('is-visible');

        $('.accordion-subtitle[data-parent="' + targetId + '"]')
            .addClass('is-visible');

        var $targetContent = $('#' + targetId);

        if (!$targetContent.is(':visible')) {

            $('.accordion-item-content')
                .stop(true, true)
                .slideUp();

            $targetContent
                .stop(true, true)
                .slideDown();
        }
    });
        //19th August 2026


//commented on 19th August 2026
    // $('.accordion-subtitle')
    //     .off('click.accordionSub')
    //     .on('click.accordionSub', function () {
    $(document)
    .off('click.accordionSub', '.accordion-subtitle')
    .on('click.accordionSub', '.accordion-subtitle', function () {
            var $sub    = $(this);
            var parent  = $sub.data('parent');
            var subId   = $sub.data('sub-target');
            var $panel  = $('#' + parent);
            var $target = $('#' + subId);

            $('.accordion-subtitle[data-parent="' + parent + '"]').removeClass('active');
            $sub.addClass('active');

            if (!$panel.is(':visible')) {
                $('.accordion-item-content').stop(true, true).slideUp();
                $panel.stop(true, true).slideDown();
            }

            if ($target.is(':visible')) return;

            $panel.find('.accordion-sub-content').stop(true, true).slideUp();
            $target.stop(true, true).slideDown();
        });

});
</script>