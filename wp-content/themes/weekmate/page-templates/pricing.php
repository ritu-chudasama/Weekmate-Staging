<?php
/**
 * Template Name: Pricing
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */
get_header();
$banner_section = get_field('banner_section');
$pricing = get_field('pricing_section');
//$trusted_by_our_clients_section = get_field('trusted_by_our_clients_section');
$trusted_by_our_clients_section = get_field('trusted_by_our_clients_section','option');

$product_display = get_field('product_display_section');
$featuresSec = get_field('features_section');
$testimonials_section = get_field('testimonials_section_copy','option');
$faq_section = get_field('faq_section');
$colorClasses = [
    "light-mint-bg-clr",
    "soft-peach-bg-clr",
    "light-ivory-bg-clr",
    "sky-blue-bg-clr",
    "lavender-mist-bg-clr",
    "off-white-bg-clr", "light-lavender-bg-clr"
];

// Fetch new pricing plans section
$pricing_main     = get_field('pricing_plan_');
$pricing_repeater = $pricing_main['pricing_repater'] ?? [];
$plan_slugs       = ['starter', 'growth', 'enterprise'];

// Plan colour slugs
$plan_slugs = [ 'starter', 'growth', 'enterprise' ];

$acf_tab_keys = ['HRMS & Payroll', 'e-CRM'];

?>
<section class="product-banner-section banner-section sectionCvr advtool-sec">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Left Content -->
            <div class="col-lg-5 banner-wrap ">
                <div class="banner-conetnt">
                
                <!-- Logo Repeater -->
                <?php if( !empty($banner_section['logo_repeater']) ): ?>
                <div class="banner-rating">
                    <ul class="rating-block">
                        <?php foreach( $banner_section['logo_repeater'] as $logo ): ?>
                            <li>
                                <?php if( !empty($logo['rating_logo']['url']) ): ?>
                                    <img src="<?php echo esc_url($logo['rating_logo']['url']); ?>" 
                                         alt="<?php echo esc_attr($logo['rating_logo']['alt']); ?>" 
                                         class="img-fluid" style="max-height: 30px;">
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Heading -->
                <?php if( !empty($banner_section['heading']) ): ?>
                    <h1 class="h1">
                        <?php echo esc_html($banner_section['heading']); ?>
                    </h1>
                <?php endif; ?>

                <!-- Subheading -->
                <?php if( !empty($banner_section['sub-heading']) ): ?>
                    <div class="rte">
                        <p>
                            <?php echo esc_html($banner_section['sub-heading']); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Button -->
                <?php if( !empty($banner_section['banner_button']) ): ?>
                    <div class="action-wrapper">
                    <a href="<?php echo esc_url($banner_section['banner_button']['url']); ?>" 
                       class="btn theme-btn">
                        <?php echo esc_html($banner_section['banner_button']['title']); ?>
                    </a>
                    </div>
                <?php endif; ?>
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-lg-7 pb-4 pb-lg-0">
                <?php if( !empty($banner_section['banner_image']) ): ?>
                    <img src="<?php echo esc_url($banner_section['banner_image']['url']); ?>" 
                         alt="<?php echo esc_attr($banner_section['banner_image']['alt']); ?>" 
                         class="img-fluid">
                <?php endif; ?>
                  <?php if( !empty($banner_section['banner_mobile_image']) ): ?>
                    <img src="<?php echo esc_url($banner_section['banner_image']['url']); ?>" 
                         alt="<?php echo esc_attr($banner_section['banner_image']['alt']); ?>" 
                         class="img-fluid">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php
/**
 * Section: Stats
 * Layout: stats_section
 * 
 */

$stats_repeater = get_field('stats_section', 'option');
?>

<?php /* if ( ! empty($stats_repeater) ) : ?>
<section class="stats-section one">
    <div class="container">
        <div class="stats-wrapper">
            <?php foreach ( $stats_repeater as $stat ) : ?>
            <div class="stat-item">
                <p class="stat-number"><?php echo esc_html($stat['number']); ?></p>
                <p class="stat-label"><?php echo esc_html($stat['description']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; */?>
<section class="pricing-section sectionCvr">
    <div class="pricing-page">
        <div class="container">
            <h2 class="main-title">From Startup to Enterprise</h2>

            <nav class="tabs">
                <select class="main-tabs-dropdown">
                    <option value="HRMS & Payroll">HRMS & Payroll</option>
                    <option value="TaskHub">TaskHub</option>
                    <option value="CRM">CRM</option>
                    <option value="Connect">Connect</option>
                    <option value="Assets">Assets</option>
                </select>
                <a href="#" class="tab-link active" data-key="HRMS & Payroll">HRMS &amp; Payroll</a>
                <a href="#" class="tab-link" data-key="TaskHub">TaskHub</a>
                <a href="#" class="tab-link" data-key="CRM">CRM</a>
                <a href="#" class="tab-link" data-key="Connect">Connect</a>
                <a href="#" class="tab-link" data-key="Assets">Assets</a>
            </nav>

            <!-- ── HRMS TAB CONTENT (New Pricing Plans Section) ── -->
            <?php foreach ($pricing_repeater as $index => $row):
                $tab_label   = $row['pricing_tab'] ?? '';
                $tab_plans   = $row['pricing_plans_section'] ?? [];
                $tab_pps     = $tab_plans['plans'] ?? [];
                $tab_addons  = $tab_plans['addons'] ?? [];

                if ($tab_label === 'HRMS & Payroll') {
                    $tab_class  = 'hrms-tab-content active-tab';
                    $tab_style  = '';
                } else if ($tab_label === 'e-CRM') {
                    $tab_class  = 'ecrm-tab-content';
                    $tab_style  = 'display:none;';
                } else {
                    continue; // skip any other rows
                }
            ?>
            <div class="pricing-tab-content <?php echo $tab_class; ?>" 
                data-tab="<?php echo esc_attr($tab_label); ?>"
                style="<?php echo $tab_style; ?>">

                <?php if (!empty($tab_plans['section_title'])): ?>
                <div class="pps-header">
                    <h2 class="pps-title"><?php echo esc_html($tab_plans['section_title']); ?></h2>
                    <?php if (!empty($tab_plans['section_description'])): ?>
                        <p class="pps-desc"><?php echo esc_html($tab_plans['section_description']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="pps-cards">
                    <?php foreach ($tab_pps as $pi => $plan):
                        $slug        = $plan_slugs[$pi] ?? 'plan-' . $pi;
                        $is_featured = !empty($plan['is_featured']);
                        $inc_prev    = trim($plan['includes_previous'] ?? '');
                        $btn         = $plan['plan_button'] ?? [];
                        $feat_groups = $plan['feature_groups'] ?? [];
                    ?>
                    <div class="pps-card pps-<?php echo esc_attr($slug); ?><?php echo $is_featured ? ' pps-featured' : ''; ?>">

                        <?php if ($is_featured): ?><div class="pps-badge">Most Popular</div><?php endif; ?>

                        <div class="pps-card-top">
                            <?php if (!empty($plan['plan_title'])): ?>
                                <h3 class="pps-plan-title"><?php echo esc_html($plan['plan_title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($plan['plan_description'])): ?>
                                <p class="pps-plan-desc"><?php echo esc_html($plan['plan_description']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($plan['plan_price'])):
                                $price_parts  = explode('/', $plan['plan_price']);
                                $price_num    = trim($price_parts[0]);
                                $price_period = isset($price_parts[1]) ? '/ ' . trim($price_parts[1]) : '';
                            ?>
                            <div class="pps-price-wrap">
                                <span class="pps-price">
                                    <?php
                                    if (preg_match('/^(.*?)(\(.*?\))(.*)$/', $price_num, $m)) {
                                        echo esc_html(trim($m[1]));
                                        echo '<span class="pps-price-period">' . esc_html(trim($m[2])) . '</span>';
                                        echo esc_html(trim($m[3]));
                                    } else {
                                        echo esc_html($price_num);
                                    }
                                    ?>
                                </span>
                                <?php if ($price_period): ?><span class="pps-price-period"><?php echo esc_html($price_period); ?></span><?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($plan['plan_price_note'])): ?>
                                <p class="pps-price-note"><?php echo esc_html($plan['plan_price_note']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($btn['url'])): ?>
                                <a href="<?php echo esc_url($btn['url']); ?>"
                                class="pps-btn pps-btn-<?php echo esc_attr($slug); ?>"
                                target="<?php echo esc_attr($btn['target'] ?? '_self'); ?>">
                                    <?php echo esc_html($btn['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="pps-divider"></div>

                        <div class="pps-features">
                            <?php if ($inc_prev): ?>
                                <div class="pps-includes-prev">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <?php echo esc_html($inc_prev); ?>
                                </div>
                            <?php endif; ?>
                            <?php foreach ($feat_groups as $group):
                                $features = $group['features'] ?? [];
                            ?>
                                <?php if (!empty($group['group_title'])): ?>
                                    <h4 class="pps-group-title"><?php echo esc_html($group['group_title']); ?></h4>
                                <?php endif; ?>
                                <?php if (!empty($features)): ?>
                                <ul class="pps-feature-list">
                                    <?php foreach ($features as $feat): ?>
                                        <?php if (!empty($feat['feature_name'])): ?>
                                        <li>
                                            <span class="pps-feat-icon">
                                                <svg width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M3 8L6.5 11.5L13 4.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </span>
                                            <?php echo esc_html($feat['feature_name']); ?>
                                        </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                    </div><!-- /.pps-card -->
                    <?php endforeach; ?>
                </div><!-- /.pps-cards -->

            <?php if ($tab_label === 'HRMS & Payroll'):
                    $is_hrms_section = $pricing_main['is_hrms_section_tab_'] ?? false;
                    $hrms_section    = $pricing_main['hrms_section'] ?? [];
                    if ($is_hrms_section && !empty($hrms_section)):
                        $hrms_title         = $hrms_section['hrms_title'] ?? '';
                        $hrms_repeater_rows = $hrms_section['hrms_repeater'] ?? [];
                        $is_opt_addons      = $hrms_section['is_optional_addons_tab'] ?? false;
                        $opt_addons         = $hrms_section['optionals_addons_group_tab'] ?? [];
                ?>
                <div class="hrms-services-section">
                    <?php if ($hrms_title): ?>
                        <h2 class="hrms-services-title"><?php echo esc_html($hrms_title); ?></h2>
                    <?php endif; ?>

                    <nav class="hrms-sub-tabs">
                        <select class="hrms-sub-tabs-dropdown">
                            <?php foreach ($hrms_repeater_rows as $si => $row):
                                $sub_pps    = $row['pricing_plans_section_hrms'] ?? [];
                                $sub_label  = $sub_pps['section_title'] ?? 'Tab ' . ($si + 1);
                            ?>
                                <option value="<?php echo $si; ?>"><?php echo esc_html($sub_label); ?></option>
                            <?php endforeach; ?>
                            <?php if ($is_opt_addons && !empty($opt_addons)): ?>
                                <option value="optional">Optional Add-ons</option>
                            <?php endif; ?>
                        </select>

                        <?php foreach ($hrms_repeater_rows as $si => $row):
                            $sub_pps    = $row['pricing_plans_section_hrms'] ?? [];
                            $sub_label  = $sub_pps['section_title'] ?? 'Tab ' . ($si + 1);
                        ?>
                            <button class="hrms-sub-tab-btn<?php echo $si === 0 ? ' active' : ''; ?>"
                                    data-hrms-tab="<?php echo $si; ?>"
                                    type="button">
                                <?php echo esc_html($sub_label); ?>
                            </button>
                        <?php endforeach; ?>

                        <?php if ($is_opt_addons && !empty($opt_addons)): ?>
                            <button class="hrms-sub-tab-btn hrms-sub-tab-optional"
                                    data-hrms-tab="optional"
                                    type="button">
                                Optional Add-ons
                            </button>
                        <?php endif; ?>
                    </nav>

                    <?php foreach ($hrms_repeater_rows as $si => $row):
                        $sub_pps    = $row['pricing_plans_section_hrms'] ?? [];
                        $sub_desc   = $sub_pps['section_description'] ?? '';
                        $sub_plans  = $sub_pps['plans'] ?? [];
                        $sub_addons = $sub_pps['addons'] ?? [];
                    ?>
                    <div class="hrms-sub-panel<?php echo $si === 0 ? ' active' : ''; ?>"
                         data-hrms-panel="<?php echo $si; ?>">
                        <?php if ($sub_desc): ?>
                            <p class="hrms-sub-panel-desc"><?php echo esc_html($sub_desc); ?></p>
                        <?php endif; ?>

                        <div class="pps-cards">
                            <?php foreach ($sub_plans as $pi => $plan):
                                $slug        = $plan_slugs[$pi] ?? 'plan-' . $pi;
                                $is_featured = !empty($plan['is_featured']);
                                $inc_prev    = trim($plan['includes_previous'] ?? '');
                                $btn         = $plan['plan_button'] ?? [];
                                $feat_groups = $plan['feature_groups'] ?? [];
                            ?>
                            <div class="pps-card pps-<?php echo esc_attr($slug); ?><?php echo $is_featured ? ' pps-featured' : ''; ?>">
                                <?php if ($is_featured): ?><div class="pps-badge">Most Popular</div><?php endif; ?>
                                <div class="pps-card-top">
                                    <?php if (!empty($plan['plan_title'])): ?>
                                        <h3 class="pps-plan-title"><?php echo esc_html($plan['plan_title']); ?></h3>
                                    <?php endif; ?>
                                    <?php if (!empty($plan['plan_description'])): ?>
                                        <p class="pps-plan-desc"><?php echo esc_html($plan['plan_description']); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($plan['plan_price'])):
                                        $price_parts  = explode('/', $plan['plan_price']);
                                        $price_num    = trim($price_parts[0]);
                                        $price_period = isset($price_parts[1]) ? '/ ' . trim($price_parts[1]) : '';
                                    ?>
                                    <div class="pps-price-wrap">
                                        <span class="pps-price">
                                            <?php
                                            if (preg_match('/^(.*?)(\(.*?\))(.*)$/', $price_num, $m)) {
                                                echo esc_html(trim($m[1]));
                                                echo '<span class="pps-price-period">' . esc_html(trim($m[2])) . '</span>';
                                                echo esc_html(trim($m[3]));
                                            } else {
                                                echo esc_html($price_num);
                                            }
                                            ?>
                                        </span>
                                        <?php if ($price_period): ?><span class="pps-price-period"><?php echo esc_html($price_period); ?></span><?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($plan['plan_price_note'])): ?>
                                        <p class="pps-price-note"><?php echo esc_html($plan['plan_price_note']); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($btn['url'])): ?>
                                        <a href="<?php echo esc_url($btn['url']); ?>"
                                           class="pps-btn pps-btn-<?php echo esc_attr($slug); ?>"
                                           target="<?php echo esc_attr($btn['target'] ?? '_self'); ?>">
                                            <?php echo esc_html($btn['title']); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="pps-divider"></div>
                                <div class="pps-features">
                                    <?php if ($inc_prev): ?>
                                        <div class="pps-includes-prev">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <?php echo esc_html($inc_prev); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php foreach ($feat_groups as $group):
                                        $features = $group['features'] ?? [];
                                    ?>
                                        <?php if (!empty($group['group_title'])): ?>
                                            <h4 class="pps-group-title"><?php echo esc_html($group['group_title']); ?></h4>
                                        <?php endif; ?>
                                        <?php if (!empty($features)): ?>
                                        <ul class="pps-feature-list">
                                            <?php foreach ($features as $feat): ?>
                                                <?php if (!empty($feat['feature_name'])): ?>
                                                <li>
                                                    <span class="pps-feat-icon">
                                                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M3 8L6.5 11.5L13 4.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                    <?php echo esc_html($feat['feature_name']); ?>
                                                </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                        <?php endif; ?>
                                        <?php if (!empty($group['additional_price'])): ?>
                                        <div class="pps-additional-price">
                                            <?php if (!empty($group['additional_price']['price_title'])): ?>
                                                <p class="pps-additional-price-title"><?php echo esc_html($group['additional_price']['price_title']); ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($group['additional_price']['real_price'])): ?>
                                                <p class="pps-additional-price-value"><?php echo esc_html($group['additional_price']['real_price']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (!empty($sub_addons)): ?>
                        <div class="pps-addons-wrap">
                            <div class="pps-addons-badge">
                                <span class="pps-addons-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></span>
                                Add-Ons
                            </div>
                            <div class="pps-addons-list">
                                <?php foreach ($sub_addons as $addon): ?>
                                    <?php if (!empty($addon['addon_name'])): ?>
                                    <span class="pps-addon-item">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><rect x="1" y="1" width="18" height="18" rx="4" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 10L8.5 13L14.5 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <?php echo esc_html($addon['addon_name']); ?>
                                    </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                    <?php endforeach; ?>

                    <?php if ($is_opt_addons && !empty($opt_addons)): ?>
                    <div class="hrms-sub-panel hrms-optional-panel" data-hrms-panel="optional">
                        <div class="hrms-optional-addons-table">
                            <?php foreach ($opt_addons as $oa): ?>
                                <?php if (!empty($oa['title'])): ?>
                                <div class="hrms-optional-row">
                                    <span class="hrms-opt-title"><?php echo esc_html($oa['title']); ?></span>
                                    <?php if (!empty($oa['price'])): ?>
                                        <span class="hrms-opt-price"><?php echo esc_html($oa['price']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div><!-- /.hrms-services-section -->
                <?php endif; 
            
            if (!empty($tab_addons)): ?>
                <div class="pps-addons-wrap">
                    <div class="pps-addons-badge">
                        <span class="pps-addons-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></span>
                        Add-Ons
                    </div>
                    <div class="pps-addons-list">
                        <?php foreach ($tab_addons as $addon): ?>
                            <?php if (!empty($addon['addon_name'])): ?>
                            <span class="pps-addon-item">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><rect x="1" y="1" width="18" height="18" rx="4" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 10L8.5 13L14.5 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <?php echo esc_html($addon['addon_name']); ?>
                            </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; 
            endif; ?>

            </div><!-- /.pricing-tab-content -->
            <?php endforeach; ?>

            <!-- ── OTHER TABS (JS-powered) ─────────────────── -->
            <div class="pricing-tab-content other-tabs-content" data-tab="other" style="display:none;">
                <div class="pricing-card" data-role="card">
                    <div class="pricing-feature-container">
                        <div class="pricing-plans">
                            <div class="plan">
                                <h2 class="plan-title" data-role="startup-title"></h2>
                                <div class="price" data-role="startup-price"></div>
                                <p class="plan-description" data-role="startup-description">Up to 50 Users, billed annually</p>
                                <a href="https://app.weekmate.in/" class="trial-button btn" data-role="startup-cta">Start A Free Trial</a>
                            </div>
                            <div class="divider"></div>
                            <div class="plan">
                                <h2 class="plan-title" data-role="enterprise-title"></h2>
                                <div class="price" data-role="enterprise-price"></div>
                                <p class="plan-description" data-role="enterprise-description"></p>
                                <a href="/contact-us" class="trial-button btn" data-role="enterprise-cta">Request Pricing</a>
                            </div>
                        </div>
                        <div class="features-wrapper" data-role="features-wrapper"></div>
                    </div>
                </div>
            </div><!-- /.other-tabs-content -->

        </div>
    </div>
    <?php
    $pricing_plan_card = get_field('pricing_side_card');

    $card_title = $pricing_plan_card['title'] ?? '';
    $card_call  = $pricing_plan_card['call'] ?? '';
    ?>

    <div class="card-body give-us-call-pricing">

        <?php if (!empty($card_title)) : ?>
            <h5><?php echo esc_html($card_title); ?></h5>
        <?php endif; ?>

        <?php if (!empty($card_call)) : ?>
            <a href="tel:<?php echo esc_attr($card_call); ?>">
                <?php echo esc_html($card_call); ?>
            </a>
        <?php endif; ?>

        <svg width="225" height="191" viewBox="0 0 225 191" fill="none" xmlns="http://www.w3.org/2000/svg" class="mt-24"> <g clip-path="url(#clip0_12_1110)"> <path d="M12.1264 150.907C14.3661 148.819 16.6831 146.809 19.1545 144.876C26.4143 139.154 35.9911 133.741 42.8647 127.864C46.8808 124.462 46.958 117.503 49.1205 112.786C49.3522 112.863 49.5839 113.018 49.8156 113.095V112.631C49.8156 105.053 50.2017 93.3 50.5879 83.9437C49.8156 84.4077 48.8116 84.2531 48.5026 83.1705C47.3442 78.8403 46.1857 74.4328 45.3361 70.0253C38.8486 70.2573 30.971 67.8602 33.9058 60.669C35.4504 56.8027 39.621 55.2562 44.0232 54.5603C44.1004 52.4726 44.3321 50.3075 44.7955 48.2197C45.7995 43.1163 47.8076 37.7035 51.3602 33.8373C54.295 30.667 58.62 28.8885 62.7906 30.1257C64.258 27.7286 65.9571 25.5635 68.583 24.4037C71.2089 23.2438 74.3754 23.2438 77.2329 23.9397C84.4928 25.7182 90.0535 32.3681 97.7767 32.5228C98.3173 32.5228 98.7807 32.8321 99.0124 33.296C99.2441 33.76 99.2441 34.3012 99.0124 34.7652C98.3173 35.925 97.1588 36.5436 95.8459 36.9303C96.4637 37.2396 97.1588 37.6262 97.7767 37.9355C103.569 40.9512 108.589 44.6628 113.841 48.3743C117.625 51.0807 125.194 57.4213 125.194 57.4213C119.788 58.3492 113.532 59.5091 108.589 61.0556C103.646 62.6021 98.3945 64.2259 98.3945 64.2259C98.3945 64.2259 99.0896 83.0932 99.0896 91.4443V116.188C100.016 115.956 100.48 115.879 100.557 116.111C101.252 122.374 98.8579 126.782 104.341 131.653C109.67 136.447 116.467 140.7 122.645 144.721C129.519 149.283 136.161 154.773 141.336 161.269C146.278 167.455 149.754 173.795 157.863 176.347C160.952 177.275 164.273 177.584 167.517 177.739C181.728 178.28 194.703 175.187 206.751 167.377C216.637 160.959 221.58 149.129 223.51 137.916C228.376 108.61 220.807 76.7525 208.373 50.1528C202.04 36.4663 192 26.6461 180.878 16.7485C164.891 2.59806 135.157 -0.726913 117.934 0.12366C100.711 0.974233 82.7164 0.974233 62.4816 13.1916C42.9419 24.9449 22.7071 39.018 13.5938 58.2719C4.63486 77.2165 4.86655 98.0942 6.1795 118.121C6.72012 128.792 8.18753 140.236 12.1264 150.907Z" fill="#F4F6FA"></path> <path d="M0.771484 164.168C5.79156 156.59 11.9701 150.482 19.1527 144.837C26.4125 139.115 35.9893 133.702 42.8629 127.825C46.879 124.423 46.9562 117.464 49.1187 112.747C58.4638 117 71.2071 118.778 82.174 118.778C93.141 118.778 100.478 114.835 100.632 115.84C101.328 122.103 98.9334 126.511 104.34 131.382C109.669 136.176 116.465 140.429 122.644 144.45C129.672 149.09 138.94 157.054 143.651 164.091C144.655 165.637 148.594 170.045 151.297 174.607" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M47.6504 124.888C49.6584 129.295 56.5321 137.878 61.7066 138.651C65.9544 139.27 74.8361 131.77 81.0919 123.187C82.8682 128.522 85.6485 133.161 88.1972 137.028C91.8271 142.518 97.8512 133.78 99.3958 129.604C99.2414 130.223 98.9324 130.842 98.7008 131.383" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M79.9351 131.77C78.1587 143.832 70.9762 148.085 68.4275 157.596C67.4235 161.462 66.0333 166.952 70.8217 168.499C74.2199 169.581 84.6462 163.55 80.3212 162.313C74.6833 162.313 70.0494 172.056 69.277 176.463C68.5047 180.948 69.6632 185.82 70.8989 190.227" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M99.4727 169.349C99.4727 169.349 117.699 168.808 123.337 167.262" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M118.164 163.704C120.172 167.106 120.635 175.844 120.635 175.844" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M113.066 163.55C116.078 169.658 116.619 183.19 116.619 183.19" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M53.8293 53.7483C53.7521 44.856 57.5364 34.3398 66.4953 31.3241C77.0761 27.7672 88.352 32.716 97.7743 37.7421C103.567 40.7577 108.587 44.4693 113.839 48.1809C117.623 50.8873 125.192 57.2279 125.192 57.2279C119.785 58.1558 113.53 59.3157 108.587 60.8622C103.644 62.4087 98.3922 64.0325 98.3922 64.0325C98.3922 64.0325 99.0872 82.8998 99.0872 91.2508V115.222" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M49.8906 112.592C49.8906 98.1326 51.358 68.6719 51.358 68.6719" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M79.625 47.3301L79.9339 50.9643" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M87.7344 46.8662L88.0433 50.5005" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M80.3203 66.1973C81.7105 67.6664 83.7185 68.4397 85.7266 68.3624" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M48.5005 83.0543C48.8094 84.1368 49.8134 84.2915 50.5858 83.8275C50.9719 75.3218 51.2808 68.6719 51.2808 68.6719C49.8907 69.3678 47.7282 69.8318 45.334 69.9091C46.2608 74.3166 47.4192 78.7241 48.5005 83.0543Z" fill="#333333"></path> <path d="M97.6968 32.3295C89.9736 32.2522 84.4129 25.5249 77.1531 23.7464C74.2955 23.0505 71.2063 23.0505 68.5031 24.2104C65.8 25.3702 64.1781 27.5353 62.7107 29.9324C58.6174 28.6952 54.2152 30.4737 51.2804 33.644C47.7277 37.5102 45.7197 42.923 44.7157 48.0264C44.3295 50.1142 44.0978 52.202 43.9434 54.367C46.1831 54.0577 48.3456 53.9031 50.5853 53.8258C50.8942 57.3827 51.7438 60.8623 53.6746 63.7234C54.2924 64.6512 56.146 64.7286 56.3005 63.3367C57.2273 57.46 59.3125 51.8153 62.3246 46.6346C64.3326 43.0776 66.2634 39.2887 66.0317 35.3451C70.4339 37.6649 75.5313 38.5928 80.5513 38.5155C83.9495 38.4381 87.425 38.1288 90.746 37.5102C93.3718 37.0463 97.3879 37.0463 98.9326 34.4946C99.1643 34.0306 99.1643 33.4893 98.9326 33.0254C98.7009 32.5615 98.2375 32.3295 97.6968 32.3295Z" fill="#333333"></path> <path d="M48.7256 86.2016C56.2328 86.2016 62.3185 78.5853 62.3185 69.1902C62.3185 59.795 56.2328 52.1787 48.7256 52.1787C41.2185 52.1787 35.1328 59.795 35.1328 69.1902C35.1328 78.5853 41.2185 86.2016 48.7256 86.2016Z" fill="white" stroke="#333333" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M48.7266 52.1791C48.7266 52.1791 64.173 -4.26798 88.8872 28.9817" stroke="#333333" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M62.4258 74.4023C62.4258 74.4023 68.0328 81.5626 81.1623 80.0161" stroke="#333333" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M84.6373 77.6963H81.548C80.4816 77.6963 79.6172 78.5618 79.6172 79.6294C79.6172 80.697 80.4816 81.5625 81.548 81.5625H84.6373C85.7036 81.5625 86.5681 80.697 86.5681 79.6294C86.5681 78.5618 85.7036 77.6963 84.6373 77.6963Z" fill="white" stroke="#333333" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"></path> <line x1="63.3125" y1="71.6631" x2="97.4034" y2="71.6631" stroke="white"></line> </g> <defs> <clipPath id="clip0_12_1110"> <rect width="225" height="191" fill="white"></rect> </clipPath> </defs> </svg>

    </div>
</section>

<section class="sectionCvr client-sec dark-bg">
	<div class="container">
		<div class="row">
			<div class="me-auto ms-auto">
				<div class="title-block-wrapper title-block text-center">
					<h2 class="title h1"><?php echo $trusted_by_our_clients_section['heading']; ?></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="me-auto ms-auto">
				<div class="title-block-wrapper text-center">
					<p class="desc"><?php echo $trusted_by_our_clients_section['descripation']; ?></p>
				</div>
			</div>
		</div>
		<div class="row mt-1 mt-lg-4">
			<div class="col-xxl-11 col-xl-11 col-lg-12 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="client-wrapper">
					<div id="client-slider" class="client-slider">
						<?php $clientLists = $trusted_by_our_clients_section['image_gallery']; 
						foreach($clientLists as $clientList){?>
						<div class="client-logo">
							<img src="<?php echo $clientList['url']; ?>" alt="<?php echo $clientList['alt']; ?>">
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if( $product_display ): ?>
<section class="product-display-section">
    <div class="container">
        <div class="row">
            
            <!-- Left Side (Logo, Heading, Sub-heading, Illustration) -->
            <div class="col-lg-5 col-md-12">
                <div class="product-left">
                    
                    <!-- Logo -->
                    <?php if( !empty($product_display['logo']) ): ?>
                        <div class="product-logo">
                            <img src="<?php echo esc_url($product_display['logo']['url']); ?>" 
                                 alt="<?php echo esc_attr($product_display['logo']['alt']); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <!-- Heading -->
                    <?php if( !empty($product_display['heading']) ): ?>
                        <h2 class="product-heading h1">
                            <?php echo esc_html($product_display['heading']); ?>
                        </h2>
                    <?php endif; ?>
                    
                    <!-- Sub-heading -->
                    <?php if( !empty($product_display['sub-heading']) ): ?>
                        <p class="product-subheading">
                            <?php echo esc_html($product_display['sub-heading']); ?>
                        </p>
                    <?php endif; ?>
                    
                    <!-- Illustration Image -->
                    <?php if( !empty($product_display['image']) ): ?>
                        <div class="product-image">
                            <img src="<?php echo esc_url($product_display['image']['url']); ?>" 
                                 alt="<?php echo esc_attr($product_display['image']['alt']); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Right Side (Repeater Products) -->
            <div class="col-lg-7 col-md-12">
                <div class="solution-right">
                    <div class="row">
                    <?php if( !empty($product_display['product_display']) ): ?>
                        <?php foreach( $product_display['product_display'] as $item ): ?>
                            <div class="col-md-6">
                                <div class="product-box">
                                    
                                    <!-- Product Logo -->
                                    <?php if( !empty($item['logo']) ): ?>
                                        <div class="product-icon">
                                            <img src="<?php echo esc_url($item['logo']['url']); ?>" 
                                                 alt="<?php echo esc_attr($item['logo']['alt']); ?>">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Name -->
                                    <?php if( !empty($item['name']) ): ?>
                                        <h4 class="product-name text-none">
                                            <?php echo esc_html($item['name']); ?>
                                        </h4>
                                    <?php endif; ?>
                                    
                                    <!-- Description -->
                                    <?php if( !empty($item['description']) ): ?>
                                        <p class="product-description">
                                            <?php echo esc_html($item['description']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <!-- Button -->
                                    <?php if( !empty($item['button']) ): ?>
                                        <div class="action-wrapper">
                                        <a href="<?php echo esc_url($item['button']['url']); ?>" 
                                           class="btn btn-transperent"
                                           target="<?php echo esc_attr($item['button']['target']); ?>">
                                            <?php echo esc_html($item['button']['title']); ?>
                                        </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<?php endif; ?>


<!-- <section class="sectionCvr features-sec border-bottom">
	<div class="container">
		<div class="row justify-content-between">
			<div class="me-auto ms-auto">
				<div class="title-block-wrapper text-center title-block">
					<h2 class="title h1"><?php echo $featuresSec['block_title']; ?></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
				 <div class="feature-lists-wrapper" >
					 <div class="feature-listsCvr" >
			            <ul class="feature-lists featureLists1 slick">
			            	<?php $feaLists1 =  $featuresSec['feature_sec_lists_1'];  
			            	foreach($feaLists1 as $feaList1){?>
			            	<li><img src="<?php echo $feaList1['feature_icon']['url']; ?>" alt="<?php echo $feaList1['feature_icon']['alt']; ?>"><p><?php echo $feaList1['feature_title']; ?></p></li>
			            	<?php } ?>
			            </ul>
					</div>
					<div class="feature-listsCvr" dir="rtl" >
			            <ul class="feature-lists featureLists2 slick">
			            	<?php $feaLists2 =  $featuresSec['feature_sec_lists_2']; 
			            	foreach($feaLists2 as $feaList2){?>
			            	<li><img src="<?php echo $feaList2['feature_icon']['url']; ?>" alt="<?php echo $feaList2['feature_icon']['alt']; ?>"><p><?php echo $feaList2['feature_title']; ?></p></li>
			            	<?php } ?>
			            </ul>
					</div>
					<div class="feature-logo-block">
						<?php $feaIconBlock =  $featuresSec['weekmate_icon_block']; ?>
						<div class="logo">
							<img src="<?php echo $feaIconBlock['weekmate_logo']['url']; ?>" alt="<?php echo $feaIconBlock['weekmate_logo']['alt']; ?>">
						</div>
						<div class="logo-quote">
							<p><?php echo $featuresSec['weekmate_icon_block']['bottom_text']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-lg-5 mt-2">
			<div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
				<?php $feabtmBlock =  $featuresSec['bottom_block']; ?>
				<div class="title-block-wrapper text-center title-block">
					<p class="desc"><?php echo $feabtmBlock['bb_desc']; ?></p>
				</div>
				<div class="block-cta text-center">
					<p><a href="<?php echo $feabtmBlock['bb_btn_1']['button_url']; ?>" class="theme-btn me-3"><?php echo $feabtmBlock['bb_btn_1']['button_text']; ?></a> 
				</div>
			</div>
		</div>
	</div>
</section> -->

<?php
/**
 * CTA Banner Section
 */
$cta_banner       = get_field('cta_banner');
$cta_heading      = $cta_banner['heading']          ?? '';
$cta_button       = $cta_banner['button']           ?? [];
$cta_bg_image     = $cta_banner['background_image'] ?? [];
$cta_stats        = $cta_banner['cta_stats'] ?? [];
$cta_side_image   = $cta_banner['side_image']       ?? [];
?>

<?php if (  empty($cta_banner) ) : ?>
<section class="cta-banner-section sectionCvr container"
    <?php if ( ! empty($cta_bg_image['url']) ) : ?>
        style="background-image: url('<?php echo esc_url($cta_bg_image['url']); ?>');"
    <?php endif; ?>>
    <div class="cta-banner-section-container">

        <!-- Left Image -->
        <div class="cta-banner-section-container-image">
            <?php if ( ! empty($cta_side_image['url']) ) : ?>
            <div class="cta-left-image">
                <img src="<?php echo esc_url($cta_side_image['url']); ?>"
                     alt="<?php echo esc_attr($cta_side_image['alt']); ?>">
            </div>
            <?php endif; ?>
        </div>

        <!-- Right Content -->
        <div class="cta-banner-section-container-content">
            <div class="cta-content">

                <?php if ( $cta_heading ) : ?>
                <h2 class="text-none"><?php echo esc_html($cta_heading); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty($cta_stats) ) : ?>
                <ul class="cta-checklist">
                    <?php foreach ( $cta_stats as $stat ) : ?>
                    <li>
                        <span class="check-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <path d="M10.8333 0C4.86417 0 0 4.86417 0 10.8333C0 16.8025 4.86417 21.6667 10.8333 21.6667C16.8025 21.6667 21.6667 16.8025 21.6667 10.8333C21.6667 4.86417 16.8025 0 10.8333 0ZM16.0117 8.34167L9.86917 14.4842C9.7175 14.6358 9.51167 14.7225 9.295 14.7225C9.07833 14.7225 8.8725 14.6358 8.72083 14.4842L5.655 11.4183C5.34083 11.1042 5.34083 10.5842 5.655 10.27C5.96917 9.95583 6.48917 9.95583 6.80333 10.27L9.295 12.7617L14.8633 7.19333C15.1775 6.87917 15.6975 6.87917 16.0117 7.19333C16.3258 7.5075 16.3258 8.01667 16.0117 8.34167Z" fill="white"/>
                            </svg>
                        </span>
                        <?php echo esc_html($stat['label']); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <?php if ( ! empty($cta_button['url']) ) : ?>
                <div class="cta-btn-wrap">
                    <a href="<?php echo esc_url($cta_button['url']); ?>"
                       class="btn"
                       target="<?php echo esc_attr($cta_button['target'] ?: '_self'); ?>">
                        <?php echo esc_html($cta_button['title']); ?>
                    </a>
                </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</section>
<?php endif; ?>

<section class="sectionCvr testimonials-sec testimonials">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
				<div class="title-block-wrapper text-center title-block">
					<h2 class="title h1"><?php echo $testimonials_section['heading']; ?></h2>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid g-0">
		<div class="row">
			<div class="col-xxl-11 col-xl-12 col-lg-12 col-md-12 col-sm-12 ms-auto">
				<div class="testimonials-wrapper">
					<div id="testimonials-slider" class="testimonials-slider">
						<?php $testiLists =  $testimonials_section['testimonials_repeater'];
                        $testi = 0;
                        foreach($testiLists as $testiList){
                            $testirandomClass = $colorClasses[$testi % count($colorClasses)];  ?>
                            <div class="testimonials-item">
                                <div class="testimonials-block <?php echo esc_attr($testirandomClass); ?>">
                                    <div class="testi-img-play">
                                        <p class="testi-img">
                                            <?php if(!empty($testiList['client_image'])){ ?>
                                            <img src="<?php echo $testiList['client_image']['url']; ?>" alt="<?php echo $testiList['client_image']['alt']; ?>">
                                            <?php } else { ?>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/test-img-avatar.png" alt="testimonial">
                                            <?php } ?>
                                        </p>
                                        <?php /* 
                                        <p class="play-btn">
                                            <a href="#"><i class="fa fa-play"></i>Play</a>
                                        </p> */ ?>
                                    </div>
                                    <div class="testi-content">
                                        <p><?php echo $testiList['content']; ?></p>
                                    </div>
                                    <div class="testi-author">
                                        <p class="author"><?php echo $testiList['client_name']; ?></p>
                                        <p class="desig"><?php echo $testiList['designation']; ?></p>
                                    </div>
                                </div>
                            </div>
						    <?php $testi++; 
                        } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="sectionCvr faq-section pt-0">
	<div class="container">
		<div class="row">
			<div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="row justify-content-between align-items-center">
					<div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9 col-sm-12">
						<div class="title-block-wrapper title-block pb-0 mb-0">
							<h2 class="title h1"><?php echo $faq_section['heading']; ?></h2>
						</div>
					</div>
					<div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-12">
						<div class="block-cta">
							<p class="mb-0"><a href="<?php echo $faq_section['button']['url']; ?>" class="theme-btn mt-0"><?php echo $faq_section['button']['title']; ?></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="faq-qa-wrapper">
					<div class="row">
                        <div class="combined" id="faqMain">
						<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="accordion accordion-flush faqs-accordion">
								<?php $faq1Lists = $faq_section['faq_repeater']; 
								$faq1 = 0;
								foreach($faq1Lists as $faq1List) { $faq1++;  ?>
                                    <div class="accordion-item">
                                        <h3 class="accordion-header">
                                            <button class="accordion-button <?php if($faq1 != 1 ){ echo 'collapsed'; } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faqcollapse-<?php echo $faq1; ?>" aria-expanded="true" aria-controls="faq1collapse-<?php echo $faq1; ?>"><?php echo $faq1List['title']; ?></button>
                                        </h3>
                                        <div id="faqcollapse-<?php echo $faq1; ?>" class="accordion-collapse collapse <?php if($faq1 == 1 ){ echo "show"; } ?>" data-bs-parent="#faqMain">
                                            <div class="accordion-body">
                                                <?php echo $faq1List['content']; ?>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>
							</div>
						</div>
						<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="accordion accordion-flush faqs-accordion">
								<?php $faq2Lists = $faq_section['faq_repeater_2']; 
								$faq2 = 0;
								foreach($faq2Lists as $faq2List) { $faq2++;  ?>
                                    <div class="accordion-item">
                                        <h3 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1collapse-<?php echo $faq2; ?>" aria-expanded="<?php if($faq2 == 1 ){ echo 'true'; } else { echo "false"; } ?>" aria-controls="faqcollapse-<?php echo $faq2; ?>"><?php echo $faq2List['title']; ?></button>
                                        </h3>
                                        <div id="faq1collapse-<?php echo $faq2; ?>" class="accordion-collapse collapse" data-bs-parent="#faqMain">
                                            <div class="accordion-body">
                                                <?php echo $faq2List['content']; ?>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>
							</div>
						</div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();