<?php
/**
 * Template Name: Industrial Page
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */
//echo get_page_link(351);
//echo get_template_directory_uri();
get_header(); 
$banner_section = get_field('banner_section');
$retail_teams = get_field('retail_teams');
$trusted_by_our_clients_section = get_field('trusted_by_our_clients_section','option');
$trusted_by_our_clients_3_section = get_field('trusted_by_our_clients_3_section','option');
$videoSec = $trusted_by_our_clients_3_section['section_1'];
$prdctCountSec = $trusted_by_our_clients_3_section['section_2'];
$comPriceSec = $trusted_by_our_clients_3_section['section_3'];
$our_core_value = get_field('our_core_value','option');
?>
<section class="sectionCvr home-banner-sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="banner-wrap">
                    <div class="banner-rating">
                        <ul class="rating-block">
                        <?php if( !empty($banner_section['rating_logo']) ): ?>
                            <?php foreach( $banner_section['rating_logo'] as $logo ): ?>
                                 <li>
                          
                                <?php if( !empty($logo['image']['url']) ): ?>
                                <img src="<?php echo esc_url($logo['image']['url']); ?>"
                                    alt="<?php echo esc_attr($logo['image']['alt']); ?>" class="img-fluid"
                                    style="max-height: 30px;">
                                <?php endif; ?>
                             </li>
                            <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <!-- Heading -->
                    <?php if( !empty($banner_section['heading']) ): ?>
                    <h1 class="fw-bold mb-3">
                        <?php echo esc_html($banner_section['heading']); ?>
                    </h1>
                    <?php endif; ?>

                    <!-- Subheading -->
                    <?php if( !empty($banner_section['sub_heading']) ): ?>
                    <p class="text-muted mb-4">
                        <?php echo esc_html($banner_section['sub_heading']); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Button -->
                    <?php if( !empty($banner_section['button']) ): ?>
                    <a href="<?php echo esc_url($banner_section['button']['url']); ?>" class="btn btn-primary">
                        <?php echo esc_html($banner_section['button']['title']); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                <?php if( !empty($banner_section['banner_image']['url']) ): ?>
                <img src="<?php echo esc_url($banner_section['banner_image']['url']); ?>"
                    alt="<?php echo esc_attr($banner_section['banner_image']['alt']); ?>" class="img-fluid">
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
<?php $certiSec = get_field('certificate_sections'); ?>
<section class="certificate-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="certificate-wrapper">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <div class="certificate-title">
                                <img src="<?php echo $certiSec['logo']['url']; ?>"
                                    alt="<?php echo $certiSec['logo']['alt']; ?>">
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
<section class="setup-process sectionCvr">
    <div class="container">
        <div class="small-section-header text-center section-header retail-header">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <?php
                        if(!empty($retail_teams['heading'])) {
                            echo '<h2 class="setup-process-title h1 heading-bold">' . esc_html($retail_teams['heading']) . '</h2>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
			$colors = ['sky-blue-bg-clr', 'light-ivory-bg-clr', 'light-mint-bg-clr'];
			if(!empty($retail_teams['retail_cards'])) {
				foreach($retail_teams['retail_cards'] as $key => $process) {
					?>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 process-item">
                <div class="process-item-inner">
                    <div class=" <?php echo $colors[$key]?>">
                        <h3 class="h3 heading-bold"><?php echo $process['title'];?></h3>
                        <div class="rte">
                            <p><?php echo $process['text'];?></p>
                        </div>
						  <p><?php echo $process['detail'];?></p>
                    </div>
                </div>
            </div>
            <?php
						}
					}
				?>


        </div>
</section>
<?php $retail_problems_left_right_section = get_field('retail_problems_left_right_section'); ?>
<section class="retail-section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 retail-image">
                <div class="retail-item">
                  <?php if( !empty($retail_problems_left_right_section['left_image']['url']) ): ?>
                <img src="<?php echo esc_url($retail_problems_left_right_section['left_image']['url']); ?>"
                    alt="<?php echo esc_attr($retail_problems_left_right_section['left_image']['alt']); ?>" class="img-fluid">
                <?php endif; ?>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 retail-content">
                <div class="retail-item">
                    <div class="content-wrapper">
						 <?php if( !empty($retail_problems_left_right_section['title']) ): ?>
						  <h2 class="h1 retail-title">
							<?php echo esc_html($retail_problems_left_right_section['title']); ?>
						</h2>
						<?php endif; ?>
						 <?php if( !empty($retail_problems_left_right_section['description']) ): ?>
							<p>
								<?php echo esc_html($retail_problems_left_right_section['description']); ?>
							</p>
						<?php endif; ?>	
                        <div class="btn-wrapper">
							 <?php if( !empty($retail_problems_left_right_section['button']) ): ?>
								<a href="<?php echo esc_url($retail_problems_left_right_section['button']['url']); ?>" class="btn white-btn">
									<?php echo esc_html($retail_problems_left_right_section['button']['title']); ?>
								</a>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sectionCvr client-sec">
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
<?php $indusSec = get_field('industries_section');

?>
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
                    <?php if ( ! empty( $indusSec['block_button']['button_url'] ) && ! empty( $indusSec['block_button']['button_text'] ) ) : ?>
                        <p class="block-cta mb-0">
                            <a href="<?php echo esc_url( $indusSec['block_button']['button_url'] ); ?>" class="theme-btn">
                                <?php echo esc_html( $indusSec['block_button']['button_text'] ); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php global $post;
                    $current_slug = $post->post_name; // current page slug?>
             <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12 col-sm-12">
                <div class="industries-list-wrap">
                    <div id="industries-slider" class="industries-slider">
                        
                        <?php if ($current_slug !== 'software-it') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/software-it.png" alt="Software & IT Services">
                                    <p class="link"><a href="/software-it/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Software & IT Services</p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($current_slug !== 'manufacturing') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/manufacturing.png" alt="Manufacturing">
                                    <p class="link"><a href="/manufacturing/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Manufacturing</p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($current_slug !== 'bpo') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/bpo.png" alt="BPO">
                                    <p class="link"><a href="/bpo/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">BPO</p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($current_slug !== 'pharmacy') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/pharmacy.png" alt="Pharmacy">
                                    <p class="link"><a href="/pharmacy/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Pharmacy</p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($current_slug !== 'accounting') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/accounting.png" alt="Accounting">
                                    <p class="link"><a href="/accounting/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Accounting</p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- <?php if ($current_slug !== 'financial') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/financial.png" alt="Financial">
                                    <p class="link"><a href="/financial/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Financial</p>
                            </div>
                        </div>
                        <?php endif; ?> -->

                        <!-- <?php if ($current_slug !== 'ecommerce') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/e-commerce.png" alt="E-commerce">
                                    <p class="link"><a href="/ecommerce/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">E-commerce</p>
                            </div>
                        </div>
                        <?php endif; ?> -->

                        <!-- <?php if ($current_slug !== 'hospitality') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/hospitality.png" alt="Hospitality">
                                    <p class="link"><a href="/hospitality/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">Hospitality</p>
                            </div>
                        </div>
                        <?php endif; ?> -->

                        <!-- <?php if ($current_slug !== 'kpo') : ?>
                        <div class="industry-item">
                            <div class="industry-block">
                                <div class="industry-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/kpo.png" alt="KPO">
                                    <p class="link"><a href="/kpo/"><i class="fa-solid fa-chevron-right"></i></a></p>
                                </div>
                                <p class="industry-title">KPO</p>
                            </div>
                        </div>
                        <?php endif; ?> -->

                        

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
                                                parse_str(parse_url($link_id, PHP_URL_QUERY), $params);
                                                $video_id = $params['v'] ?? '';
                                                // $videothumbnail="https://img.youtube.com/vi/".$video_id."/mqdefault.jpg";
                                                $max_thumbnail = "https://img.youtube.com/vi/".$video_id."/maxresdefault.jpg";
                                                $default_thumbnail = "https://img.youtube.com/vi/".$video_id."/mqdefault.jpg";
                                                $videothumbnail = @getimagesize($max_thumbnail) ? $max_thumbnail : $default_thumbnail; 
                                                $Videotitle = '';
                                                $cache_key = 'yt_title_' . $video_id;
                                                $cached = get_transient($cache_key);
                                                if ($cached !== false) {
                                                    $Videotitle = $cached;
                                                } else {
                                                    $oembed_url = "https://www.youtube.com/oembed?url=" . urlencode("https://www.youtube.com/watch?v=$video_id") . "&format=json";
                                                    $response = wp_remote_get($oembed_url, ['timeout' => 10]);
                                                    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                                                        $data = json_decode(wp_remote_retrieve_body($response));
                                                        $Videotitle = $data->title ?? '';
                                                        set_transient($cache_key, $Videotitle, 7 * DAY_IN_SECONDS);
                                                    }
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
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="ourvalues-sec pdp-ourvalues">
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
                                                <h2 class="title mb-0"><?php echo $our_core_value['heading']; ?></h2>
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
</section> -->
<?php $partnerSec = get_field('partner_section', 'options'); ?>
<section class="sectionCvr partners-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center">
                    <div class="title-block">
                        <h2 class="title"><?php echo $partnerSec['heading']; ?></h2>
                    </div>
                    <p class="desc"><?php echo $partnerSec['description']; ?></p>
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
<?php $casestudySec = get_field('case_study_section'); ?>
<section class="sectionCvr casestudy-sec">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12 col-sm-12">
                <div class="casestudy-block-wrap">
                    <div class="title-block">
                        <h2 class="title mb-0"><?php echo $casestudySec['block_title']; ?></h2>
                    </div>
                    <p class="desc"><?php echo $casestudySec['block_desc']; ?></p>
                        <?php if ( ! empty( $casestudySec['block_button']['button_url'] ) && ! empty( $casestudySec['block_button']['button_text'] ) ) : ?>
                            <p class="block-cta mb-0">
                                <a href="<?php echo esc_url( $casestudySec['block_button']['button_url'] ); ?>" class="theme-btn">
                                    <?php echo esc_html( $casestudySec['block_button']['button_text'] ); ?>
                                </a>
                        </p>
                    <?php endif; ?>
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
<?php $faqSec = get_field('faq_section'); ?>
<section class="sectionCvr faq-section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9 col-sm-12">
                        <div class="title-block-wrapper title-block pb-0 mb-0">
                            <h2 class="title"><?php echo $faqSec['heading']; ?></h2>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-12">
						<div class="block-cta">
							<?php if ( ! empty( $faqSec['button']['url'] ) && ! empty( $faqSec['button']['title'] ) ) : ?>
                                <p class="mb-0">
                                    <a href="<?php echo esc_url( $faqSec['button']['url'] ); ?>" 
                                    class="theme-btn mt-0" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#popupModal">
                                        <?php echo esc_html( $faqSec['button']['title'] ); ?>
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
                                <?php $faq1Lists = $faqSec['faq_repeater']; 
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
                                <?php $faq2Lists = $faqSec['faq_repeater_2']; 
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
</section>

<?php
get_footer();