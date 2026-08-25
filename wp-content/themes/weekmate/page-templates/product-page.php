<?php
/**
 * Template Name: Product Page
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */
$banner_section = get_field('banner_section');
$trusted_to_lead = get_field('trusted_to_lead');
$setup_process = get_field('setup_process');
$features_section = get_field('features_section');
$why_to_choose_accordion = get_field('why_to_choose_accordion');
$collaboration_tool_section = get_field('collaboration_tool_section');
$implementation_steps = get_field('implementation_steps');
$trusted_by_our_clients_section_old = get_field('trusted_by_our_clients_section',);
$trusted_by_our_clients_section = get_field('trusted_by_our_clients_section','option');
$trusted_by_our_clients_3_section = get_field('trusted_by_our_clients_3_section','option');
// $videoSec = $trusted_by_our_clients_section_old['section_1'];
// $prdctCountSec = $trusted_by_our_clients_section_old['section_2'];
//$comPriceSec = $trusted_by_our_clients_section_old['section_3'];

$videoSec = $trusted_by_our_clients_3_section['section_1'];
$prdctCountSec = $trusted_by_our_clients_3_section['section_2'];
$comPriceSec = $trusted_by_our_clients_3_section['section_3'];
$our_core_value = get_field('our_core_value','option');
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
// echo "<pre>";
// print_r($why_to_choose_accordion);
// echo "</pre>";
// exit;
get_header();
?>
<section class="product-banner-section sectionCvr">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="banner-conetnt">
                    <div class="product-badges">
                        <img src="<?php echo esc_url($banner_section['logo']['url']); ?>"
                            alt="<?php echo esc_attr($banner_section['logo']['name']); ?>" class="img-fluid">
                    </div>
                    <h1 class="banner-title text-none"><?php echo esc_html($banner_section['heading']); ?></h1>
                    <p class="banner-subtitle"><?php echo esc_html($banner_section['description']); ?></p>
                    <a href="<?php echo esc_url($banner_section['button']['url']); ?>"
                        class="btn theme-btn" target="_blank" rel="noopener noreferrer"><?php echo esc_html($banner_section['button']['title']); ?></a>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                <img src="<?php echo esc_url($banner_section['section_image']['url']); ?>"
                    alt="<?php echo esc_attr($banner_section['section_image']['name']); ?>" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<section class="certificate-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="certificate-wrapper">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <div class="certificate-title">
                                <img src="<?php echo $trusted_to_lead['logo']['url']; ?>"
                                    alt="<?php echo $trusted_to_lead['logo']['alt']; ?>">
                                <p><?php echo $trusted_to_lead['tagline']; ?></p>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12">
                            <span class="seprator"><img
                                    src="<?php echo get_template_directory_uri(); ?>/images/sperator-line.png"
                                    alt="seprator"></span>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="certificate-lists">
                                <ul class="certificates">
                                    <?php $certiLists =  $trusted_to_lead['images']; 
                                    if(!empty($trusted_to_lead['images'])) {
                                        foreach($certiLists as $certiList){ 
                                            ?>
                                    <li><img src="<?php echo $certiList['url']; ?>"
                                            alt="<?php echo $certiList['alt']; ?>"></li>
                                    <?php 
                                        }
                                    }
                                    else {
                                        echo '<p>No images available.</p>';

                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="setup-process sectionCvr">
    <div class="container">
        <div class="small-section-header text-center section-header">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <?php
                        if(!empty($setup_process['heading'])) {
                            echo '<h2 class="setup-process-title h1 heading-bold text-none">' . esc_html($setup_process['heading']) . '</h2>';
                        }
                    ?>
                    <div class="rich-text">
                        <p><?php echo esc_html($setup_process['subheading']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                if(!empty($setup_process['setup_process_repeater'])) {
                    foreach($setup_process['setup_process_repeater'] as $process) {
                        echo '<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 process-item">';
                        echo '<div class="process-item-inner">';
                        echo '<h3 class="heading-bold">' . esc_html($process['title']) . '</h3>';
                        echo '<div class="rte">';
                        echo '<p>' . esc_html($process['description']) . '</p>';
                        echo '</div>';
                        echo '<img src="' . esc_url($process['image']['url']) . '" alt="' . esc_attr($process['image']['name']) . '" class="img-fluid">';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </div>
</section>

<!-- Mira Ai Video -->
<?php
// Show only on HRMS page (use slug or ID)
if ( is_page('hrms-payroll-software0') ) :

    $mira_ai_title   = get_field('mira_ai_title');
    $mira_ai_content = get_field('mira_ai_content');
    $mira_ai_video   = get_field('mira_ai_video');
    $mira_ai_button   = get_field('mira_ai_button');

    if ( $mira_ai_title || $mira_ai_content || $mira_ai_video ) :
?>
<section class="mira-ai-section sectionCvr">
    <div class="container">
        <div class="row align-items-center">

            <!-- LEFT CONTENT -->
            <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="mira-ai-content">

                    <?php if ( $mira_ai_title ) : ?>
                        <h2 class="heading-bold">
                            <?php echo esc_html( $mira_ai_title ); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ( $mira_ai_content ) : ?>
                        <p>
                            <?php echo esc_html( $mira_ai_content ); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( $mira_ai_button ) : ?>
                        <a 
                            href="<?php echo esc_url( $mira_ai_button['url'] ); ?>"
                            class="theme-btn button"
                            target="<?php echo esc_attr( $mira_ai_button['target'] ?: '_self' ); ?>"
                        >
                            <?php echo esc_html( $mira_ai_button['title'] ); ?>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
            
            
            <!-- RIGHT VIDEO -->
            <div class="col-xxl-7 col-xl-7 col-lg-6 col-md-12 col-sm-12">
                <div class="mira-ai-video">
                     <?php if ( ! empty( $mira_ai_video['url'] ) ) : ?>
                        <video
                            autoplay
                            muted
                            loop
                            playsinline
                            controls
                            preload="auto"
                            style="width:100%; height:auto;"
                            class="video"
                        >
                            <source src="<?php echo esc_url( $mira_ai_video['url'] ); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</section>
<?php
    endif;
endif;
?>

<?php $features_section = get_field('features_section'); ?>
<section class="features-section product-features-seaction features-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center section-header small-section-header overlap-hide">
                    <?php
                        if(!empty($features_section['heading'])) {
                            echo '<h2 class="features-section-title h1 heading-bold">' . esc_html($features_section['heading']) . '</h2>';
                        }
                    ?>
                    <div class="small-rich-text overlap-hide">
                        <p><?php echo esc_html($features_section['subheading']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php $featuresSecnew = get_field('features_section_new'); ?>
        <?php 
        if ( 
        !empty($featuresSecnew['feature_lists_1']) || 
        !empty($featuresSecnew['feature_sec_lists_2']) || 
        !empty($featuresSecnew['weekmate_icon_block']['weekmate_logo']['url']) 
            ) : ?>
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="feature-lists-wrapper">
                    <?php if ( !empty($featuresSecnew['feature_lists_1']) ) :?>
                    <div class="feature-listsCvr">
                        <ul class="feature-lists featureLists1 slick">
                            <?php foreach ( $featuresSecnew['feature_lists_1'] as $feaList1 ) : ?>
                                  <?php 
                                // Convert icon ID → array if needed
                                if ( !empty($feaList1['icon']) && !is_array($feaList1['icon']) ) {
                                    $feaList1['icon'] = wp_prepare_attachment_for_js($feaList1['icon']);
                                }
                                ?>
                            <li>
                                <?php if ( !empty($feaList1['icon']['url']) ) : ?>
                                <img src="<?php echo esc_url($feaList1['icon']['url']); ?>"
                                    alt="<?php echo esc_attr($feaList1['icon']['alt']); ?>">
                                <?php endif; ?>
                                <?php if ( !empty($feaList1['title']) ) : ?>
                                <p><?php echo esc_html($feaList1['title']); ?></p>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if ( !empty($featuresSecnew['feature_sec_lists_2']) ) : ?>
                    <div class="feature-listsCvr" dir="rtl">
                        <ul class="feature-lists featureLists2 slick">
                            <?php foreach ( $featuresSecnew['feature_sec_lists_2'] as $feaList2 ) : ?>
                            <li>
                                <?php if ( !empty($feaList2['icon']['url']) ) : ?>
                                <img src="<?php echo esc_url($feaList2['icon']['url']); ?>"
                                    alt="<?php echo esc_attr($feaList2['icon']['alt']); ?>">
                                <?php endif; ?>
                                <?php if ( !empty($feaList2['title']) ) : ?>
                                <p><?php echo esc_html($feaList2['title']); ?></p>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if ( !empty($featuresSecnew['weekmate_icon_block']['weekmate_logo']['url']) ) : ?>
                    <div class="feature-logo-block">
                        <div class="logo">
                            <img src="<?php echo esc_url($featuresSecnew['weekmate_icon_block']['weekmate_logo']['url']); ?>"
                                alt="<?php echo esc_attr($featuresSecnew['weekmate_icon_block']['weekmate_logo']['alt']); ?>">
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<section class="why-to-choose-accordion-sec sectionCvr">
    <div class="container">
        <div class="row section-header align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <?php
                    if(!empty($why_to_choose_accordion['heading'])) {
                        echo '<h2 class="setup-process-title h1 heading-bold text-none">' . esc_html($why_to_choose_accordion['heading']) . '</h2>';
                    }
                    if(!empty($why_to_choose_accordion['subheading'])) {
                        ?><p><?php echo esc_html($why_to_choose_accordion['subheading']); ?></p><?php
                    }
                ?>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 text-md-end">
                <?php
                    if(!empty($why_to_choose_accordion['button'])) {
                        ?><a href="<?php echo esc_url($why_to_choose_accordion['button']['url']); ?>"
                    class="btn theme-btn mt-0"><?php echo esc_html($why_to_choose_accordion['button']['title']); ?></a><?php
                    }
                ?>
            </div>
        </div>
        <div class="row why-to-choose-accordion">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="accordion-selector">
                    <?php
                        if(!empty($why_to_choose_accordion['why_to_choose_repeater'])) {
                            foreach($why_to_choose_accordion['why_to_choose_repeater'] as $key => $accordion) {
                                $active_class = '';
                                if($key == 0){
                                    $active_class = 'active';
                                }
                                echo '<div  class="'.$active_class.' accordion-item" data-target="accordion_content_'.$key.'">';
                                echo '<span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 52 52" fill="none"><circle cx="27" cy="27" r="21" fill="white"></circle><path d="M23.1839 36.545C23.6078 36.545 24.0316 36.3888 24.3663 36.0542L32.2413 28.1791C32.8883 27.5322 32.8883 26.4614 32.2413 25.8144L24.3663 17.9393C23.7193 17.2924 22.6485 17.2924 22.0015 17.9393C21.3546 18.5863 21.3546 19.6571 22.0015 20.3041L28.6942 26.9968L22.0015 33.6895C21.3546 34.3364 21.3546 35.4073 22.0015 36.0542C22.3138 36.3888 22.7377 36.545 23.1839 36.545Z" fill="#005282"></path></svg> </span>';
                                echo '<h3 class="accordion-header">' . esc_html($accordion['title']) . '</h3>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                <div class="accordion-body">
                    <?php
                            if(!empty($why_to_choose_accordion['why_to_choose_repeater'])) {
                                foreach($why_to_choose_accordion['why_to_choose_repeater'] as $key => $accordion) {
                                    $hide_content = '';
                                    if($key !== 0){
                                        $hide_content = 'display:none;';
                                    }
                                    echo '<div class="accordion-item-content"  id="accordion_content_'.$key.'" style="'.$hide_content.'">';
                                    echo '<h3 class="accordion-header heading-bold">' . esc_html($accordion['title']) . '</h3>';
                                    echo '<div class="rich-text">';
                                    echo '<p>' . esc_html($accordion['description']) . '</p>';
                                    echo '</div>';
                                    echo '<img src="' . esc_url($accordion['image']['url']) . '" alt="' . esc_attr($accordion['image']['name']) . '" class="img-fluid">';
                                    echo '</div>';
                                }
                            }
                        ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="collaboration-tool-section-sec sectionCvr">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 section-header">
                <div class="small-section-header text-center">
                    <?php
                    if(!empty($collaboration_tool_section['heading'])) {
                        echo '<h2 class="why-to-choose-section-title heading-bold h1 text-none">' . esc_html($collaboration_tool_section['heading']) . '</h2>';
                    }
                ?>
                    <p><?php echo esc_html($collaboration_tool_section['subheading']); ?></p>
                </div>
            </div>
        </div>
        <div class="row collaboration-tool-section-scroll">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 collaboration-tool-top-header">
                <div class="collaboration-tool-selector">
                    <?php
                        if(!empty($collaboration_tool_section['collaboration_tool_repeater'])) {
                            foreach($collaboration_tool_section['collaboration_tool_repeater'] as $key => $data) {
                                $active_class = '';
                                if($key == 0){
                                    $active_class = 'active';
                                }
                                echo '<div class="'.$active_class.' tool-item" data-target="tool_item_content_'.$key.'">';
                                echo '<h3 class="tool-header">' . esc_html($data['title']) . '</h3>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
                <?php if ( ! empty( $collaboration_tool_section['button']['url'] ) && ! empty( $collaboration_tool_section['button']['title'] ) ) : ?>
                <a href="<?php echo esc_url( $collaboration_tool_section['button']['url'] ); ?>" class="btn theme-btn">
                    <?php echo esc_html( $collaboration_tool_section['button']['title'] ); ?>
                </a>
                <?php endif; ?>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="collaboration-tool-body">
                    <?php
                            if(!empty($collaboration_tool_section['collaboration_tool_repeater'])) {
                                foreach($collaboration_tool_section['collaboration_tool_repeater'] as $key => $data) {
                                    $hide_content = '';
                                    if($key !== 0){
                                        $hide_content = 'display:none;';
                                    }
                                    echo '<div class="tool-item-content" id="tool_item_content_'.$key.'" style="'.$hide_content.'">';
                                    echo '<h3 class="collaboration-tool-header heading-bold">' . esc_html($data['title']) . '</h3>';
                                    echo '<p>' . esc_html($data['description']) . '</p>';
                                    echo '</div>';
                                }
                            }
                        ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="setup-process-section sectionCvr">
    <div class="container">
        <div class="row section-header">
            <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12 col-sm-12">
                <?php
                    if(!empty($implementation_steps['heading'])) {
                        echo '<h2 class="setup-process-title h1 heading-bold text-none">' . esc_html($implementation_steps['heading']) . '</h2>';
                    }
                ?>
            </div>
            <div class="col-xxl-7 col-xl-7 col-lg-12 col-md-12 col-sm-12">
                <?php
                    if(!empty($implementation_steps['descripation'])) {
                        ?><p><?php echo esc_html($implementation_steps['descripation']); ?></p><?php
                    }
                    if(!empty($implementation_steps['button'])) {
                        ?><a href="<?php echo esc_url($implementation_steps['button']['url']); ?>"
                    class="btn theme-btn"><?php echo esc_html($implementation_steps['button']['title']); ?></a><?php
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <?php
                if(!empty($implementation_steps['implementation_repeater'])) {
                    foreach($implementation_steps['implementation_repeater'] as $key => $process) {
                        $key++;
                        echo '<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-12 col-sm-12 setup-process-item">';
                        echo '<div class="process-item">';
                        echo '<div class="process-image"><img src="' . esc_url($process['image']['url']) . '" alt="' . esc_attr($process['image']['name']) . '" class="img-fluid"></div>';
                        echo '<h3 class="setup-conetnt-process-title heading-bold"> <span>#'. $key .'</span>'. esc_html($process['title']) . '</h3>';
                        echo '<p>' . esc_html($process['descripation']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </div>
</section>
<section class="sectionCvr client-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper title-block text-center">
                    <h2 class="title text-none"><?php echo $trusted_by_our_clients_section['heading']; ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-6 col-xl-8 col-lg-8 col-md-12 col-sm-12 me-auto ms-auto">
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
<section class="sectionCvr product-info-sec pt-0">
    <div class="container">
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="product-info-wrapper">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7 col-sm-12 product-info-video">
                            <div class="product-info-block product-video-block">
                                <div class="title-block-wrapper title-block">
                                    <h3 class="title"><?php echo $videoSec['title']; ?></h3>
                                    <p class="desc"><?php echo $videoSec['description']; ?></p>
                                </div>
                                <div class="video-list-wrapper">
                                    <div id="product-video-slider" class="product-video-slider">
                                        <?php 
                                        $VideosLists = $videoSec['videos'];
                                        $i = 1;
                                        if(!empty($VideosLists)){
                                            foreach($VideosLists as $VideosList ) {
                                                $Videos = $VideosList['video'];
                                                $i++;
                                                $link_id = $Videos["url"];
                                                $video_id = explode("?v=", $link_id);
                                                $video_id = $video_id[1];
                                                // $videothumbnail="http://img.youtube.com/vi/".$video_id."/mqdefault.jpg";
                                                $max_thumbnail = "https://img.youtube.com/vi/".$video_id."/maxresdefault.jpg";
                                                $default_thumbnail = "https://img.youtube.com/vi/".$video_id."/mqdefault.jpg";
                                                $videothumbnail = @getimagesize($max_thumbnail) ? $max_thumbnail : $default_thumbnail; 
                                                $oembed_url = "https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=$video_id&format=json";
                                                //$response = @file_get_contents($oembed_url);
                                                $response = wee_fetch_url($oembed_url);
                                                if ($response !== false) {
                                                    $data = json_decode($response);
                                                    $Videotitle = $data->title; 
                                                }
                                                ?>
                                        <div class="rev_slide">
                                            <div class="lightbox-video-inner">
                                                <a href="<?php echo $link_id; ?>" data-fancybox="product-video">
                                                    <div class="video-img">
                                                        <img src="<?php echo $videothumbnail; ?>" width="100%"
                                                            alt="<?php echo $Videotitle; ?>">
                                                    </div>
                                                </a>
                                            </div>
                                        </div><?php
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5 col-sm-12">
                            <div class="product-info-block product-count-block">
                                <div class="collage-img">
                                    <?php
                                    if(!empty($prdctCountSec['images'])){
                                        foreach ($prdctCountSec['images'] as $image) { ?>
                                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['url']; ?>">
                                    <?php 
                                        } 
                                    }?>
                                </div>
                                <div class="count-block">
                                    <p class="count"><?php echo $prdctCountSec['title']; ?></p>
                                    <p class="desc"><?php echo $prdctCountSec['description']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="compact-price-wrap">
                                <div class="row align-items-end">
                                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7 col-sm-12">
                                        <div class="compact-price-block">
                                            <div class="title-block">
                                                <h2 class="title text-none"><?php echo $comPriceSec['title']; ?></h2>
                                            </div>
                                            <p class="desc"><?php echo $comPriceSec['descripation']; ?></p>
                                            <p class="block-cta mb-0"><a
                                                    href="<?php echo $comPriceSec['button']['url']; ?>"
                                                    class="theme-btn" data-bs-toggle="modal"
                                                    data-bs-target="#popupModal"><?php echo $comPriceSec['button']['title']; ?></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5 col-sm-12">
                                        <div class="compact-price-img">
                                            <img src="<?php echo $comPriceSec['image']['url']; ?>"
                                                alt="<?php echo $comPriceSec['image']['alt']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ourvalues-sec pdp-ourvalues">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="ourvalues-wrapper">
                    <div class="row">
                        <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                            <div class="ourvalues-column-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12 pe-0">
                                        <div class="ourvalues-img ourvalues-column">
                                            <img src="<?php echo $our_core_value['image']['url']; ?>"
                                                alt="<?php echo $our_core_value['image']['alt']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xxl-7 col-xl-7 col-lg-6 col-md-12 col-sm-12 ps-0">
                                        <div class="ourvalues-wrap ourvalues-column">
                                            <div class="title-block">
                                                <h2 class="title mb-0 text-none">
                                                    <?php echo $our_core_value['heading']; ?></h2>
                                            </div>
                                            <p class="desc"><?php echo $our_core_value['description']; ?></p>
                                            <p class="block-cta mb-0"><a
                                                    href="<?php echo $our_core_value['button']['url']; ?>"
                                                    class="theme-btn" data-bs-toggle="modal"
                                                    data-bs-target="#popupModal"><?php echo $our_core_value['button']['title']; ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sectionCvr testimonials-sec">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center title-block">
                    <h2 class="title text-none"><?php echo $testimonials_section['heading']; ?></h2>
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
                                        <img src="<?php echo $testiList['client_image']['url']; ?>"
                                            alt="<?php echo $testiList['client_image']['alt']; ?>">
                                        <?php } else { ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/test-img-avatar.png"
                                            alt="testimonial">
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
                            <h2 class="title text-none"><?php echo $faq_section['heading']; ?></h2>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-12">
                        <div class="block-cta">
                            <?php if ( ! empty( $faq_section['button']['url'] ) && ! empty( $faq_section['button']['title'] ) ) : ?>
                            <p class="mb-0">
                                <a href="<?php echo esc_url( $faq_section['button']['url'] ); ?>" class="theme-btn mt-0"
                                    data-bs-toggle="modal" data-bs-target="#popupModal">
                                    <?php echo esc_html( $faq_section['button']['title'] ); ?>
                                </a>
                            </p>
                            <?php endif; ?>
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
                                        <button class="accordion-button <?php if($faq1 != 1 ){ echo 'collapsed'; } ?>"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faqcollapse-<?php echo $faq1; ?>"
                                            aria-expanded="<?php if($faq1 == 3 ){ echo 'true'; } else{ echo "false"; } ?>"
                                            aria-controls="faqcollapse-<?php echo $faq1; ?>"><?php echo $faq1List['title']; ?></button>
                                    </h3>
                                    <div id="faqcollapse-<?php echo $faq1; ?>"
                                        class="accordion-collapse collapse <?php if($faq1 == 1 ){ echo "show"; } ?>"
                                        data-bs-parent="#faqMain">
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
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq1collapse-<?php echo $faq2; ?>" aria-expanded="true"
                                            aria-controls="faq1collapse-<?php echo $faq2; ?>"><?php echo $faq2List['title']; ?></button>
                                    </h3>
                                    <div id="faq1collapse-<?php echo $faq2; ?>" class="accordion-collapse collapse"
                                        data-bs-parent="#faqMain">
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