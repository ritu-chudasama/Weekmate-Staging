<?php
/**
 * The template for displaying Case Studies archive
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

get_header();?>


<?php $partner_post_type_section = get_field('partner_post_type_section', 'option'); 

?>
<?php if ($partner_post_type_section) : ?>
<section class="sectionCvr pt-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12 col-sm-12">
                <div class="banner-wrap">

                    <!-- Rating Logos -->
                    <?php if (!empty($partner_post_type_section['rating_logo'])) : ?>
                    <div class="banner-rating">
                        <ul class="rating-block">
                            <?php foreach ($partner_post_type_section['rating_logo'] as $logo) : ?>
                            <li>
                                <?php if (!empty($logo['image'])) : ?>
                                <img src="<?php echo esc_url($logo['image']['url']); ?>"
                                    alt="<?php echo esc_attr($logo['image']['alt']); ?>" class="img-fluid"
                                    style="max-height: 30px;">
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- Banner Text -->
                    <div class="banner-details">
                        <div class="banner-title">
                            <?php if (!empty($partner_post_type_section['heading'])) : ?>
                            <h1 class="heading-bold"><?php echo esc_html($partner_post_type_section['heading']); ?></h1>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($partner_post_type_section['sub_heading'])) : ?>
                        <p class="banner-desc"><?php echo esc_html($partner_post_type_section['sub_heading']); ?></p>
                        <?php endif; ?>

                        <!-- CTA Buttons -->
                        <div class="btn-wrapper post-partner">
                            <div class="banner-cta">
                                <?php if (!empty($partner_post_type_section['button'])) : ?>
                                <a href="<?php echo esc_url($partner_post_type_section['button']['url']); ?>"
                                    class="btn-transperent"
                                    <?php echo $partner_post_type_section['button']['target'] ? 'target="_blank"' : ''; ?>>
                                    <?php echo esc_html($partner_post_type_section['button']['title']); ?>
                                </a>
                                <?php endif; ?>

                                <?php if (!empty($partner_post_type_section['button_2'])) : ?>
                                <a href="<?php echo esc_url($partner_post_type_section['button_2']['url']); ?>"
                                    class="theme-btn"
                                    <?php echo $partner_post_type_section['button_2']['target'] ? 'target="_blank"' : ''; ?>>
                                    <?php echo esc_html($partner_post_type_section['button_2']['title']); ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Banner Image -->
            <div class="col-xxl-7 col-xl-7 col-lg-12 col-md-12 col-sm-12">
                <div class="image-wrapper">
                    <?php if (!empty($partner_post_type_section['image'])) : ?>
                    <img src="<?php echo esc_url($partner_post_type_section['image']['url']); ?>"
                        alt="<?php echo esc_attr($partner_post_type_section['image']['alt']); ?>" width="100%">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<section class="partners-card-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="facet-filter">
                    <?php
                    $taxonomy = get_taxonomy('country');
                    if ($taxonomy) {
                    ?>
                    <div class="facet-filter-title">
                        <h4><?php echo esc_html($taxonomy->labels->singular_name); ?></h4>
                    </div>
                    <!-- <div class="filter-seacrch-wrapper">
                        <input type="search" value="" class="search-input">
                        <button class="search-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M12.9981 6.49905C12.9981 7.93321 12.5325 9.25802 11.7483 10.3329L15.7039 14.2917C16.0945 14.6822 16.0945 15.3165 15.7039 15.7071C15.3134 16.0976 14.6791 16.0976 14.2885 15.7071L10.3329 11.7483C9.25802 12.5325 7.93321 12.9981 6.49905 12.9981C2.90895 12.9981 0 10.0891 0 6.49905C0 2.90895 2.90895 0 6.49905 0C10.0891 0 12.9981 2.90895 12.9981 6.49905ZM6.49905 10.9984C8.98306 10.9984 10.9984 8.98306 10.9984 6.49905C10.9984 4.01504 8.98306 1.99971 6.49905 1.99971C4.01504 1.99971 1.99971 4.01504 1.99971 6.49905C1.99971 8.98306 4.01504 10.9984 6.49905 10.9984Z" fill="#C9C9C9"></path>
                            </svg>
                        </button>
                    </div> -->
                    <div class="filter-list">
                        <ul>
                            <?php
                            $countries = get_terms( array(
                                'taxonomy' => 'country',
                                'hide_empty' => true,
                            ) );
                            if ( ! empty( $countries ) && ! is_wp_error( $countries ) ) {
                                foreach ( $countries as $country ) {
                            ?>
                                <li class="tag">
                                    <label class="tag-checkbox-wrapper">
                                        <input type="checkbox" class="tag-input" name="country" value="<?php echo esc_attr($country->slug); ?>">
                                        <span class="tag-checkbox"></span>
                                        <span class="tag-text"><?php echo esc_html($country->name); ?></span>
                                    </label>
                                </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="partners-card-main-wrapper">
                    <div class="partners-header-wrapper">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h3 class="heading-bold mb-0">Our Partners</h3>
                            </div>
                            <div class="col-lg-4">
                                <!-- <div class="filter-seacrch-wrapper">
                                    <input type="search" value="" class="search-input" placeholder="Search by name...">
                                    <button class="search-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M12.9981 6.49905C12.9981 7.93321 12.5325 9.25802 11.7483 10.3329L15.7039 14.2917C16.0945 14.6822 16.0945 15.3165 15.7039 15.7071C15.3134 16.0976 14.6791 16.0976 14.2885 15.7071L10.3329 11.7483C9.25802 12.5325 7.93321 12.9981 6.49905 12.9981C2.90895 12.9981 0 10.0891 0 6.49905C0 2.90895 2.90895 0 6.49905 0C10.0891 0 12.9981 2.90895 12.9981 6.49905ZM6.49905 10.9984C8.98306 10.9984 10.9984 8.98306 10.9984 6.49905C10.9984 4.01504 8.98306 1.99971 6.49905 1.99971C4.01504 1.99971 1.99971 4.01504 1.99971 6.49905C1.99971 8.98306 4.01504 10.9984 6.49905 10.9984Z" fill="#C9C9C9"></path>
                                        </svg>
                                    </button>
                                </div> -->
                                </div>
                        </div>
                    </div>
                    <div class="row" id="partners-container">
                        <?php 
                        $args = array(
                            'post_type'      => 'partner',
                            'posts_per_page' => -1,
                            'tax_query'      => $tax_query,
                            's'              => $search_query,
                        );
                        $query = new WP_Query($args);
                        if ($query->have_posts()) {
                            partner_query_html($query);
                            wp_reset_postdata();
                        } else {
                            echo '<p class="no-results-message col-12">No partners found for your selected filters.</p>';
                        }
                        //$filter_partners = filter_partners();
                        //$filter_partners = json_decode($filter_partners);
                        //echo $filter_partners['html'];
                        ?>
                    </div>
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
<section class="sectionCvr testimonials-sec">
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
<?php get_footer(); ?>