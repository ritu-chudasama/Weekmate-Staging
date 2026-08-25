<?php
/**
 * Section: Integrations
 * Layout: integrations
 */

$sub_title         = get_sub_field('sub_title');
$title             = get_sub_field('title');
$description       = get_sub_field('description');
$tools             = get_sub_field('tools');
$integration_tools = get_sub_field('integration_tools');
?>

<section class="integrations-sec sectionCvr">
    <div class="container">
        <div class="row justify-content-between align-items-center">

            <div class="col-lg-6 content-col">
                <?php if (!empty($sub_title)) : ?>
                    <span class="section-subtitle"><?php echo esc_html($sub_title); ?></span>
                <?php endif; ?>

                <?php if (!empty($title)) : ?>
                    <h2 class="section-title heading-bold"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if (!empty($description)) : ?>
                    <div class="section-description">
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($tools)) : ?>
                    <ul class="integration-features-list">
                        <?php foreach ($tools as $tool) : ?>
                            <?php if (!empty($tool['text'])) : ?>
                                <li><?php echo esc_html($tool['text']); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="col-lg-6">
                <?php if (!empty($integration_tools)) : ?>
                    <div class="row integration-tools-wrapper">
                        <?php foreach ($integration_tools as $item) : ?>
                            <div class="col-5 integration-tools-container">
                                <div class="integration-tool-card">
                                    <?php if (!empty($item['image']['url'])) : ?>
                                        <div class="tool-icon">
                                            <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['image']['alt']); ?>" class="img-fluid">
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($item['title'])) : ?>
                                        <h4 class="tool-title"><?php echo esc_html($item['title']); ?></h4>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
<style>
    /* ===========================
   INTEGRATIONS SECTION
=========================== */
.integrations-sec {
    padding: 80px 0;
    background-color: #fff;
}

.integrations-sec .content-col {
    text-align: left;
    padding-right: 60px;
}

.integrations-sec .section-subtitle {
    font-family: Manrope;
    font-weight: 600;
    font-style: SemiBold;
    font-size: 16px;
    leading-trim: NONE;
    line-height: 100%;
    letter-spacing: 10%;
    color: #004872;
    text-transform: uppercase;
}

.integrations-sec .section-title {
    font-family: Manrope;
font-weight: 800;
font-style: ExtraBold;
font-size: 48px;
leading-trim: NONE;
line-height: 100%;
letter-spacing: 0%;
text-transform: capitalize;
    margin: 30px 0 20px;
}

.integrations-sec .section-description p {
    font-family: Manrope;
font-weight: 400;
font-style: Regular;
font-size: 18px;
leading-trim: NONE;
line-height: 28px;
letter-spacing: 1%;
color: #4A4A4A;
margin: 0 0 30px 0;
}

/* Tags */
.integration-features-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.integration-features-list li {
    display: inline-block;
    padding: 10px 14px;
    border-radius: 20px;
    background: #E9F2FB;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #004872;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
    font-family: Manrope;
    font-weight: 700;
    font-style: Bold;
    font-size: 14px;
    leading-trim: NONE;
    line-height: 100%;
    letter-spacing: 4%;
    text-transform: uppercase;
}

.integration-features-list li:hover {
    background-color: #2563eb;
    color: #fff;
}

/* Cards wrapper — outer border */
.integration-tools-wrapper {
    margin: 0;
    gap: 20px;
    justify-content: flex-end;
}

.integration-tools-wrapper .integration-tools-container {
    padding: 0;
}

.integration-tools-wrapper .integration-tools-container:nth-child(2), .integration-tools-wrapper .integration-tools-container:nth-child(4) {
    margin: 30px 0 -30px 0;
}

/* Each card */
.integration-tool-card {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    padding: 35px 30px;
    border: 2px solid #E9F2FB;
    background-color: #fff;
    text-align: left;
    height: 100%;
    transition: box-shadow 0.2s ease;
    border-radius: 20px;
}

.integration-tool-card:hover {
    box-shadow: inset 0 0 0 2px #004872;
}

.integration-tool-card .tool-icon {
    width: 48px;
    height: 48px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.integration-tool-card .tool-icon img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.integration-tool-card .tool-title {
    font-family: Manrope;
    font-weight: 700;
    font-style: Bold;
    font-size: 20px;
    leading-trim: NONE;
    line-height: 100%;
    letter-spacing: 4%;
    text-transform: capitalize;
    color: #004872;
}

/* Responsive */
@media (max-width: 991px) {
    .integration-features-list li {
        font-size: 12px;
    }
.integrations-sec .section-description p {
    font-size: 16px;
}
    .integration-tools-wrapper .integration-tools-container:nth-child(2), .integration-tools-wrapper .integration-tools-container:nth-child(4) {
        margin: 0;
    }
.integrations-sec .section-title {
    font-size: 32px;
}
    .integration-tools-wrapper {
        justify-content: center;
    }

    .integrations-sec .content-col {
        padding-right: 0;
        margin-bottom: 40px;
        text-align: center;
    }

    .integration-features-list {
        justify-content: center;
    }
}

@media (max-width: 575px) {
    .integrations-sec .section-title {
        font-size: 24px;
    }

    .integration-features-list {
        justify-content: center;
    }
}
</style>