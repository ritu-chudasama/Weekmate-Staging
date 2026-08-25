<?php
/**
 * Section: Trusted By Our Clients
 * Layout: trusted_by_our_clients_section
 * Note: Uses existing theme CSS/JS (slick slider + fancybox)
 */

$trusted_clients   = get_field('trusted_by_our_clients_section', 'option');
$trusted_clients_3 = get_field('trusted_by_our_clients_3_section', 'option');

$heading       = $trusted_clients['heading'];
$descripation  = $trusted_clients['descripation'];
$image_gallery = $trusted_clients['image_gallery'];

$videoSec      = $trusted_clients_3['section_1'];
$prdctCountSec = $trusted_clients_3['section_2'];
$comPriceSec   = $trusted_clients_3['section_3'];

?>

<!-- Client Logo Slider -->
<section class="sectionCvr client-sec">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper title-block text-center">
                    <h2 class="title text-none"><?php echo esc_html($heading); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-6 col-xl-8 col-lg-8 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center">
                    <p class="desc"><?php echo esc_html($descripation); ?></p>
                </div>
            </div>
        </div>
        <div class="row mt-1 mt-lg-4">
            <div class="col-xxl-11 col-xl-11 col-lg-12 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="client-wrapper">
                    <div id="client-slider" class="client-slider">
                        <?php if ( ! empty($image_gallery) ) :
                            foreach ( $image_gallery as $clientList ) : ?>
                        <div class="client-logo">
                            <img src="<?php echo esc_url($clientList['url']); ?>"
                                alt="<?php echo esc_attr($clientList['alt']); ?>">
                        </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video + Count + Compact Price -->
<section class="sectionCvr product-info-sec pt-0">
    <div class="container">
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="product-info-wrapper">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7 col-sm-12 product-info-video">
                            <div class="product-info-block product-video-block">
                                <div class="title-block-wrapper title-block">
                                    <h3 class="title"><?php echo esc_html($videoSec['title']); ?></h3>
                                    <p class="desc"><?php echo esc_html($videoSec['description']); ?></p>
                                </div>
                                <div class="video-list-wrapper">
                                    <?php $current_slug = get_post_field('post_name', get_queried_object_id()); ?>
                                    <script>window.wmCurrentSlug = <?php echo wp_json_encode($current_slug); ?>;</script>
                                    <div id="product-video-slider" class="product-video-slider">
                                        <?php
                                        $VideosLists = $videoSec['videos'];

                                        // Map link title -> actual page slug
                                        $title_map = [
                                            'HRMS'     => 'hrms',
                                            'TaskHub'  => 'taskhub',
                                            'eConnect' => 'e-connect',
                                            'eCRM'     => 'e-crm',
                                        ];

                                        if ( ! empty($VideosLists) ) :
                                            foreach ( $VideosLists as $VideosList ) :
                                                $Videos  = $VideosList['video'];
                                                $link_id = $Videos['url'] ?? '';
                                                if ( empty($link_id) ) continue;

                                                // Robust ID extraction (watch?v=, youtu.be, embed, extra params)
                                                $video_id = '';
                                                if ( preg_match('%(?:youtube\.com/(?:watch\?v=|embed/)|youtu\.be/)([^&?/\s]{11})%', $link_id, $m) ) {
                                                    $video_id = $m[1];
                                                }
                                                if ( empty($video_id) ) continue;

                                                // $videothumbnail = "https://img.youtube.com/vi/{$video_id}/mqdefault.jpg";
                                                $max_thumbnail = "https://img.youtube.com/vi/".$video_id."/maxresdefault.jpg";
                                                $default_thumbnail = "https://img.youtube.com/vi/".$video_id."/mqdefault.jpg";
                                                $videothumbnail = @getimagesize($max_thumbnail) ? $max_thumbnail : $default_thumbnail;
                                                $Videotitle     = $Videos['title'] ?? '';                                  // HRMS / TaskHub / eConnect
                                                $slide_slug     = $title_map[$Videotitle] ?? sanitize_title($Videotitle);  // hrms / taskhub / e-connect
                                        ?>
                                            <div class="rev_slide" data-title="<?php echo esc_attr($slide_slug); ?>">
                                                <div class="lightbox-video-inner">
                                                    <a href="<?php echo esc_url($link_id); ?>" data-fancybox="product-video">
                                                        <div class="video-img">
                                                            <img src="<?php echo esc_url($videothumbnail); ?>" width="100%"
                                                                alt="<?php echo esc_attr($Videotitle); ?>"
                                                                onerror="this.src='https://img.youtube.com/vi/<?php echo esc_js($video_id); ?>/hqdefault.jpg'">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5 col-sm-12">
                            <div class="product-info-block product-count-block">
                                <div class="collage-img">
                                    <?php if ( ! empty($prdctCountSec['images']) ) :
                                        foreach ( $prdctCountSec['images'] as $image ) : ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>">
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                                <div class="count-block">
                                    <div class="count"><?php echo wp_kses_post($prdctCountSec['title']); ?></div>
                                    <div class="desc"><?php echo wp_kses_post($prdctCountSec['description']); ?></div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="compact-price-wrap">
                                <div class="row align-items-end">
                                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7 col-sm-12">
                                        <div class="compact-price-block">
                                            <div class="title-block">
                                                <h2 class="title text-none"><?php echo esc_html($comPriceSec['title']); ?></h2>
                                            </div>
                                            <p class="desc"><?php echo esc_html($comPriceSec['descripation']); ?></p>
                                            <p class="block-cta mb-0">
                                                <a href="<?php echo esc_url($comPriceSec['button']['url']); ?>"
                                                    class="theme-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#popupModal">
                                                    <?php echo esc_html($comPriceSec['button']['title']); ?>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5 col-sm-12">
                                        <?php if ( ! empty($comPriceSec['image']['url']) ) : ?>
                                            <img src="<?php echo esc_url($comPriceSec['image']['url']); ?>"
                                                alt="<?php echo esc_attr($comPriceSec['image']['alt']); ?>">
                                        <?php endif; ?>
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