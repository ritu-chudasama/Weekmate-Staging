<?php
/**
 * The template for displaying Case Studies archive
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

get_header();

  $colorClasses = [
     "lavender-mist-bg-clr",
     "light-ivory-bg-clr",
     "soft-peach-bg-clr",
      "light-mint-bg-clr",
      "sky-blue-bg-clr",
      "off-white-bg-clr",
      "light-lavender-bg-clr"
  ];

// ✅ If you want separate hero fields for Case Studies
$case_study_page = get_field('case_study_page', 'option'); 
$trusted_by_our_clients_section = get_field('trusted_by_our_clients_section','option');
?>

<?php if ( $case_study_page ) : ?>
<section class="case-study-hero-sec advtool-sec sectionCvr">
    <div class="container">
        <div class="row align-items-center">

            <!-- Left Column -->
            <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12 col-sm-12">
                <div class="banner-wrap">
                    <!-- Rating Logos -->
                    <?php if ( !empty($case_study_page['rating_logo']) ) : ?>
                    <div class="banner-rating">
                        <ul class="rating-block">
                            <?php foreach( $case_study_page['rating_logo'] as $logo ) : ?>
                            <li>
                                <?php if ( !empty($logo['image']['url']) ) : ?>
                                <img src="<?php echo esc_url($logo['image']['url']); ?>"
                                    alt="<?php echo esc_attr($logo['image']['alt']); ?>" class="me-3"
                                    style="max-height:30px;">
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- Heading -->
                    <?php if ( !empty($case_study_page['heading']) ) : ?>
                    <h1 class="case-study-hero-title"><?php echo esc_html($case_study_page['heading']); ?></h1>
                    <?php endif; ?>

                    <!-- Description -->
                    <?php if ( !empty($case_study_page['description']) ) : ?>
                    <p class="case-study-hero-desc"><?php echo esc_html($case_study_page['description']); ?></p>
                    <?php endif; ?>

                    <!-- Button -->
                    <?php if ( !empty($case_study_page['button']) ) : ?>
                    <a href="<?php echo esc_url($case_study_page['button']['url']); ?>" class="btn btn-primary">
                        <?php echo esc_html($case_study_page['button']['title']); ?>
                    </a>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-7 col-md-12 text-center">
                <?php if ( !empty($case_study_page['banner_image']['url']) ) : ?>
                <img src="<?php echo esc_url($case_study_page['banner_image']['url']); ?>"
                    alt="<?php echo esc_attr($case_study_page['banner_image']['alt']); ?>"
                    class="img-fluid case-study-hero-image">
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
<?php endif; ?>

<!-- 📑 Case Studies Listing -->
<section class="case-study-listing sectionCvr">
    <div class="container">
        <div class="case-study-header">
            <div class="row align-items-center ">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="title-block-wrapper title-block">
                        <h2 class="case-study-heading title h1">Our Case Studies</h2>
                    </div>
                </div>
                <!-- 🔎 Search + Filter -->
                <!-- <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="d-flex  gap-2 justify-content-end case-study-filter-wrapper">
                  
                    <div class="case-study-search">
                        <form method="get" action="<?php // echo esc_url(home_url('/')); ?>">
                            <input type="hidden" name="post_type" value="case_study">
                            <input type="text" name="s" class="form-control" placeholder="Search case studies..."
                                value="<?php // echo get_search_query(); ?>">
                        </form>
                    </div>
                   
                    <div class="case-study-filter">
                        <form method="get" action="">
                            <select name="case_category" class="form-select" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <?php
                                        // $terms = get_terms(array(
                                        // 'taxonomy'   => 'case_study_category', 
                                        // 'hide_empty' => true,
                                        // ));
                                        // if (!empty($terms) && !is_wp_error($terms)) {
                                        // foreach ($terms as $term) {
                                        //     $selected = (isset($_GET['case_category']) && $_GET['case_category'] == $term->slug) ? 'selected' : '';
                                        //     echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                                        // }
                                        // }
                                        ?>
                            </select>
                        </form>
                    </div>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- 📑 Case Study Grid -->
        <div class="row case-study-grid">

            <?php
      // ✅ Build Query Args
      $args = array(
        'post_type'      => 'case_study',
        'posts_per_page' => 9,
        'paged'          => get_query_var('paged') ? get_query_var('paged') : 1
      );

      // ✅ Search filter
      if (!empty($_GET['s'])) {
        $args['s'] = sanitize_text_field($_GET['s']);
      }

      // ✅ Category filter
      if (!empty($_GET['case_category'])) {
        $args['tax_query'] = array(
          array(
            'taxonomy' => 'case_study_category', // ✅ custom taxonomy for case studies
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['case_category']),
          ),
        );
      }

      $case_query = new WP_Query($args);

      if ($case_query->have_posts()) :
            $i = 0; // counter
        while ($case_query->have_posts()) : $case_query->the_post();
            $classIndex   = $i % count($colorClasses);
              $currentClass = $colorClasses[$classIndex];

          // ✅ Reading Time
          $content     = get_post_field('post_content', get_the_ID());
          $word_count  = str_word_count(wp_strip_all_tags($content));
          $reading_min = ceil($word_count / 200); // 200 words per minute
          ?>

            <div class="col-md-4">
                <div class="step-wrapper <?php echo esc_attr($currentClass); ?>">



                    <div class="case-study-card-content">
                        <h2 class="h3 heading-bold"><?php the_title(); ?></h2>

                        <!-- ⏱ Reading Time -->
                        <span class="case-study-reading-time">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23"
                                    fill="none">
                                    <path
                                        d="M18.9266 3.7218C16.849 1.64421 14.0866 0.5 11.1484 0.5C8.21023 0.5 5.4479 1.64421 3.37023 3.7218C1.29265 5.79947 0.148438 8.5618 0.148438 11.5C0.148438 14.4382 1.29265 17.2005 3.37023 19.2782C5.4479 21.3558 8.21023 22.5 11.1484 22.5C14.0866 22.5 16.849 21.3558 18.9266 19.2782C21.0042 17.2005 22.1484 14.4382 22.1484 11.5C22.1484 8.5618 21.0042 5.79947 18.9266 3.7218ZM18.4709 18.8224C16.515 20.7783 13.9145 21.8555 11.1484 21.8555C8.38237 21.8555 5.7819 20.7783 3.826 18.8224C1.87011 16.8665 0.792969 14.2661 0.792969 11.5C0.792969 8.73393 1.87011 6.13346 3.826 4.17757C5.7819 2.22167 8.38237 1.14453 11.1484 1.14453C13.9145 1.14453 16.515 2.22167 18.4709 4.17757C20.4268 6.13346 21.5039 8.73393 21.5039 11.5C21.5039 14.2661 20.4268 16.8665 18.4709 18.8224Z"
                                        fill="#383838" />
                                    <path
                                        d="M11.1504 3.94434C10.9724 3.94434 10.8281 4.08862 10.8281 4.2666V5.64435C10.8281 5.82233 10.9724 5.96662 11.1504 5.96662C11.3284 5.96662 11.4727 5.82237 11.4727 5.64439V4.2666C11.4727 4.08862 11.3284 3.94434 11.1504 3.94434Z"
                                        fill="#383838" />
                                    <path
                                        d="M11.1504 17.0332C10.9724 17.0332 10.8281 17.1775 10.8281 17.3555V18.7332C10.8281 18.9112 10.9724 19.0555 11.1504 19.0555C11.3284 19.0555 11.4727 18.9112 11.4727 18.7332V17.3555C11.4727 17.1775 11.3284 17.0332 11.1504 17.0332Z"
                                        fill="#383838" />
                                    <path
                                        d="M18.3836 11.1777H17.0059C16.8279 11.1777 16.6836 11.322 16.6836 11.5C16.6836 11.678 16.8279 11.8223 17.0059 11.8223H18.3836C18.5616 11.8223 18.7059 11.678 18.7059 11.5C18.7059 11.322 18.5616 11.1777 18.3836 11.1777Z"
                                        fill="#383838" />
                                    <path
                                        d="M5.29377 11.1777H3.91602C3.73804 11.1777 3.59375 11.322 3.59375 11.5C3.59375 11.678 3.73804 11.8223 3.91602 11.8223H5.29377C5.47174 11.8223 5.61603 11.678 5.61603 11.5C5.61603 11.322 5.47174 11.1777 5.29377 11.1777Z"
                                        fill="#383838" />
                                    <path
                                        d="M5.64252 7.94823L5.04594 7.60379C4.89177 7.51476 4.69472 7.56761 4.60573 7.72174C4.51674 7.87587 4.56955 8.07297 4.72368 8.16196L5.32026 8.5064C5.371 8.5357 5.42643 8.54962 5.48109 8.54962C5.59246 8.54962 5.70079 8.49179 5.76047 8.38845C5.84946 8.23432 5.79665 8.03722 5.64252 7.94823Z"
                                        fill="#383838" />
                                    <path
                                        d="M17.5761 14.8379L16.9795 14.4934C16.8254 14.4044 16.6283 14.4573 16.5393 14.6114C16.4503 14.7655 16.5031 14.9626 16.6573 15.0516L17.2538 15.396C17.3046 15.4253 17.36 15.4393 17.4147 15.4393C17.5261 15.4393 17.6344 15.3814 17.6941 15.2781C17.7831 15.124 17.7302 14.9269 17.5761 14.8379Z"
                                        fill="#383838" />
                                    <path
                                        d="M14.9255 4.95633C14.7714 4.8673 14.5743 4.92015 14.4853 5.07428L14.1409 5.67086C14.0519 5.82499 14.1047 6.02209 14.2588 6.11108C14.3096 6.14038 14.365 6.1543 14.4197 6.1543C14.531 6.1543 14.6394 6.09647 14.699 5.99313L15.0435 5.39655C15.1325 5.24242 15.0797 5.04532 14.9255 4.95633Z"
                                        fill="#383838" />
                                    <path
                                        d="M8.03882 16.889C7.88465 16.7999 7.68755 16.8528 7.5986 17.0069L7.25417 17.6035C7.16518 17.7576 7.21799 17.9547 7.37211 18.0437C7.42286 18.073 7.47829 18.0869 7.53295 18.0869C7.64432 18.0869 7.75265 18.0291 7.81233 17.9257L8.15677 17.3292C8.24576 17.175 8.19295 16.9779 8.03882 16.889Z"
                                        fill="#383838" />
                                    <path
                                        d="M17.6941 7.72172C17.6051 7.5676 17.4079 7.51479 17.2538 7.60378L16.6573 7.94821C16.5031 8.0372 16.4503 8.2343 16.5393 8.38843C16.599 8.49181 16.7073 8.5496 16.8187 8.5496C16.8734 8.5496 16.9288 8.53568 16.9795 8.50638L17.5761 8.16194C17.7302 8.07295 17.7831 7.87585 17.6941 7.72172Z"
                                        fill="#383838" />
                                    <path
                                        d="M5.76047 14.6114C5.67148 14.4572 5.47438 14.4044 5.32026 14.4935L4.72368 14.8379C4.56955 14.9269 4.51674 15.124 4.60573 15.2781C4.66541 15.3815 4.77374 15.4393 4.88511 15.4393C4.93977 15.4393 4.9952 15.4254 5.04594 15.3961L5.64252 15.0516C5.79665 14.9627 5.84946 14.7656 5.76047 14.6114Z"
                                        fill="#383838" />
                                    <path
                                        d="M8.15677 5.67087L7.81233 5.07429C7.72334 4.92012 7.52624 4.86731 7.37211 4.95634C7.21799 5.04533 7.16518 5.24243 7.25417 5.39656L7.5986 5.99314C7.65829 6.09652 7.76661 6.15431 7.87799 6.15431C7.93264 6.15431 7.98807 6.14039 8.03882 6.11108C8.19295 6.0221 8.24576 5.825 8.15677 5.67087Z"
                                        fill="#383838" />
                                    <path
                                        d="M15.0435 17.6035L14.699 17.0069C14.6101 16.8528 14.413 16.7999 14.2588 16.889C14.1047 16.9779 14.0519 17.175 14.1409 17.3292L14.4853 17.9257C14.545 18.0291 14.6533 18.0869 14.7647 18.0869C14.8194 18.0869 14.8748 18.073 14.9255 18.0437C15.0797 17.9547 15.1325 17.7576 15.0435 17.6035Z"
                                        fill="#383838" />
                                    <path
                                        d="M15.9432 10.7626C15.9161 10.5867 15.7519 10.466 15.5757 10.4931L12.0448 11.0363C11.8763 10.7117 11.5372 10.4893 11.147 10.4893C10.9855 10.4893 10.8329 10.5276 10.6974 10.5952L7.24152 7.13931C7.11567 7.01346 6.91161 7.01346 6.7858 7.13931C6.65994 7.26517 6.65994 7.46923 6.7858 7.59504L10.2416 11.0509C10.1741 11.1864 10.1358 11.339 10.1358 11.5005C10.1358 12.058 10.5894 12.5116 11.147 12.5116C11.6456 12.5116 12.0608 12.1487 12.143 11.6733L15.6737 11.1301C15.8496 11.103 15.9702 10.9385 15.9432 10.7626ZM11.1469 11.8671C10.9447 11.8671 10.7803 11.7026 10.7803 11.5005C10.7803 11.2983 10.9448 11.1339 11.1469 11.1339C11.349 11.1339 11.5135 11.2983 11.5135 11.5005C11.5135 11.7026 11.3491 11.8671 11.1469 11.8671Z"
                                        fill="#383838" />
                                    <path
                                        d="M16.9368 4.70037C15.2326 3.24648 13.0575 2.49131 10.8117 2.57458C8.55338 2.65807 6.42905 3.58469 4.8301 5.18364C3.23114 6.7826 2.30452 8.90693 2.22103 11.1652C2.13798 13.4109 2.89294 15.5862 4.34683 17.2903C4.41055 17.365 4.50104 17.4034 4.59214 17.4034C4.66613 17.4034 4.74046 17.3781 4.80114 17.3263C4.93653 17.2108 4.95264 17.0074 4.83714 16.872C3.4884 15.2911 2.78801 13.2729 2.86509 11.189C2.94257 9.09384 3.80228 7.12295 5.28582 5.63937C6.76936 4.15579 8.7403 3.29611 10.8355 3.21864C12.9195 3.1416 14.9375 3.84194 16.5185 5.19069C16.6538 5.30619 16.8573 5.29008 16.9728 5.15468C17.0883 5.01929 17.0722 4.81587 16.9368 4.70037Z"
                                        fill="#383838" />
                                    <path
                                        d="M17.9491 5.7098C17.8336 5.57441 17.6302 5.55825 17.4948 5.67379C17.3594 5.78929 17.3433 5.99271 17.4588 6.1281C18.8076 7.70901 19.5079 9.72725 19.4309 11.8111C19.3534 13.9063 18.4937 15.8772 17.0101 17.3607C15.5266 18.8443 13.5557 19.704 11.4605 19.7815C9.37682 19.8586 7.3584 19.1582 5.7775 17.8094C5.64215 17.6939 5.43869 17.71 5.32319 17.8454C5.20769 17.9808 5.2238 18.1842 5.3592 18.2997C6.97856 19.6813 9.02327 20.4317 11.1497 20.4317C11.261 20.4317 11.3726 20.4296 11.4843 20.4255C13.7426 20.342 15.8669 19.4154 17.4659 17.8165C19.0649 16.2175 19.9915 14.0932 20.075 11.8349C20.158 9.58923 19.403 7.41394 17.9491 5.7098Z"
                                        fill="#383838" />
                                </svg>
                            </span>
                            <span class="count-case-study">
                                Max. <?php echo esc_html($reading_min); ?> min read
                            </span>
                        </span>

                        <p class="case-study-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                        </p>
                    </div>
                    <div class="btn-wrapper">
                        <a href="<?php the_permalink(); ?>" class="btn white-btn">
                            Read More →
                        </a>
                    </div>
                </div>
            </div>

            <?php $i++; endwhile; ?>

            <!-- Pagination -->
            <div class="case-study-pagination">
                <?php
          echo paginate_links(array(
            'total'   => $case_query->max_num_pages,
            'current' => max(1, get_query_var('paged'))
          ));
          ?>
            </div>

            <?php else : ?>
            <p class="no-case-studies">No case studies found.</p>
            <?php endif;
      wp_reset_postdata(); ?>

        </div>
    </div>
</section>

<section class="sectionCvr client-sec pt-0">
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

<?php get_footer(); ?>