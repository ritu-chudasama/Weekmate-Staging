<?php
/**
 * Template Name: Become Partner
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */
get_header();
$banner_section = get_field('banner_section');
$contact_form = get_field('contact_form');
$setup_process = get_field('setup_process');
$faq_section = get_field('faq_section');
?>
<section class="sectionCvr home-banner-sec advtool-sec contact-us-banner become-partner-sec">
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
                    <h2 class="fw-bold mb-3 h1">
                        <?php echo esc_html($banner_section['heading']); ?>
                    </h2>
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
            <?php if( !empty($banner_section['banner_section_part_2']) ): ?>
            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                <div class="home-banner-tabs">
                    <div class="row">
                        <?php foreach( $banner_section['banner_section_part_2'] as $item ): 
                    $logo   = $item['logo'];
                    $number = $item['numbers'];
                    $badges   = $item['badges'];
                    $text   = $item['text'];

                ?>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="banner-card">
                                <?php if( !empty($badges) ): ?>
                                    <span class="heading-bold card-badges"><?php echo esc_html($badges); ?></span>
                                <?php endif; ?>
                                <?php if( !empty($logo) ): ?>
                                <div class="banner-icon">
                                    <img src="<?php echo esc_url($logo['url']); ?>"
                                        alt="<?php echo esc_attr($logo['alt']); ?>" />
                                </div>
                                <?php endif; ?>
                                <div class="banner-card-content">
                                    <?php if( !empty($number) ): ?>
                                    <h3 class="heading-bold card-count"><?php echo esc_html($number); ?></h3>
                                    <?php endif; ?>
                                    <?php if( !empty($text) ): ?>
                                    <p><?php echo esc_html($text); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
<section class="become-partner setup-process sectionCvr features-section">
    <div class="container">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center section-header small-section-header">
                        <?php if (!empty($setup_process['heading'])) : ?>
                        <h2 class="features-section-title setup-process-title h1 heading-bold">
                            <?php echo esc_html($setup_process['heading']); ?>
                        </h2>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($setup_process['description'])) : ?>
                        <div class="rte ps-lg-5">
                            <p><?php echo esc_html($setup_process['description']); ?></p>
                        </div>
                   <?php endif; ?>
                </div>
           
            </div>

        <div class="row gy-3">
            <?php
            $colors = ['sky-blue-bg-clr', 'light-ivory-bg-clr', 'light-mint-bg-clr'];
            if (!empty($setup_process['setup_process_repeater'])) :
                foreach ($setup_process['setup_process_repeater'] as $key => $process) :
                    $colorClass = $colors[$key % count($colors)];
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="step-wrapper <?php echo esc_attr($colorClass); ?>">
                    <div class="step-icon">
                        <?php if (!empty($process['image'])) : ?>
                        <img src="<?php echo esc_url($process['image']['url']); ?>" width="98" height="98"
                            alt="<?php echo esc_attr($process['image']['alt']); ?>" />
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($process['title'])) : ?>
                    <h3 class="h3 heading-bold"><?php echo esc_html($process['title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($process['description'])) : ?>
                    <div class="rte">
                        <p><?php echo esc_html($process['description']); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
<section class="sectionCvr">
    <div class="container">
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="contact-info-wrapper">
                    <div class="row align-items-center">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-content">
                                <?php if ($contact_form) : ?>
                                <div class="product-badges">
                                    <?php if (!empty($contact_form['logo'])) : ?>
                                    <img src="<?php echo esc_url($contact_form['logo']['url']); ?>" alt="WeekMate Logo"
                                        class="img-fluid">
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($contact_form['heading'])) : ?>
                                <h2 class="form-title h1 heading-bold"><?php echo esc_html($contact_form['heading']); ?>
                                </h2>
                                <?php endif; ?>

                                <?php if (!empty($contact_form['sub_heading'])) : ?>
                                <p class="form-subtitle"><?php echo esc_html($contact_form['sub_heading']); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($contact_form['contacts'])) : ?>
                                <ul class="social-icon-wrapper">
                                    <?php foreach ($contact_form['contacts'] as $row) : 
                                                $logo  = $row['logo'];
                                                $value = $row['value'];

                                                // Detect link type based on value format
                                                if ( is_email( $value ) ) {
                                                    $href = 'mailto:' . antispambot( $value );
                                                } elseif ( preg_match('/^[+0-9\s\-()]{7,}$/', $value) ) {
                                                    $tel  = preg_replace('/[^0-9+]/', '', $value);
                                                    $href = 'tel:' . $tel;
                                                } else {
                                                    $href = '';
                                                }
                                            ?>
                                    <li>
                                        <?php if ($href) : ?>
                                        <a href="<?php echo esc_attr($href); ?>">
                                        <?php endif; ?>
                                            <?php if ($logo) : ?>
                                            <img src="<?php echo esc_url($logo['url']); ?>"
                                                alt="<?php echo esc_attr($value); ?>" class="icon">
                                            <?php endif; ?>
                                            <span class="social-text"><?php echo esc_html($value); ?></span>
                                        <?php if ($href) : ?>
                                        </a>
                                        <?php endif; ?>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>

                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="contact-form-wrapper">
                                <div class="contact-form-inner">
                                    <div class="contact-title">
                                        <h2 class="heading-bold">Fill Out the Form</h2>
                                    </div>
                                    <?php echo do_shortcode( '[contact-form-7 id="f169d39" title="Become Partner form"]');?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $partnerSec = get_field('partner_section', 'options'); ?>
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
				'posts_per_page' => -1,
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
            </div>
        </div>


    </div>
</section>
<?php 
$testimonialSec = get_field('testimonials_section_copy', 'option'); 
if ($testimonialSec) : 
    // Define your color classes (you can edit these to match your CSS)
    $colorClasses = array('color1', 'color2', 'color3', 'color4');
?>
<section class="sectionCvr testimonials-sec pt-0">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-12 me-auto ms-auto">
                <div class="title-block-wrapper text-center title-block">
                    <?php if (!empty($testimonialSec['heading'])) : ?>
                    <h2 class="title"><?php echo esc_html($testimonialSec['heading']); ?></h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid g-0">
        <div class="row">
            <div class="col-xxl-11 col-xl-12 col-lg-12 col-md-12 col-sm-12 ms-auto">
                <div class="testimonials-wrapper">
                    <div id="testimonials-slider" class="testimonials-slider">
                        <?php 
                        // Define color classes before loop
                        $colorClasses = [
                            "light-mint-bg-clr",
                            "soft-peach-bg-clr",
                            "light-ivory-bg-clr",
                            "sky-blue-bg-clr",
                            "lavender-mist-bg-clr",
                            "off-white-bg-clr",
                            "light-lavender-bg-clr"
                        ];

                        $testiLists = $testimonialSec['testimonials_repeater'];
                        if ($testiLists) {
                            $testi = 0;
                            foreach ($testiLists as $testiList) {
                                // pick a class based on index
                                $testirandomClass = $colorClasses[$testi % count($colorClasses)];
                        ?>
                        <div class="testimonials-item">
                            <div class="testimonials-block <?php echo esc_attr($testirandomClass); ?>">
                                <div class="testi-img-play">
                                    <p class="testi-img">
                                        <?php if (!empty($testiList['client_image'])) : ?>
                                        <img src="<?php echo esc_url($testiList['client_image']['url']); ?>"
                                            alt="<?php echo esc_attr($testiList['client_image']['alt']); ?>">
                                        <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/test-img-avatar.png"
                                            alt="testimonial">
                                        <?php endif; ?>
                                    </p>
                                    <?php if (!empty($testiList['video'])) : ?>
                                    <p class="play-btn">
                                        <a href="<?php echo esc_url($testiList['video']); ?>" target="_blank">
                                            <i class="fa fa-play"></i> Play
                                        </a>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <div class="testi-content">
                                    <p><?php echo esc_html($testiList['content']); ?></p>
                                </div>
                                <div class="testi-author">
                                    <p class="author"><?php echo esc_html($testiList['client_name']); ?></p>
                                    <p class="desig"><?php echo esc_html($testiList['designation']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php 
                                $testi++; 
                            } 
                        } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<?php endif; ?>




<?php
get_footer();