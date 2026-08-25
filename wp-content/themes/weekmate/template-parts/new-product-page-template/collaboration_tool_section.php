<?php
/**
 * Section: Collaboration Tool
 * Layout: collaboration_tool_section
 * Note: Uses existing theme CSS/JS
 */

$heading                     = get_sub_field('heading');
$subheading                  = get_sub_field('subheading');
$button                      = get_sub_field('button');
$collaboration_tool_repeater = get_sub_field('collaboration_tool_repeater');
?>

<section class="collaboration-tool-section-sec sectionCvr">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 section-header">
                <div class="small-section-header text-center">
                    <?php if ( ! empty($heading) ) : ?>
                    <h2 class="why-to-choose-section-title heading-bold h1 text-none"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>
                    <p><?php echo esc_html($subheading); ?></p>
                </div>
            </div>
        </div>
        <div class="row collaboration-tool-section-scroll">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 collaboration-tool-top-header">
                <div class="collaboration-tool-selector">
                    <?php if ( ! empty($collaboration_tool_repeater) ) :
                        foreach ( $collaboration_tool_repeater as $key => $data ) :
                            $active_class = ( $key == 0 ) ? 'active' : ''; ?>
                    <div class="<?php echo $active_class; ?> tool-item" data-target="tool_item_content_<?php echo $key; ?>">
                        <h3 class="tool-header"><?php echo esc_html($data['title']); ?></h3>
                    </div>
                    <?php endforeach;
                    endif; ?>
                </div>
                <?php if ( ! empty($button['url']) && ! empty($button['title']) ) : ?>
                <a href="<?php echo esc_url($button['url']); ?>" class="btn theme-btn">
                    <?php echo esc_html($button['title']); ?>
                </a>
                <?php endif; ?>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="collaboration-tool-body">
                    <?php if ( ! empty($collaboration_tool_repeater) ) :
                        foreach ( $collaboration_tool_repeater as $key => $data ) :
                            $hide_content = ( $key !== 0 ) ? 'display:none;' : ''; ?>
                    <div class="tool-item-content" id="tool_item_content_<?php echo $key; ?>" style="<?php echo $hide_content; ?>">
                        <h3 class="collaboration-tool-header heading-bold"><?php echo esc_html($data['title']); ?></h3>
                        <p><?php echo esc_html($data['description']); ?></p>
                    </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>