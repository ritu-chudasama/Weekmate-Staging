<?php
/**
 * Section: Workflow Visibility
 * Layout: workflow_visibility
 */

$bg_image    = get_sub_field('background_image');
$sub_title   = get_sub_field('sub_title');
$title       = get_sub_field('title');
$description = get_sub_field('description');
$steps       = get_sub_field('steps');

$bg_url = !empty($bg_image['url']) ? esc_url($bg_image['url']) : '';
?>

<section class="workflow-sec sectionCvr" <?php if ($bg_url) : ?>style="background-image: url('<?php echo $bg_url; ?>');"<?php endif; ?>>
    <div class="container">

        <div class="row justify-content-center text-center">
            <div class="col-lg-7">

                <?php if (!empty($sub_title)) : ?>
                    <span class="workflow-subtitle"><?php echo esc_html($sub_title); ?></span>
                <?php endif; ?>

                <?php if (!empty($title)) : ?>
                    <h2 class="workflow-title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if (!empty($description)) : ?>
                    <p class="workflow-desc"><?php echo esc_html($description); ?></p>
                <?php endif; ?>

            </div>
        </div>

        <?php if (!empty($steps)) : ?>
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="workflow-steps-wrapper">
                        <?php foreach ($steps as $index => $step) : ?>

                            <div class="workflow-step">
                                <?php if (!empty($step['icon']['url'])) : ?>
                                    <div class="workflow-step__icon">
                                        <img src="<?php echo esc_url($step['icon']['url']); ?>" alt="<?php echo esc_attr($step['icon']['alt']); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($step['label'])) : ?>
                                    <span class="workflow-step__label"><?php echo esc_html($step['label']); ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if ($index < count($steps) - 1) : ?>
                                <div class="workflow-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="23" viewBox="0 0 42 23" fill="none">
                                        <path d="M40.46 7.36015L33.6875 0.517647C33.5248 0.353622 33.3313 0.223432 33.118 0.134587C32.9048 0.0457415 32.676 0 32.445 0C32.214 0 31.9852 0.0457415 31.772 0.134587C31.5587 0.223432 31.3652 0.353622 31.2025 0.517647C30.8766 0.845531 30.6936 1.28907 30.6936 1.7514C30.6936 2.21372 30.8766 2.65726 31.2025 2.98515L37.4325 9.26765H1.75C1.28587 9.26765 0.840752 9.45202 0.512563 9.78021C0.184374 10.1084 0 10.5535 0 11.0176C0 11.4818 0.184374 11.9269 0.512563 12.2551C0.840752 12.5833 1.28587 12.7676 1.75 12.7676H37.5375L31.2025 19.0851C31.0385 19.2478 30.9083 19.4414 30.8194 19.6546C30.7306 19.8679 30.6849 20.0966 30.6849 20.3276C30.6849 20.5587 30.7306 20.7874 30.8194 21.0007C30.9083 21.2139 31.0385 21.4075 31.2025 21.5702C31.3652 21.7342 31.5587 21.8644 31.772 21.9532C31.9852 22.0421 32.214 22.0878 32.445 22.0878C32.676 22.0878 32.9048 22.0421 33.118 21.9532C33.3313 21.8644 33.5248 21.7342 33.6875 21.5702L40.46 14.7801C41.4432 13.7958 41.9954 12.4614 41.9954 11.0701C41.9954 9.67889 41.4432 8.34452 40.46 7.36015Z" fill="#0090E4"/>
                                    </svg>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
<style>
    /* ===========================
   WORKFLOW VISIBILITY SECTION
=========================== */
.workflow-sec {
    padding: 100px 0;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    text-align: center;
}

.workflow-subtitle {
    font-family: Manrope;
    font-weight: 600;
    font-style: SemiBold;
    font-size: 16px;
    leading-trim: NONE;
    line-height: 100%;
    letter-spacing: 10%;
    text-align: center;
    text-transform: uppercase;
    color: #fff;
}

.workflow-title {
    font-family: Manrope;
    font-weight: 800;
    font-style: ExtraBold;
    font-size: 54px;
    leading-trim: NONE;
    line-height: 100%;
    letter-spacing: 0%;
    text-align: center;
    text-transform: capitalize;
    color: #fff;
    margin: 20px 0;
}

.workflow-desc {
    font-family: Manrope;
    font-weight: 400;
    font-style: Regular;
    font-size: 18px;
    leading-trim: NONE;
    line-height: 28px;
    letter-spacing: 1%;
    text-align: center;
    color: #fff;
    margin-bottom: 50px;
}

/* Steps bar */
.workflow-steps-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background:#116292;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 16px;
    padding: 32px 40px;
    gap: 10px;
    margin: 50px 0 0;
}

.workflow-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
    flex: 1;
}

.workflow-step__icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.workflow-step__icon img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.workflow-step__label {
    font-family: Manrope;
    font-weight: 800;
    font-style: ExtraBold;
    font-size: 15px;
    leading-trim: NONE;
    line-height: 100%;
    letter-spacing: 2%;
    text-transform: capitalize;
    color: #fff;
}

.workflow-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.6;
    flex-shrink: 0;
}

/* Responsive */
@media (max-width: 991px) {
    .workflow-title {
        font-size: 32px;
    }

    .workflow-steps-wrapper {
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 24px 20px;
    }

    .workflow-arrow {
        display: none;
    }

    .workflow-step {
        flex: 0 0 calc(33.33% - 20px);
    }
}

@media (max-width: 575px) {
    .workflow-title {
        font-size: 26px;
    }

    .workflow-step {
        flex: 0 0 calc(50% - 20px);
    }
}
</style>