<?php
/**
 * Template Name: Home Page
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */
//echo get_page_link(351);
//echo get_template_directory_uri();

$trusted_by_our_clients_3_section = get_field('trusted_by_our_clients_3_section','option');
$videoSec = $trusted_by_our_clients_3_section['section_1'];
$prdctCountSec = $trusted_by_our_clients_3_section['section_2'];
$comPriceSec = $trusted_by_our_clients_3_section['section_3'];
$trusted_by_our_clients_section = get_field('trusted_by_our_clients_section','option');
$trusted_by_our_clients_3_section = get_field('trusted_by_our_clients_3_section','option');
get_header(); 
$colorClasses = [
"light-mint-bg-clr",
"soft-peach-bg-clr",
"light-ivory-bg-clr",
"sky-blue-bg-clr",
"lavender-mist-bg-clr",
"off-white-bg-clr", "light-lavender-bg-clr" ]; ?>
<section class="sectionCvr home-banner-sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <div class="banner-wrap">
                    <div class="banner-rating">
                        <ul class="rating-block">
                            <li>
                                <p class="rating-icon"><a href="#"><img
                                            src="<?php echo get_template_directory_uri(); ?>/images/rating-icon-1.png"
                                            align="rating-icon"></a></p>
                                <p>
                                    <span class="rating">4.4</span>
                                    <span class="star-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    </span>
                                </p>
                            </li>
                            <li>
                                <p class="rating-icon"><a href="#"><img
                                            src="<?php echo get_template_directory_uri(); ?>/images/rating-icon-2.png"
                                            align="rating-icon"></a></p>
                                <p>
                                    <span class="rating">4.6</span>
                                    <span class="star-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    </span>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="banner-details">
                        <?php $bannerLeftBlock = get_field('banner_left_block');?>
                        <div class="banner-title-wrap">
                            <ul class="v-slides">
                                <?php $bannerLines = $bannerLeftBlock['banner_lines'];

						  	foreach ( $bannerLines as $key => $bannerLine) { ?>
                                <li class="v-slide">
                                    <?php if ($key === 2) : ?>                                       
                                            <div class="line light"><?php echo $bannerLine['banner_light_text']; ?></div>
                                            <?php
                                            $bold = $bannerLine['banner_bold_text'] ?? '';
                                            $parts = preg_split('/\s{2,}/', $bold);
                                            echo '<h1 class="line strong">';
                                            foreach ($parts as $part) {
                                                echo '<span class="line-part">' . esc_html(trim($part)) . '</span>';
                                            }
                                            echo '</h1>';
                                            ?>
                                    <?php else : ?>
                                        <div class="line light"><?php echo $bannerLine['banner_light_text']; ?></div>
                                        <?php
                                        $bold = $bannerLine['banner_bold_text'] ?? '';
                                        $parts = preg_split('/\s{2,}/', $bold);
                                        echo '<div class="line strong">';
                                        foreach ($parts as $part) {
                                            echo '<span class="line-part">' . esc_html(trim($part)) . '</span>';
                                        }
                                        echo '</div>';
                                        ?>
                                    <?php endif; ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <p class="banner-desc"><?php echo $bannerLeftBlock['banner_desc'];?></p>
                        <div class="banner-left-cta-button">
                        <?php $bannerBtn = $bannerLeftBlock['banner_button']; ?>
                        <p class="banner-cta"><a href="<?php echo $bannerBtn['button_url']; ?>" 
                                class="theme-btn"><?php echo $bannerBtn['button_text']; ?></a></p>
                        <?php $getDemoBtn = $bannerLeftBlock['get_demo_button']; ?>
                        <p class="banner-cta"><a href="<?php echo $getDemoBtn['button_url']; ?>" 
                               
                                class="theme-btn button-left"><?php echo $getDemoBtn['button_text']; ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12">
                <div class="home-banner-tabs">
                    <?php $bannerRightBlock = get_field('banner_right_block'); ?>
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="banner-tabs-1 banner-tabsCvr">
                                <div class="accordion accordion-flush" id="banner-tab1">
                                    <?php $bannerBlock1 = $bannerRightBlock['banner_block_1']; ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <div class="tab-icon">
                                                <img class="icon"
                                                    src="<?php echo $bannerBlock1['bb_title_block']['title_icon']['url']; ?>"
                                                    alt="<?php echo $bannerBlock1['bb_title_block']['title_icon']['alt']; ?>">
                                            </div>
                                            <button class="accordion-button accordion-button-homepage" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#banner-tab1-1" aria-expanded="true"
                                                aria-controls="#banner-tab1-1">
                                                <?php echo $bannerBlock1['bb_title_block']['block_title']; ?>
                                            </button>
                                            <img class="tab-img"
                                                src="<?php echo $bannerBlock1['bb_title_block']['title_image']['url']; ?>"
                                                alt="<?php echo $bannerBlock1['bb_title_block']['title_image']['alt']; ?>">
                                        </h2>
                                        <div id="banner-tab1-1" class="accordion-collapse collapse show"
                                            data-bs-parent="#banner-tab1">
                                            <div class="accordion-body">
                                                <img src="<?php echo $bannerBlock1['content_block']['content_image']['url']; ?>"
                                                    alt="<?php echo $bannerBlock1['content_block']['content_image']['alt']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <?php $bannerBlock2 = $bannerRightBlock['banner_block_2']; ?>
                                        <h2 class="accordion-header">
                                            <div class="tab-icon">
                                                <img class="icon"
                                                    src="<?php echo $bannerBlock2['bb_title_block']['title_icon']['url']; ?>"
                                                    alt="<?php echo $bannerBlock2['bb_title_block']['title_icon']['alt']; ?>">
                                            </div>
                                            <button class="accordion-button accordion-button-homepage collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#banner-tab1-2"
                                                aria-expanded="false" aria-controls="#banner-tab1-2">
                                                <?php echo $bannerBlock2['bb_title_block']['block_title']; ?>
                                            </button>
                                            <img class="tab-img"
                                                src="<?php echo $bannerBlock2['bb_title_block']['title_image']['url']; ?>"
                                                alt="<?php echo $bannerBlock2['bb_title_block']['title_image']['alt']; ?>">
                                        </h2>
                                        <div id="banner-tab1-2" class="accordion-collapse collapse"
                                            data-bs-parent="#banner-tab1">
                                            <div class="accordion-body">
                                                <div class="accordion-body-wrap">
                                                    <?php /*
								      		<div class="body-content">
								      			<div class="banner-canvas-block canvas-wrapper">
											      	 <div id="tag-container" class="tag-container"></div>
        <canvas id="matter-canvas"></canvas>
												</div>
								      		</div>
								      		<div class="body-img">
								      			<img src="<?php echo get_template_directory_uri(); ?>/images/customization-products-img.png"
                                                    alt="tab2">
                                                </div> */ ?>
                                                <div class="canvas-block">
                                                    <img src="<?php echo $bannerBlock2['content_block']['content_left_image']['url']; ?>"
                                                        alt="<?php echo $bannerBlock2['content_block']['content_left_image']['alt']; ?>">
                                                </div>
                                                <div class="body-img">
                                                    <img src="<?php echo $bannerBlock2['content_block']['content_right_image']['url']; ?>"
                                                        alt="<?php echo $bannerBlock2['content_block']['content_right_image']['alt']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 ps-0">
                        <div class="banner-tabs-2 banner-tabsCvr">
                            <div class="accordion accordion-flush" id="banner-tab2">
                                <div class="accordion-item">
                                    <?php $bannerBlock3 = $bannerRightBlock['banner_block_3']; ?>
                                    <h2 class="accordion-header">
                                        <div class="tab-icon">
                                            <img class="icon"
                                                src="<?php echo $bannerBlock3['bb_title_block']['title_icon']['url']; ?>"
                                                alt="<?php echo $bannerBlock3['bb_title_block']['title_icon']['alt']; ?>">
                                        </div>
                                        <button class="accordion-button accordion-button-homepage collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#banner-tab2-1"
                                            aria-expanded="false" aria-controls="banner-tab2-1">
                                            <?php echo $bannerBlock3['bb_title_block']['block_title']; ?>
                                        </button>
                                    </h2>
                                    <div id="banner-tab2-1" class="accordion-collapse collapse"
                                        data-bs-parent="#banner-tab2">
                                        <?php $bb3CtBlock = $bannerBlock3['content_block']; ?>
                                        <div class="accordion-body">
                                            <div class="bannerfeature-listsCvr">
                                                <ul class="bannerfeature-lists bannerfeatureLists1 slick">
                                                    <?php $bnrFtrLists1 = $bb3CtBlock['banner_feature_lists_1'];
								            	foreach($bnrFtrLists1 as $bnrFtrList1) { ?>
                                                    <li><img src="<?php echo $bnrFtrList1['feature_icon']['url']; ?>"
                                                            alt="<?php echo $bnrFtrList1['feature_icon']['alt']; ?>">
                                                        <p><?php echo $bnrFtrList1['feature_title']; ?></p>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="bannerfeature-listsCvr" dir="rtl">
                                                <ul class="bannerfeature-lists bannerfeatureLists2 slick">
                                                    <?php $bnrFtrLists2 = $bb3CtBlock['banner_feature_lists_2'];
								            	foreach($bnrFtrLists2 as $bnrFtrList2) { ?>
                                                    <li><img src="<?php echo $bnrFtrList2['feature_icon']['url']; ?>"
                                                            alt="<?php echo $bnrFtrList2['feature_icon']['alt']; ?>">
                                                        <p><?php echo $bnrFtrList2['feature_title']; ?></p>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <?php $bannerBlock4 = $bannerRightBlock['banner_block_4']; ?>
                                    <h2 class="accordion-header">
                                        <div class="tab-icon">
                                            <img class="icon"
                                                src="<?php echo $bannerBlock4['bb_title_block']['title_icon']['url']; ?>"
                                                alt="<?php echo $bannerBlock4['bb_title_block']['title_icon']['alt']; ?>">
                                        </div>
                                        <button class="accordion-button accordion-button-homepage" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#banner-tab2-2" aria-expanded="true"
                                            aria-controls="#banner-tab2-2">
                                            <?php echo $bannerBlock4['bb_title_block']['block_title']; ?>
                                        </button>
                                        <img class="tab-img"
                                            src="<?php echo $bannerBlock4['bb_title_block']['title_image']['url']; ?>"
                                            alt="<?php echo $bannerBlock4['bb_title_block']['title_image']['alt']; ?>">
                                    </h2>
                                    <div id="banner-tab2-2" class="accordion-collapse collapse show"
                                        data-bs-parent="#banner-tab2">
                                        <div class="accordion-body">
                                            <div class="accordion-body-wrap">
                                                <div class="body-content">
                                                    <p><?php echo $bannerBlock4['content_block']['block_text']; ?></p>
                                                </div>
                                                <div class="body-img">
                                                    <img src="<?php echo $bannerBlock4['content_block']['block_img']['url']; ?>"
                                                        alt="<?php echo $bannerBlock4['content_block']['block_img']['alt']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <?php $ffLists = get_field('page_funfact_block'); ?>
                        <div class="page-funfactCvr">
                            <ul class="page-funfactList">
                                <?php foreach ($ffLists as $key => $ffList) { ?>
                                <li class="page-funfact">
                                    <p class="ff-icon"><img src="<?php echo $ffList['ff_icon']['url']; ?>"
                                            alt="<?php echo $ffList['ff_icon']['alt']; ?>"></p>
                                    <p class="ff-texts">
                                        <span class="ff-title"><?php echo $ffList['ff_title']; ?></span>
                                    </p>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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

<?php if ( ! empty($stats_repeater) ) : ?>
<section class="stats-section">
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
<?php endif; ?>
<?php $certiSec = get_field('certificate_section'); ?>
<section class="certificate-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="certificate-wrapper">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <div class="certificate-title">
                                <img src="<?php echo $certiSec['certi_wm_logo']['url']; ?>"
                                    alt="<?php echo $certiSec['certi_wm_logo']['alt']; ?>">
                                <p><?php echo $certiSec['certi_sec_title']; ?></p>
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
                                    <?php $certiLists =  $certiSec['certificates_lists']; 
									foreach($certiLists as $certiList){ ?>
                                    <li><img src="<?php echo $certiList['certi_logo']['url']; ?>"
                                            alt="<?php echo $certiList['certi_logo']['alt']; ?>"></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $productSec = get_field('product_sec'); ?>
<section class="sectionCvr solutions-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper title-block text-center">
                    <h2 class="title"><?php echo $productSec['block_title'];?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-6 col-xl-8 col-lg-8 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center mb-5">
                    <p class="desc"><?php echo $productSec['block_desc'];?></p>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3 mt-0 pt-5">
            <div class="col-xxl-11 col-xl-12 col-lg-12 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="solutions-wrapper">
                    <?php $prdct = 0; $productLists = $productSec['product_lists']; foreach($productLists as $productList){ $prdct++; ?>
                    <div class="card card<?php echo $prdct; ?>">
                        <div class="solutions-details">
                            <div class="details-block">
                                <p class="btn-title"><img
                                        src="<?php echo get_template_directory_uri(); ?>/images/white-icon.png"
                                        alt="WeekMate"> <?php echo $productList['product_title']; ?></p>
                                <h3 class="solutions-title"><?php echo $productList['block_title']; ?></h3>
                                <div class="solutions-feature">
                                    <?php $prdtFeaLists = $productList['product_feature_lists']; ?>
                                    <ul class="feature-lists">
                                        <?php foreach($prdtFeaLists as $prdtFeaList) { ?>
                                        <li><img src="<?php echo $prdtFeaList['feature_icon']['url']; ?>"
                                                alt="<?php echo $prdtFeaList['feature_icon']['alt']; ?>">
                                            <p><?php echo $prdtFeaList['feature_title']; ?></p>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="solutions-desc">
                                    <p><?php echo $productList['block_desc']; ?></p>
                                </div>
                                <p><a href="<?php echo $productList['product_link']; ?>" class="solutions-link">Learn
                                        more <i class="fa fa-arrow-right"></i></a></p>
                            </div>
                            <div class="image-block">
                                <img src="<?php echo $productList['product_image']['url']; ?>"
                                    alt="<?php echo $productList['product_image']['alt']; ?>">
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $awardsSec = get_field('awards_section'); ?>
<?php if (!empty($awardsSec) && !empty($awardsSec['awards_slider'])) : ?>
<section class="awards-sec sectionCvr">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="awards-sec__wrapper">
                    <div class="awards-sec__slider" id="awards-slider">
                        <?php foreach ($awardsSec['awards_slider'] as $award) :
                            $img  = $award['awards_slider_image'];
                            $link = $award['awards_slider_link'];
                        ?>
                        <div class="awards-sec__item">
                            <div class="awards-sec__block">
                                <?php if (!empty($link['url'])) : ?>
                                <a class="awards-sec__link"
                                   href="<?php echo esc_url($link['url']); ?>"
                                   target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
                                   rel="noopener">
                                <?php endif; ?>

                                    <?php if (!empty($img['url'])) : ?>
                                    <img class="awards-sec__img"
                                         src="<?php echo esc_url($img['url']); ?>"
                                         alt="<?php echo esc_attr($img['alt'] ?: 'Award'); ?>">
                                    <?php endif; ?>

                                <?php if (!empty($link['url'])) : ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
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
<?php $advToolSec = get_field('adv_tools_sec'); ?>
<section class="sectionCvr advtool-sec">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12">
                <div class="title-block-wrapper title-block pb-0 mb-0">
                    <h2 class="title"><?php echo $advToolSec['block_title']; ?></h2>
                    <p class="desc mb-0"><?php echo $advToolSec['block_desc']; ?></p>
                </div>
            </div>
            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-12">
                <div class="block-cta">
                    <p class="mb-0"><a href="<?php echo $advToolSec['block_button']['button_url']; ?>"
                            class="theme-btn mt-0" data-bs-toggle="modal"
                            data-bs-target="#popupModal"><?php echo $advToolSec['block_button']['button_text']; ?></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="advtool-wrapper">
                    <div class="row">
                        <?php $advtlsLists = $advToolSec['adv_tools_lists']; ?>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5 col-sm-12">
                            <select class="form-select advtool-dropdown" id="advtoolDropdown">
                                <?php $advtlsdd = 0; foreach( $advtlsLists as $advtlsddList ) { $advtlsdd++; ?>
                                <option value="v-pills-advtool-<?php echo $advtlsdd; ?>"
                                    <?php if($advtlsdd == 1 ){ echo "selected"; } ?>>
                                    <?php echo $advtlsddList['adv_tool_title']; ?></option>
                                <?php } ?>
                            </select>
                            <div class="advtool-tabs-lists">
                                <div class="nav flex-column nav-pills me-0 me-lg-3" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <?php $advtlsbtn = 0; foreach( $advtlsLists as $advtlsbtnList ) { $advtlsbtn++; ?>
                                    <button class="nav-link <?php if($advtlsbtn == 1 ){ echo "active"; } ?>"
                                        id="v-pills-advtool-<?php echo $advtlsbtn; ?>-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-advtool-<?php echo $advtlsbtn; ?>" type="button"
                                        role="tab" aria-controls="v-pills-advtool-<?php echo $advtlsbtn; ?>"
                                        aria-selected="<?php if($advtlsbtn == 1 ){ echo "true"; } else { echo "false"; } ?>">
                                        <span class="advtool-icon">
                                            <img class="icon"
                                                src="<?php echo $advtlsbtnList['adv_tool_icon']['url']; ?>"
                                                alt="<?php echo $advtlsbtnList['adv_tool_icon']['alt']; ?>"><img
                                                class="hover-icon"
                                                src="<?php echo $advtlsbtnList['adv_tool_hover_icon']['url']; ?>"
                                                alt="<?php echo $advtlsbtnList['adv_tool_hover_icon']['alt']; ?>">
                                        </span>
                                        <?php echo $advtlsbtnList['adv_tool_title']; ?></button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7 col-sm-12">
                            <div class="advtool-tabs-content">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <?php $advtlsDtl = 0; foreach( $advtlsLists as $advtlsdetail ) { $advtlsDtl++; ?>
                                    <div class="tab-pane fade <?php if($advtlsDtl == 1 ){ echo "show active"; } ?>"
                                        id="v-pills-advtool-<?php echo $advtlsDtl; ?>" role="tabpanel"
                                        aria-labelledby="v-pills-advtool-<?php echo $advtlsDtl; ?>-tab">
                                        <div class="advtool-details">
                                            <h3 class="title">
                                                <span class="advtool-mobile-icon"><img
                                                        src="<?php echo $advtlsdetail['adv_tool_hover_icon']['url']; ?>"
                                                        alt="<?php echo $advtlsdetail['adv_tool_hover_icon']['alt']; ?>"></span>
                                                <?php echo $advtlsdetail['adv_tool_title']; ?>
                                            </h3>
                                            <p><?php echo $advtlsdetail['adv_tool_desc']; ?></p>
                                            <img src="<?php echo $advtlsdetail['adv_tool_img']['url']; ?>"
                                                alt="<?php echo $advtlsdetail['adv_tool_img']['alt']; ?>">
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
        <!-- <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="block-cta-wrapper">
                    <?php $advBtmBlock = $advToolSec['bottom_block']; ?>
                    <div class="row align-items-center justify-content-around">
                        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                            <p class="cta-title"><?php echo $advBtmBlock['btm_block_title']; ?></p>
                        </div>

                        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                            <p><?php echo $advBtmBlock['btm_block_desc']; ?></p>
                            <p class="mb-0">
                                <a href="<?php echo esc_url( $advBtmBlock['block_button']['button_url'] ); ?>"
                                    class="theme-btn">
                                    <?php echo esc_html( $advBtmBlock['block_button']['button_text'] ); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</section>
<?php $casestudySec = get_field('case_study_sec'); ?>
<section class="sectionCvr casestudy-sec">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12 col-sm-12">
                <div class="casestudy-block-wrap">
                    <div class="title-block">
                        <h2 class="title mb-0"><?php echo $casestudySec['block_title']; ?></h2>
                    </div>
                    <p class="desc"><?php echo $casestudySec['block_desc']; ?></p>
                    <p class="block-cta mb-0">
                        <?php if ( !empty($casestudySec['block_button']['button_url']) ) : ?>
                        <a href="<?php echo esc_url($casestudySec['block_button']['button_url']); ?>" class="theme-btn"
                            <?php if ( isset($casestudySec['block_button']['open_in_popup']) && $casestudySec['block_button']['open_in_popup'] === 'yes' ) : ?>
                            data-bs-toggle="modal" data-bs-target="#popupModal" <?php endif; ?>>
                            <?php echo esc_html($casestudySec['block_button']['button_text']); ?>
                        </a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12 col-sm-12">
                <div class="casestudy-list-wrap">
                    <div id="casestudy-slider" class="casestudy-slider">
                        <?php
                        $colorClasses = [
                            "lavender-mist-bg-clr",
                            "light-ivory-bg-clr",
                            "soft-peach-bg-clr",
                            "light-mint-bg-clr",
                            "sky-blue-bg-clr",
                            "off-white-bg-clr",
                            "light-lavender-bg-clr"
                        ];

                        $case_args = array(
                            'post_type'      => 'case_study',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish'
                        );

                        $case_query = new WP_Query($case_args);

                        if ($case_query->have_posts()) :
                            $i = 0;
                            while ($case_query->have_posts()) : $case_query->the_post();

                                $classIndex   = $i % count($colorClasses);
                                $currentClass = $colorClasses[$classIndex];

                                // Reading time calculation
                                $content     = get_post_field('post_content', get_the_ID());
                                $word_count  = str_word_count(wp_strip_all_tags($content));
                                $reading_min = ceil($word_count / 200);
                        ?>
                                
                                <div class="casestudy-item">
                                    <div class="casestudy-block <?php echo esc_attr($currentClass); ?>">
                                        
                                        <div class="casestudy-info">
                                            <h3 class="casestudy-title"><?php the_title(); ?></h3>
                                            
                                            <p class="casestudy-time">
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/cs-watch-icon.png" alt="time">
                                                Max. <?php echo esc_html($reading_min); ?> min read
                                            </p>

                                            <?php if ( has_excerpt() || get_the_content() ) : ?>
                                                <p class="casestudy-excerpt">
                                                    <?php echo wp_trim_words( get_the_excerpt(), 18 ); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="casestudy-link">
                                            <a href="<?php the_permalink(); ?>" class="theme-btn white-btn">
                                                Read more
                                            </a>
                                        </div>

                                    </div>
                                </div>

                        <?php
                                $i++;
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p>No case studies found.</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $testimonialSec = get_field('testimonials_sec'); ?>
<section class="sectionCvr testimonials-sec">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center title-block">
                    <h2 class="title"><?php echo $testimonialSec['block_title']; ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid g-0">
        <div class="row">
            <div class="col-xxl-11 col-xl-12 col-lg-12 col-md-12 col-sm-12 m-auto">
                <div class="testimonials-wrapper">
                    <div id="testimonials-slider" class="testimonials-slider">
                        <?php $testiLists =  $testimonialSec['testimonials_lists'];
						 $testi = 0;
						 foreach($testiLists as $testiList){
						 $testirandomClass = $colorClasses[$testi % count($colorClasses)];  ?>
                        <div class="testimonials-item">
                            <div class="testimonials-block <?php echo esc_attr($testirandomClass); ?>">
                                <div class="testi-img-play">
                                    <p class="testi-img">
                                        <?php if(!empty($testiList['author_img'])){ ?>
                                        <img src="<?php echo $testiList['author_img']['url']; ?>"
                                            alt="<?php echo $testiList['author_img']['alt']; ?>">
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
                                    <p><?php echo $testiList['testimonial_txt']; ?></p>
                                </div>
                                <div class="testi-author">
                                    <p class="author"><?php echo $testiList['author_details']['author_name']; ?></p>
                                    <p class="desig"><?php echo $testiList['author_details']['author_cmp_name']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $testi++; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $featuresSec = get_field('features_section'); ?>
<section class="sectionCvr features-sec pt-3">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center title-block">
                    <h2 class="title"><?php echo $featuresSec['block_title']; ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="feature-lists-wrapper">
                    <div class="feature-listsCvr">
                        <ul class="feature-lists featureLists1 slick">
                            <?php $feaLists1 =  $featuresSec['feature_sec_lists_1'];  
			            	foreach($feaLists1 as $feaList1){?>
                            <li><img src="<?php echo $feaList1['feature_icon']['url']; ?>"
                                    alt="<?php echo $feaList1['feature_icon']['alt']; ?>">
                                <p><?php echo $feaList1['feature_title']; ?></p>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- <div class="feature-listsCvr" dir="rtl">
                        <ul class="feature-lists featureLists2 slick">
                            <?php $feaLists2 =  $featuresSec['feature_sec_lists_2']; 
			            	foreach($feaLists2 as $feaList2){?>
                            <li><img src="<?php echo $feaList2['feature_icon']['url']; ?>"
                                    alt="<?php echo $feaList2['feature_icon']['alt']; ?>">
                                <p><?php echo $feaList2['feature_title']; ?></p>
                            </li>
                            <?php } ?>
                        </ul>
                    </div> -->
                    <div class="feature-logo-block">
                        <?php $feaIconBlock =  $featuresSec['weekmate_icon_block']; ?>
                        <div class="logo">
                            <img src="<?php echo $feaIconBlock['weekmate_logo']['url']; ?>"
                                alt="<?php echo $feaIconBlock['weekmate_logo']['alt']; ?>">
                        </div>
                        <?php $product_banner_right_block = get_field('product_banner_right_block');?>
                        <div class="logo-quote">
                            <p><?php echo $featuresSec['weekmate_icon_block']['bottom_text']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="light-mint-bg-clr product-item">
                    <?php $product_banner_block_1 = $product_banner_right_block['product_banner_block_1']; ?>
                    <h2 class="accordion-header">
                        <div class="tab-icon">
                            <?php
                $title_icon_id = $product_banner_block_1['bb_title_block']['title_icon'];
                $title_icon    = wp_prepare_attachment_for_js( $title_icon_id );
                ?>
                            <?php if ( $title_icon ) : ?>
                            <img class="icon" src="<?php echo esc_url( $title_icon['url'] ); ?>"
                                alt="<?php echo esc_attr( $title_icon['alt'] ); ?>">
                            <?php endif; ?>
                        </div>
                    </h2>
                    <div id="" class="" data-bs-parent="#banner-tab2">
                        <?php $bb3CtBlock1 = $product_banner_block_1['content_block']; ?>
                        <div class="accordion-body">
                            <div class="bannerfeature-listsCvr">
                                <ul class="bannerfeature-lists bannerfeatureLists1 slick">
                                    <?php $bnrFtrLists1 = $bb3CtBlock1['banner_feature_lists_1'];
                        foreach ( $bnrFtrLists1 as $bnrFtrList1 ) {
                            $icon_id = $bnrFtrList1['icon'];
                            $icon    = wp_prepare_attachment_for_js( $icon_id );
                            ?>
                                    <li>
                                        <?php if ( $icon ) : ?>
                                        <img src="<?php echo esc_url( $icon['url'] ); ?>"
                                            alt="<?php echo esc_attr( $icon['alt'] ); ?>">
                                        <?php endif; ?>
                                        <p><?php echo esc_html( $bnrFtrList1['feature_title'] ); ?></p>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="bannerfeature-listsCvr" dir="rtl">
                                <ul class="bannerfeature-lists bannerfeatureLists2 slick">
                                    <?php $bnrFtrLists2 = $bb3CtBlock1['banner_feature_lists_2'];
                        foreach ( $bnrFtrLists2 as $bnrFtrList2 ) {
                            $icon_id = $bnrFtrList2['icon'];
                            $icon    = wp_prepare_attachment_for_js( $icon_id );
                            ?>
                                    <li>
                                        <?php if ( $icon ) : ?>
                                        <img src="<?php echo esc_url( $icon['url'] ); ?>"
                                            alt="<?php echo esc_attr( $icon['alt'] ); ?>">
                                        <?php endif; ?>
                                        <p><?php echo esc_html( $bnrFtrList2['feature_title'] ); ?></p>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="light-lavender-bg-clr product-item">
                    <?php $product_banner_block_2 = $product_banner_right_block['product_banner_block_2']; ?>
                    <h2 class="accordion-header">
                        <div class="tab-icon">
                            <?php
                $title_icon_id = $product_banner_block_2['bb_title_block']['title_icon'];
                $title_icon    = wp_prepare_attachment_for_js( $title_icon_id );
                ?>
                            <?php if ( $title_icon ) : ?>
                            <img class="icon" src="<?php echo esc_url( $title_icon['url'] ); ?>"
                                alt="<?php echo esc_attr( $title_icon['alt'] ); ?>">
                            <?php endif; ?>
                        </div>
                    </h2>
                    <div id="" class="" data-bs-parent="#banner-tab2">
                        <?php $bb3CtBlock1 = $product_banner_block_2['content_block']; ?>
                        <div class="accordion-body">
                            <div class="bannerfeature-listsCvr">
                                <ul class="bannerfeature-lists bannerfeatureLists1 slick">
                                    <?php $bnrFtrLists1 = $bb3CtBlock1['banner_feature_lists_1'];
                        foreach ( $bnrFtrLists1 as $bnrFtrList1 ) {
                            $icon_id = $bnrFtrList1['icon'];
                            $icon    = wp_prepare_attachment_for_js( $icon_id );
                            ?>
                                    <li>
                                        <?php if ( $icon ) : ?>
                                        <img src="<?php echo esc_url( $icon['url'] ); ?>"
                                            alt="<?php echo esc_attr( $icon['alt'] ); ?>">
                                        <?php endif; ?>
                                        <p><?php echo esc_html( $bnrFtrList1['feature_title'] ); ?></p>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="bannerfeature-listsCvr" dir="rtl">
                                <ul class="bannerfeature-lists bannerfeatureLists2 slick">
                                    <?php $bnrFtrLists2 = $bb3CtBlock1['banner_feature_lists_2'];
                        foreach ( $bnrFtrLists2 as $bnrFtrList2 ) {
                            $icon_id = $bnrFtrList2['icon'];
                            $icon    = wp_prepare_attachment_for_js( $icon_id );
                            ?>
                                    <li>
                                        <?php if ( $icon ) : ?>
                                        <img src="<?php echo esc_url( $icon['url'] ); ?>"
                                            alt="<?php echo esc_attr( $icon['alt'] ); ?>">
                                        <?php endif; ?>
                                        <p><?php echo esc_html( $bnrFtrList2['feature_title'] ); ?></p>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="soft-peach-bg-clr product-item">
                    <?php 
        $product_banner_block_3 = $product_banner_right_block['product_banner_block_3']; 

        // ✅ Convert title icon ID → array
        if ( !empty($product_banner_block_3['bb_title_block']['title_icon']) 
            && !is_array($product_banner_block_3['bb_title_block']['title_icon']) ) {
            $product_banner_block_3['bb_title_block']['title_icon'] = wp_prepare_attachment_for_js(
                $product_banner_block_3['bb_title_block']['title_icon']
            );
        }
        ?>
                    <h2 class="accordion-header">
                        <div class="tab-icon">
                            <?php if ( !empty($product_banner_block_3['bb_title_block']['title_icon']['url']) ) : ?>
                            <img class="icon"
                                src="<?php echo esc_url($product_banner_block_3['bb_title_block']['title_icon']['url']); ?>"
                                alt="<?php echo esc_attr($product_banner_block_3['bb_title_block']['title_icon']['alt']); ?>">
                            <?php endif; ?>
                        </div>
                    </h2>

                    <div id="" class="" data-bs-parent="#banner-tab2">
                        <?php $bb3CtBlock1 = $product_banner_block_3['content_block']; ?>
                        <div class="accordion-body">

                            <!-- ✅ List 1 -->
                            <div class="bannerfeature-listsCvr">
                                <ul class="bannerfeature-lists bannerfeatureLists1 slick">
                                    <?php 
                        if ( !empty($bb3CtBlock1['banner_feature_lists_1']) ) {
                            foreach ( $bb3CtBlock1['banner_feature_lists_1'] as $bnrFtrList1 ) {

                                // Convert icon ID → array
                                if ( !empty($bnrFtrList1['icon']) && !is_array($bnrFtrList1['icon']) ) {
                                    $bnrFtrList1['icon'] = wp_prepare_attachment_for_js($bnrFtrList1['icon']);
                                }
                                ?>
                                    <li>
                                        <?php if ( !empty($bnrFtrList1['icon']['url']) ) : ?>
                                        <img src="<?php echo esc_url($bnrFtrList1['icon']['url']); ?>"
                                            alt="<?php echo esc_attr($bnrFtrList1['icon']['alt']); ?>">
                                        <?php endif; ?>
                                        <p><?php echo esc_html($bnrFtrList1['feature_title']); ?></p>
                                    </li>
                                    <?php }
                        } ?>
                                </ul>
                            </div>

                            <!-- ✅ List 2 -->
                            <div class="bannerfeature-listsCvr" dir="rtl">
                                <ul class="bannerfeature-lists bannerfeatureLists2 slick">
                                    <?php 
                        if ( !empty($bb3CtBlock1['banner_feature_lists_2']) ) {
                            foreach ( $bb3CtBlock1['banner_feature_lists_2'] as $bnrFtrList2 ) {

                                // Convert icon ID → array
                                if ( !empty($bnrFtrList2['icon']) && !is_array($bnrFtrList2['icon']) ) {
                                    $bnrFtrList2['icon'] = wp_prepare_attachment_for_js($bnrFtrList2['icon']);
                                }
                                ?>
                                    <li>
                                        <?php if ( !empty($bnrFtrList2['icon']['url']) ) : ?>
                                        <img src="<?php echo esc_url($bnrFtrList2['icon']['url']); ?>"
                                            alt="<?php echo esc_attr($bnrFtrList2['icon']['alt']); ?>">
                                        <?php endif; ?>
                                        <p><?php echo esc_html($bnrFtrList2['feature_title']); ?></p>
                                    </li>
                                    <?php }
                        } ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="sky-blue-bg-clr product-item">
                    <?php $product_banner_block_4 = $product_banner_right_block['product_banner_block_4']; ?>
                    <h2 class="accordion-header">
                        <div class="tab-icon">
                            <img class="icon"
                                src="<?php echo $product_banner_block_4['bb_title_block']['title_icon']['url']; ?>"
                                alt="<?php echo $product_banner_block_4['bb_title_block']['title_icon']['alt']; ?>">
                        </div>
                    </h2>
                    <div id="" class="" data-bs-parent="#banner-tab2">
                        <?php $bb3CtBlock1 = $product_banner_block_4['content_block']; ?>
                        <div class="accordion-body">
                            <div class="bannerfeature-listsCvr">
                                <ul class="bannerfeature-lists bannerfeatureLists1 slick">
                                    <?php $bnrFtrLists1 = $bb3CtBlock1['banner_feature_lists_1'];
                                    foreach($bnrFtrLists1 as $bnrFtrList1) { ?>
                                    <li><img src="<?php echo $bnrFtrList1['icon']['url']; ?>"
                                            alt="<?php echo $bnrFtrList1['icon']['alt']; ?>">
                                        <p><?php echo $bnrFtrList1['feature_title']; ?></p>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="bannerfeature-listsCvr" dir="rtl">
                                <ul class="bannerfeature-lists bannerfeatureLists2 slick">
                                    <?php $bnrFtrLists2 = $bb3CtBlock1['banner_feature_lists_2'];
                                    foreach($bnrFtrLists2 as $bnrFtrList2) { ?>
                                    <li><img src="<?php echo $bnrFtrList2['icon']['url']; ?>"
                                            alt="<?php echo $bnrFtrList2['icon']['alt']; ?>">
                                        <p><?php echo $bnrFtrList2['feature_title']; ?></p>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row mt-lg-5 mt-2">
            <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
                <?php $feabtmBlock =  $featuresSec['bottom_block']; ?>
                <div class="title-block-wrapper text-center title-block">
                    <p class="desc"><?php echo $feabtmBlock['bb_desc']; ?></p>
                </div>
                <div class="block-cta text-center">
                    <p><a href="<?php echo $feabtmBlock['bb_btn_1']['button_url']; ?>" class="theme-btn me-3"
                            data-bs-toggle="modal"
                            data-bs-target="#popupModal"><?php echo $feabtmBlock['bb_btn_1']['button_text']; ?></a> <a
                            href="<?php echo $feabtmBlock['bb_btn_2']['button_url']; ?>" class="theme-btn outline-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#popupModal"><?php echo $feabtmBlock['bb_btn_2']['button_text']; ?></a></p>
                </div>
            </div>
        </div> -->
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
                                                $Videotitle = '';
                                                $oembed_url = "https://www.youtube.com/oembed?url=" . urlencode("https://www.youtube.com/watch?v=$video_id") . "&format=json";
                                                $response = wp_remote_get($oembed_url, ['timeout' => 10]);
                                                if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                                                    $data = json_decode(wp_remote_retrieve_body($response));
                                                    $Videotitle = $data->title ?? '';
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
                        <!-- <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5 col-sm-12">
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
                        </div> -->
                    </div>
                    <!-- <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="compact-price-wrap">
                                <div class="row align-items-end">
                                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7 col-sm-12">
                                        <div class="compact-price-block">
                                            <div class="title-block">
                                                <h2 class="title"><?php echo $comPriceSec['title']; ?></h2>
                                            </div>
                                            <p class="desc"><?php echo $comPriceSec['descripation']; ?></p>
                                            <p class="block-cta mb-0"><a
                                                    href="<?php echo $comPriceSec['button']['url']; ?>"
                                                    class="theme-btn" 
                                                    ><?php echo $comPriceSec['button']['title']; ?></a>
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
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<?php $indusSec = get_field('industries_sec'); ?>
<section class="sectionCvr industries-sec pt-4">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12 col-sm-12">
                <div class="industries-block-wrap">
                    <div class="indus-logo">
                        <img src="<?php echo $indusSec['block_logo']['url']; ?>"
                            alt="<?php echo $indusSec['block_logo']['alt']; ?>">
                    </div>
                    <div class="title-block">
                        <h2 class="title mb-0"><?php echo $indusSec['block_title']; ?></h2>
                    </div>
                    <p class="desc"><?php echo $indusSec['block_desc']; ?></p>
                    <p class="block-cta mb-0">
                        <?php if ( !empty($indusSec['block_button']['button_url']) ) : ?>
                        <a href="<?php echo esc_url($indusSec['block_button']['button_url']); ?>" class="theme-btn">
                            <?php echo esc_html($indusSec['block_button']['button_text']); ?>
                        </a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12 col-sm-12">
                <div class="industries-list-wrap">
                    <div id="industries-slider" class="industries-slider">
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/software-it.png"
                                        alt="Software & IT Services">
                                    <p class="link"><a href="https://weekmate.in/software-it/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Software & IT Services</p>
                            </div>
                        </div>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/manufacturing.png"
                                        alt="Manufacturing">
                                    <p class="link"><a href="https://weekmate.in/manufacturing/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Manufacturing</p>
                            </div>
                        </div>
                        <!-- <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/financial.png"
                                        alt="Financial">
                                    <p class="link"><a href="https://weekmate.in/financial/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Financial</p>
                            </div>
                        </div> -->
                        <!-- <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/e-commerce.png"
                                        alt="E-commerce">
                                    <p class="link"><a href="https://weekmate.in/ecommerce/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">E-commerce</p>
                            </div>
                        </div> -->
                        <!-- <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/hospitality.png"
                                        alt="Hospitality">
                                    <p class="link"><a href="https://weekmate.in/hospitality/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Hospitality</p>
                            </div>
                        </div> -->
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/bpo.png"
                                        alt="BPO">
                                    <p class="link"><a href="https://weekmate.in/bpo/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">BPO</p>
                            </div>
                        </div>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/pharmacy.png"
                                        alt="Pharmacy">
                                    <p class="link"><a href="https://weekmate.in/pharmacy/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Pharmacy</p>
                            </div>
                        </div>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/accounting.png"
                                        alt="Accounting">
                                    <p class="link"><a href="https://weekmate.in/accounting/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Accounting</p>
                            </div>
                        </div>
                        <!-- <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/kpo.png"
                                        alt="KPO">
                                    <p class="link"><a href="https://weekmate.in/kpo/"><i
                                                class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">KPO</p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $coreValueSec = get_field('core_value_sec'); ?>
<!-- <section class="ourvalues-sec">
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
                                            <img src="<?php echo $coreValueSec['block_img']['url']; ?>"
                                                alt="<?php echo $coreValueSec['block_img']['alt']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xxl-7 col-xl-7 col-lg-6 col-md-12 col-sm-12 ps-0">
                                        <div class="ourvalues-wrap ourvalues-column">
                                            <div class="title-block">
                                                <h2 class="title mb-0"><?php echo $coreValueSec['block_title']; ?></h2>
                                            </div>
                                            <p class="desc"><?php echo $coreValueSec['block_desc']; ?></p>
                                            <p class="block-cta mb-0"><a
                                                    href="<?php echo $coreValueSec['block_button']['button_url']; ?>"
                                                    class="theme-btn" 
                                                    ><?php echo $coreValueSec['block_button']['button_text']; ?></a>
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
</section> -->
<?php $partnerSec = get_field('partners_sec'); ?>
<section class="sectionCvr partners-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center">
                    <div class="title-block">
                        <h2 class="title"><?php echo $partnerSec['block_title']; ?></h2>
                    </div>
                    <p class="desc"><?php echo $partnerSec['block_desc']; ?></p>
                </div>
            </div>
        </div>
        <?php
			// Prevent undefined variable warnings
			$tax_query = array();
			$search_query = '';

			$args = array(
				'post_type'      => 'partner',
				'posts_per_page' => 5,
				'tax_query'      => $tax_query,
				's'              => $search_query,
			);

			$query = new WP_Query($args);
		?>
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="partners-wrapper">
                    <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php 
                        $partner_details = get_field('partner_post_list_detail'); 
                        if ($partner_details) :
                            $logo_section = $partner_details['logo_section'] ?? [];
                            $logo1    = $logo_section['logo_1'];
                            $heading  = $partner_details['heading'];
                            $location = $partner_details['location'];
                            $link     = get_permalink();
                        endif;
                    ?>
                    <?php if (!empty($partner_details)) : ?>
                    <div class="partner-block">
                        <div class="partner-logo">
                            <?php if (!empty($logo1)) : ?>
                            <a href="<?php echo esc_url($link); ?>">
                                <img src="<?php echo esc_url($logo1['url']); ?>"
                                    alt="<?php echo esc_attr($heading ?: get_the_title()); ?>">
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="partner-details">
                            <?php if (!empty($heading)) : ?>
                            <p class="name">
                                <a href="<?php echo esc_url($link); ?>">
                                    <?php echo esc_html($heading ?: get_the_title()); ?>
                                </a>
                            </p>
                            <?php endif; ?>
                            <?php if (!empty($location)) : ?>
                            <p class="location"><i class="fa-solid fa-location-dot"></i>
                                <?php echo esc_html($location); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
                <div class="text-center">
                    <a href="/partners" class="btn">More Partners</a>
                </div>
            </div>
        </div>


    </div>
</section>
<?php $faqSec = get_field('faq_section'); ?>
<section class="sectionCvr faq-section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9 col-sm-12">
                        <div class="title-block-wrapper title-block pb-0 mb-0">
                            <h2 class="title"><?php echo $faqSec['block_title']; ?></h2>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-12">
                        <div class="block-cta">
                            <p class="mb-0">
                                <?php if ( !empty($faqSec['block_button']['button_url']) ) : ?>
                                <a href="<?php echo esc_url($faqSec['block_button']['button_url']); ?>"
                                    class="theme-btn mt-0"
                                    <?php if ( isset($faqSec['block_button']['open_in_popup']) && $faqSec['block_button']['open_in_popup'] === 'yes' ) : ?>
                                    data-bs-toggle="modal" data-bs-target="#popupModal" <?php endif; ?>>
                                    <?php echo esc_html($faqSec['block_button']['button_text']); ?>
                                </a>
                                <?php endif; ?>
                            </p>
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
                                <?php $faq1Lists = $faqSec['faq_list_1']; 
								$faq1 = 0;
								foreach($faq1Lists as $faq1List) { $faq1++;  ?>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button <?php if($faq1 !== 1 ){ echo 'collapsed'; } ?>"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faqcollapse-<?php echo $faq1; ?>"
                                            aria-expanded="<?php if($faq1 == 3 ){ echo 'true'; } else{ echo "false"; } ?>"
                                            aria-controls="faqcollapse-<?php echo $faq1; ?>"><?php echo $faq1List['faq_que']; ?></button>
                                    </h3>
                                    <div id="faqcollapse-<?php echo $faq1; ?>"
                                        class="accordion-collapse collapse <?php if($faq1 == 1 ){ echo "show"; } ?>"
                                        data-bs-parent="#faqMain">
                                        <div class="accordion-body">
                                            <?php echo $faq1List['faq_ans']; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="accordion accordion-flush faqs-accordion">
                                <?php $faq2Lists = $faqSec['faq_list_2']; 
								$faq2 = 0;
								foreach($faq2Lists as $faq2List) { $faq2++;  ?>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq1collapse-<?php echo $faq2; ?>" aria-expanded="true"
                                            aria-controls="faq1collapse-<?php echo $faq2; ?>"><?php echo $faq2List['faq_que']; ?></button>
                                    </h3>
                                    <div id="faq1collapse-<?php echo $faq2; ?>" class="accordion-collapse collapse"
                                        data-bs-parent="#faqMain">
                                        <div class="accordion-body">
                                            <?php echo $faq2List['faq_ans']; ?>
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
<script src="https://cdn.jsdelivr.net/npm/gsap@3.0.2/dist/gsap.min.js"></script>
<script src="https://www.weekmate.in/wp-content/themes/weekmate/js/SplitText3.min.js"></script>
<script>
function getLineHeight() {
    const w = window.innerWidth;

    if (w >= 1200) return 150;
    if (w >= 900)  return 170;
    if (w >= 490)  return 123;
    return 95;
}

var vsOpts = {
    slides: document.querySelectorAll(".v-slide"),
    list: document.querySelector(".v-slides"),

    moveDuration: 1.5,   // faster slide movement
    textDuration: 1.5,   // ⚡ faster text animation
    holdDuration: 3.5,   // stay time

    lineHeight: getLineHeight()
};

var vSlide = gsap.timeline({
    paused: true,
    repeat: -1
});

vsOpts.slides.forEach(function(slide, i) {
    let label = "slide" + i;
    vSlide.add(label);

    /* SLIDE MOVE (FAST) */
    vSlide.to(vsOpts.list, {
        y: -i * vsOpts.lineHeight,
        duration: vsOpts.moveDuration,
        ease: "power2.out"
    }, label);

    /* TEXT ANIMATION (FASTER) */
    slide.querySelectorAll('.line').forEach(line => {
        let letters = new SplitText(line, { type: "chars" }).chars;
        vSlide.from(letters, {
            y: 40,
            duration: vsOpts.textDuration,
            stagger: 0.02,       // ⚡ faster stagger
            ease: "power2.out"
        }, label);
    });

    /* HOLD */
    vSlide.to({}, { duration: vsOpts.holdDuration });
});

vSlide.play();

/* Rebuild only if breakpoint height changes */
let lastHeight = vsOpts.lineHeight;
window.addEventListener('resize', () => {
    const newHeight = getLineHeight();
    if (newHeight !== lastHeight) {
        location.reload();
    }
});


</script>
<?php get_footer(); ?>