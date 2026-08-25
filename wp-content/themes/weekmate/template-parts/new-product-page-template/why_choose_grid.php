<?php
/**
 * Section: Why Choose Grid
 * Layout: why_choose_grid
 */

$sub_title   = get_sub_field('sub_title');
$title       = get_sub_field('title');
$description = get_sub_field('description');
$features    = get_sub_field('features');
?>

<section class="why-choose-sec sectionCvr">
    <div class="container">

        <div class="row justify-content-center text-center">
            <div class="col-lg-7">

                <?php if (!empty($sub_title)) : ?>
                    <span class="wc-subtitle"><?php echo esc_html($sub_title); ?></span>
                <?php endif; ?>

                <?php if (!empty($title)) : ?>
                    <h2 class="wc-title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if (!empty($description)) : ?>
                    <p class="wc-desc"><?php echo esc_html($description); ?></p>
                <?php endif; ?>

            </div>
        </div>

        <?php if (!empty($features)) : ?>
            <div class="row wc-features-wrapper">
                <?php foreach ($features as $feature) : ?>
                    <div class="col-lg-3 col-md-6 wc-feature-col">
                        <div class="wc-feature-card">

                            <?php if (!empty($feature['icon']['url'])) : ?>
                                <div class="wc-feature-icon">
                                    <img src="<?php echo esc_url($feature['icon']['url']); ?>" alt="<?php echo esc_attr($feature['icon']['alt']); ?>">
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($feature['title'])) : ?>
                                <h4 class="wc-feature-title"><?php echo esc_html($feature['title']); ?></h4>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
<style>
    .why-choose-sec {
    padding: 80px 0;
    background-color: #fff;
}

.wc-subtitle {
    display: inline-block;
    font-family: Manrope, sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #004872;
    margin-bottom: 16px;
}

.wc-title {
    font-family: Manrope, sans-serif;
    font-size: 42px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
    margin-bottom: 16px;
}

.wc-desc {
    font-family: Manrope, sans-serif;
    font-size: 16px;
    color: #4a4a4a;
    line-height: 1.75;
    margin-bottom: 50px;
}

.wc-features-wrapper {
    row-gap: 20px;
    margin-top: 35px;
}

.wc-feature-col {
    padding: 8px;
}

.wc-feature-card {
    padding: 32px 24px;
    border: 1.5px solid #E9F2FB;
    border-radius: 16px;
    background-color: #fff;
    height: 100%;
    transition: box-shadow 0.2s ease;
}

.wc-feature-card:hover {
    box-shadow: 0 6px 24px rgba(0, 71, 114, 0.08);
}

.wc-feature-icon {
    width: 48px;
    height: 48px;
    margin-bottom: 20px;
}

.wc-feature-icon img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.wc-feature-title {
    font-family: Manrope, sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.4;
    margin: 0;
}

@media (max-width: 991px) {
    .why-choose-sec { padding: 60px 0; }
    .wc-title { font-size: 30px; }
}

@media (max-width: 575px) {
    .wc-title { font-size: 24px; }
}
</style>