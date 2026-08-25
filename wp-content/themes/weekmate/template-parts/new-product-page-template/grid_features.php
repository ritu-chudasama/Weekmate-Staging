<?php
/**
 * Section: Grid Features
 * Layout: grid_features
 * Note: NEW section - has own CSS
 */

$heading                = get_sub_field('heading');
$subheading             = get_sub_field('subheading');
$grid_features_repeater = get_sub_field('grid_features_repeater');
?>

<style>
.grid-features-section {
    padding: 80px 0;
}
.grid-features-section .section-header {
    margin-bottom: 50px;
}
.grid-features-section .section-header h2 {
    font-size: 38px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 15px;
}
.grid-features-section .section-header p {
    font-size: 16px;
    color: #666;
    max-width: 700px;
    margin: 0 auto;
}
.grid-features-section .feature-grid-item {
    padding: 30px 20px;
    border-right: 1px solid #e8e8e8;
    border-bottom: 1px solid #e8e8e8;
    margin-bottom: 0;
}
.grid-features-section .feature-grid-item:nth-child(3n) {
    border-right: none;
}
.grid-features-section .feature-grid-item .feature-icon {
    margin-bottom: 15px;
}
.grid-features-section .feature-grid-item .feature-icon img {
    width: 40px;
    height: 40px;
    object-fit: contain;
}
.grid-features-section .feature-grid-item h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 10px;
}
.grid-features-section .feature-grid-item p {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
    margin: 0;
}
@media (max-width: 991px) {
    .grid-features-section .feature-grid-item:nth-child(3n) {
        border-right: 1px solid #e8e8e8;
    }
    .grid-features-section .feature-grid-item:nth-child(2n) {
        border-right: none;
    }
}
@media (max-width: 575px) {
    .grid-features-section .feature-grid-item {
        border-right: none;
    }
}
</style>

<?php if ( ! empty($grid_features_repeater) ) : ?>
<section class="grid-features-section sectionCvr">
    <div class="container">
        <div class="row section-header text-center">
            <div class="col-xxl-12">
                <?php if ( $heading ) : ?>
                <h2 class="h1 heading-bold text-none"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ( $subheading ) : ?>
                <p><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row feature-grid-wrapper">
            <?php foreach ( $grid_features_repeater as $feature ) : ?>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 feature-grid-item">
                <?php if ( ! empty($feature['icon']['url']) ) : ?>
                <div class="feature-icon">
                    <img src="<?php echo esc_url($feature['icon']['url']); ?>"
                        alt="<?php echo esc_attr($feature['icon']['alt']); ?>">
                </div>
                <?php endif; ?>
                <?php if ( $feature['title'] ) : ?>
                <h3><?php echo esc_html($feature['title']); ?></h3>
                <?php endif; ?>
                <?php if ( $feature['description'] ) : ?>
                <p><?php echo esc_html($feature['description']); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>