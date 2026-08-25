<?php get_header(); ?>

<?php
// enable_new_partner_layout is a TOP LEVEL field (not inside the group)
$enable_new_layout = !empty(get_field('enable_new_partner_layout'));
// new_partner_detail_info is the group (only has data when checkbox is checked)
$new_partner_info  = get_field('new_partner_detail_info');

$partner_details = get_field('partner_post_list_detail');
if ($partner_details) :
    $logo_section = $partner_details['logo_section'] ?? [];
    $logo1        = $logo_section['logo_1'] ?? null;
    $show_both    = !empty($logo_section['show_company_and_partner_logo']);
    $company_logo = $logo_section['company_logo'] ?? null;
    $partner_logo = $logo_section['partner_logo'] ?? null;
    $logo2        = $logo_section['logo_2'] ?? null;
    $heading      = $partner_details['heading'];
    $location     = $partner_details['location'];
    $website_url  = $partner_details['website_url'];
    $experience   = $partner_details['experience'];
    $button       = $partner_details['button'];
?>
    <!-- Partner Details Banner Section - Always Shown -->
    <section class="partner-details-banner-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 banner-wrap">
                    <div class="banner-title">
                        <h1 class="h1"><?php echo esc_html($heading ?: get_the_title()); ?></h1>
                    </div>
                    <ul class="partner-details-experience">
                        <?php if ($location) : ?>
                            <li><i class="fa-solid fa-location-dot"></i>
                                <span class="location"><?php echo esc_html($location); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($experience) : ?>
                            <li>
                                Experience :
                                <span><?php echo esc_html($experience); ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <?php if ($button) : ?>
                        <div class="btn-wrapper">
                            <a href="<?php echo esc_url($button['url']); ?>" class="btn white-btn"
                                target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 image-wrapper text-lg-end">
                    <div class="partner-logo-wrapper">
                        <?php if ($show_both) : ?>
                            <?php if ($logo1) : ?>
                                <div class="comany-logo">
                                    <img src="<?php echo esc_url($logo1['url']); ?>" alt="<?php echo esc_attr($logo1['alt']); ?>">
                                </div>
                            <?php endif; ?>
                            <div class="partner-logos-wrapper">
                                <?php if ($company_logo) : ?>
                                    <div class="comany-logo">
                                        <img src="<?php echo esc_url($company_logo['url']); ?>" alt="<?php echo esc_attr($company_logo['alt']); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if ($partner_logo) : ?>
                                    <div class="partner-logo">
                                        <img src="<?php echo esc_url($partner_logo['url']); ?>" alt="<?php echo esc_attr($partner_logo['alt']); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if ($logo2) : ?>
                                    <div class="partner-premium-logo">
                                        <img src="<?php echo esc_url($logo2['url']); ?>" alt="<?php echo esc_attr($logo2['alt']); ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else : ?>
                            <?php if ($logo1) : ?>
                                <div class="comany-logo">
                                    <img src="<?php echo esc_url($logo1['url']); ?>" alt="<?php echo esc_attr($logo1['alt']); ?>">
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php if ($enable_new_layout) : ?>
    <?php
    // ══════════════════════════════════════════
    // NEW LAYOUT — BEM methodology
    // ══════════════════════════════════════════
    $partner_detail_list     = get_field('partner_detail_list');
    $owner_name              = $new_partner_info['owner_name'] ?? '';
    $about_us_content        = $new_partner_info['about_us_content'] ?? '';
    $industries_we_serve     = $new_partner_info['industries_we_serve'] ?? [];
    $weekmate_certifications = $new_partner_info['weekmate_expertise_certifications'] ?? [];
    $business_functions      = $new_partner_info['business_functions_we_support'] ?? [];
    $integrations            = $new_partner_info['integrations_technology_expertise'] ?? [];
    $owner_image_url         = get_the_post_thumbnail_url(get_the_ID(), 'full');

    // Dynamic section titles with fallbacks
    $about_us_title             = $new_partner_info['about_us_title']             ?: 'About us';
    $industries_title           = $new_partner_info['industries_title']           ?: 'Industries we serve';
    $certifications_title       = $new_partner_info['certifications_title']       ?: 'WeekMate Expertise & Certifications';
    $business_functions_title   = $new_partner_info['business_functions_title']   ?: 'Business Functions We Support';
    $integrations_title         = $new_partner_info['integrations_title']         ?: 'Integrations & Technology Expertise';
    ?>

    <section class="partner-profile-wrapper">
        <div class="container">
            <div class="row">

                <!-- Left: Owner Card -->
                <div class="col-lg-4">
                    <div class="partner-profile__card">

                        <?php if ($owner_image_url) : ?>
                            <div class="partner-profile__image">
                                <img src="<?php echo esc_url($owner_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="partner-profile__info">

                            <?php if ($owner_name) : ?>
                                <h4 class="partner-profile__owner-name"><?php echo esc_html($owner_name); ?></h4>
                            <?php endif; ?>

                            <?php if (!empty($partner_detail_list['name'])) : ?>
                                <p class="partner-profile__company-name"><?php echo esc_html($partner_detail_list['name']); ?></p>
                            <?php endif; ?>

                            <ul class="partner-profile__links">
                                <?php if (!empty($partner_detail_list['website'])) : ?>
                                    <li class="partner-profile__links-item">
                                        <a class="partner-profile__links-anchor" href="<?php echo esc_url($partner_detail_list['website']); ?>" target="_blank" rel="noopener">
                                            <i class="fa-solid fa-globe"></i>
                                            <?php echo esc_html(parse_url($partner_detail_list['website'], PHP_URL_HOST)); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($partner_detail_list['social_link'])) :
                                    $social = $partner_detail_list['social_link']; ?>
                                    <li class="partner-profile__links-item">
                                        <a class="partner-profile__links-anchor" href="<?php echo esc_url($social['url']); ?>"
                                            target="<?php echo esc_attr($social['target'] ?: '_self'); ?>">
                                            <span class="partner-profile__social-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#0A66C2">
                                                    <path d="M20.45 20.45h-3.55v-5.57c0-1.33-.02-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.95v5.66H9.36V9h3.41v1.56h.05c.48-.9 1.66-1.85 3.42-1.85 3.66 0 4.33 2.41 4.33 5.54v6.2zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.11 20.45H3.56V9h3.55v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.72V1.72C24 .77 23.21 0 22.23 0z"/>
                                                </svg>
                                                <span>LinkedIn</span>
                                            </span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <?php if (!empty($partner_detail_list['address_1']) || !empty($partner_detail_list['address_2'])) : ?>
                                <div class="partner-profile__address">
                                    <?php if (!empty($location)) : ?>
                                        <span class="partner-profile__address-line"><?php echo esc_html($location); ?></span>
                                    <?php endif; ?>
                                    <!-- <?php if (!empty($partner_detail_list['address_1'])) : ?>
                                        <span class="partner-profile__address-line"><?php echo esc_html($partner_detail_list['address_1']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($partner_detail_list['address_2'])) : ?>
                                        <span class="partner-profile__address-line"><?php echo esc_html($partner_detail_list['address_2']); ?></span>
                                    <?php endif; ?> -->
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <!-- Right: New Content -->
                <div class="col-lg-8">
                    <div class="partner-profile__content">

                        <?php if ($about_us_content) : ?>
                            <div class="partner-profile__section partner-profile__section--about">
                                <h3 class="partner-profile__section-title"><?php echo esc_html($about_us_title); ?></h3>
                                <div class="partner-profile__section-body">
                                    <?php echo wp_kses_post($about_us_content); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($industries_we_serve)) : ?>
                            <div class="partner-profile__section partner-profile__section--industries">
                                <h3 class="partner-profile__section-title"><?php echo esc_html($industries_title); ?></h3>
                                <div class="partner-profile__tags">
                                    <?php foreach ($industries_we_serve as $industry) : ?>
                                        <?php if (!empty($industry['industry_name'])) : ?>
                                            <span class="partner-profile__tag"><?php echo esc_html($industry['industry_name']); ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($weekmate_certifications)) : ?>
                            <div class="partner-profile__section partner-profile__section--certifications">
                                <h3 class="partner-profile__section-title"><?php echo esc_html($certifications_title); ?></h3>
                                <div class="partner-profile__certifications">
                                    <?php foreach ($weekmate_certifications as $cert) : ?>
                                        <div class="partner-profile__certification-item">
                                            <?php if (!empty($cert['certification_icon'])) : ?>
                                                <div class="partner-profile__certification-icon">
                                                    <img src="<?php echo esc_url($cert['certification_icon']['url']); ?>"
                                                        alt="<?php echo esc_attr($cert['certification_icon']['alt']); ?>">
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($cert['certification_label'])) : ?>
                                                <p class="partner-profile__certification-label"><?php echo esc_html($cert['certification_label']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($business_functions)) : ?>
                            <div class="partner-profile__section partner-profile__section--functions">
                                <h3 class="partner-profile__section-title"><?php echo esc_html($business_functions_title); ?></h3>
                                <div class="partner-profile__tags">
                                    <?php foreach ($business_functions as $function) : ?>
                                        <?php if (!empty($function['function_name'])) : ?>
                                            <span class="partner-profile__tag"><?php echo esc_html($function['function_name']); ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($integrations)) : ?>
                            <div class="partner-profile__section partner-profile__section--integrations">
                                <h3 class="partner-profile__section-title"><?php echo esc_html($integrations_title); ?></h3>
                                <div class="partner-profile__tags">
                                    <?php foreach ($integrations as $integration) : ?>
                                        <?php if (!empty($integration['integration_name'])) : ?>
                                            <span class="partner-profile__tag"><?php echo esc_html($integration['integration_name']); ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>

<?php else : ?>
    <?php
    // ══════════════════════════════════════════
    // OLD LAYOUT — exactly as original
    // ══════════════════════════════════════════
    $partner_detail_list = get_field('partner_detail_list');
    if ($partner_detail_list) :
        $name         = $partner_detail_list['name'];
        $content      = $partner_detail_list['content'];
        $website      = $partner_detail_list['website'];
        $social_link  = $partner_detail_list['social_link'];
        $address1     = $partner_detail_list['address_1'];
        $address2     = $partner_detail_list['address_2'];
        $client_image = $partner_detail_list['client_image'];
    endif;
    ?>
    <section class="partner-details sectionCvr pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="partner-right-content">
                        <div class="content-wrapper">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>

<?php get_footer(); ?>