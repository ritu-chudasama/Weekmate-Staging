<?php
/**
 * Blog Archive / Posts Page
 */
get_header();

// ACF Blog Page fields
$blog_page = get_field('blog_page', 'option');
$colorClasses = [
    "light-mint-bg-clr",
    "soft-peach-bg-clr",
    "light-ivory-bg-clr",
    "sky-blue-bg-clr",
    "lavender-mist-bg-clr",
    "off-white-bg-clr",
    "light-lavender-bg-clr"
];
global $wp_query;
$max_pages = $wp_query->max_num_pages;
?>

<?php if ( $blog_page ) : ?>
<section class="blog-hero-sec sectionCvr home-banner-sec advtool-sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="blog-hero-content banner-wrap">
                    <!-- Rating Logos --> <?php if ( !empty($blog_page['rating_logo']) ) : ?>
                        <div class="banner-rating"> 
                        <ul
                        class="rating-block">
                        <?php foreach( $blog_page['rating_logo'] as $logo ) : ?>
                        <?php if ( !empty($logo['image']['url']) ) : ?> 
                            <li class="">
                                <img
                                src="<?php echo esc_url($logo['image']['url']); ?>"
                                alt="<?php echo esc_attr($logo['image']['alt']); ?>" class="me-3" style="max-height:30px;">
                            </li>
                        <?php endif; ?> <?php endforeach; ?> </ul> </div> <?php endif; ?>
                    <?php if ( !empty($blog_page['heading']) ) : ?>
                    <h1><?php echo esc_html($blog_page['heading']); ?></h1>
                    <?php endif; ?>

                    <?php if ( !empty($blog_page['description']) ) : ?>
                    <p><?php echo esc_html($blog_page['description']); ?></p>
                    <?php endif; ?>

                    <?php if ( !empty($blog_page['button']) ) : ?>
                    <a href="<?php echo esc_url($blog_page['button']['url']); ?>" class="btn btn-primary">
                        <?php echo esc_html($blog_page['button']['title']); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-8 col-lg-7 col-md-12 col-sm-12">
                <?php if ( !empty($blog_page['banner_image']['url']) ) : ?>
                <img src="<?php echo esc_url($blog_page['banner_image']['url']); ?>"
                    alt="<?php echo esc_attr($blog_page['banner_image']['alt']); ?>" class="img-fluid">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>



<!-- 📑 Blog Listing -->

<section class="blog-listing sectionCvr">
    <!-- 🔎 Search + Filter -->
    <div class="blog-search-filter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="title-block-wrapper title-block">
                        <h2 class="title h1">Search Reasult</h2>
						<p><?php echo esc_html($_GET['s']);?></p>
                    </div>
                </div>
				<div class="col-lg-6 col-md-12 col-sm-12">
                    <form id="blog-filter-form" method="get" action="<?php echo home_url('/'); ?>"
                        class="row g-2 justify-content-end">
                        <div class="col-md-6">
                            <input type="text" name="s" class="form-control" placeholder="Search..."
                                value="<?php echo get_search_query(); ?>">
                            <input type="hidden" name="post_type" value="post" value="<?php echo esc_html($_GET['s']);?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="blog-posts" class="blog-grid-wrapper">
            <?php
                // $args = array(
                //     'post_type'      => 'post',
                //     'posts_per_page' => 6,
                //     'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
				// 	's'              => get_search_query()
                // );
                // $blog_query = new WP_Query($args);

            if ( have_posts() ) {
                $i = 0; // counter

                 while ( have_posts() ) {
                    the_post();
                    $classIndex   = $i % count($colorClasses);
                    $currentClass = $colorClasses[$classIndex];

                    // Open wrapper every 3 items
                    if ( $i % 3 === 0 ) {
                        echo '<div class="blog-grid">';
                    }
                    ?>
                        <div class="blog-grid-item">
                            <article class="blog-card">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail() ) { ?>
                                    <div class="blog-thumb"><?php the_post_thumbnail('large'); ?></div>
                                    <?php } ?>
                                    <div class="blog-content <?php echo esc_attr($currentClass); ?>">
                                        <h2 class="blog-title h5"><?php the_title(); ?></h2>
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="18" viewBox="0 0 11 18"
                                                fill="none">
                                                <path
                                                    d="M1.54941 17.33C1.92702 17.33 2.30464 17.1909 2.60276 16.8927L9.61851 9.877C10.1949 9.30063 10.1949 8.34665 9.61851 7.77029L2.60276 0.754539C2.0264 0.178175 1.07241 0.178175 0.49605 0.754539C-0.0803146 1.3309 -0.0803146 2.28489 0.49605 2.86125L6.45844 8.82364L0.49605 14.786C-0.0803146 15.3624 -0.0803146 16.3164 0.49605 16.8927C0.774295 17.1909 1.15191 17.33 1.54941 17.33Z"
                                                    fill="black"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        </div>
                        <?php
                    $i++;

                    // Close wrapper after 3 items
                    if ( $i % 3 === 0 ) {
                        echo '</div>';
                    }
                }

            } else {
                echo '<p>No posts found.</p>';
            }
            wp_reset_postdata();
            ?>
        </div>
        <!-- Load More Button -->
        <div class="text-center mt-4">
            <button id="load-more" class="btn btn-outline-primary" data-page="1"
                data-max="<?php echo (int) $max_pages; ?>">
                Load More
            </button>
        </div>
    </div>
</section>

<?php get_footer(); ?>