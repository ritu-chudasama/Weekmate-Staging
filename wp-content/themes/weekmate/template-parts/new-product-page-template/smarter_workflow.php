<?php
/**
 * Section: Smarter Workflow
 * Layout: smarter_workflow
 */

$heading           = get_sub_field('heading');
$workflow_section  = get_sub_field('workflow_section');
?>

<section class="smarter-workflow-sec sectionCvr">
    <div class="container">

        <?php if ( ! empty($heading) ) : ?>
        <div class="row section-header">
            <div class="col-12">
                <h2 class="h1 heading-bold text-none"><?php echo esc_html($heading); ?></h2>
            </div>
        </div>
        <?php endif; ?>

        <?php if ( ! empty($workflow_section) ) : ?>
        <div class="row workflow-items">
            <?php foreach ( $workflow_section as $item ) :
                $image       = $item['image'];
                $title       = $item['title'];
                $description = $item['description'];
            ?>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="workflow-item">

                    <?php if ( ! empty($image['url']) ) : ?>
                    <div class="workflow-image">
                        <img src="<?php echo esc_url($image['url']); ?>"
                             alt="<?php echo esc_attr($image['alt']); ?>"
                             class="img-fluid">
                    </div>
                    <?php endif; ?>
                    <div class="workflow">
                    <?php if ( ! empty($title) ) : ?>
                    <h3 class="workflow-title heading-bold"><?php echo esc_html($title); ?></h3>
                    <?php endif; ?>

                    <?php if ( ! empty($description) ) : ?>
                    <div class="rich-text">
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                    <?php endif; ?>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>