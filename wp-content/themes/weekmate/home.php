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

?>

<?php if ($blog_page) : ?>
    <section class="blog-hero-sec sectionCvr home-banner-sec advtool-sec">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="blog-hero-content banner-wrap">
                        <!-- Rating Logos --> <?php if (!empty($blog_page['rating_logo'])) : ?>
                            <div class="banner-rating">
                                <ul
                                    class="rating-block">
                                    <?php foreach ($blog_page['rating_logo'] as $logo) : ?>
                                        <?php if (!empty($logo['image']['url'])) : ?>
                                            <li class="">
                                                <img
                                                    src="<?php echo esc_url($logo['image']['url']); ?>"
                                                    alt="<?php echo esc_attr($logo['image']['alt']); ?>" class="me-3" style="max-height:30px;">
                                            </li>
                                        <?php endif; ?> <?php endforeach; ?>
                                </ul>
                            </div> <?php endif; ?>
                        <?php if (!empty($blog_page['heading'])) : ?>
                            <h1><?php echo esc_html($blog_page['heading']); ?></h1>
                        <?php endif; ?>

                        <?php if (!empty($blog_page['description'])) : ?>
                            <p><?php echo esc_html($blog_page['description']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($blog_page['button'])) : ?>
                            <a href="<?php echo esc_url($blog_page['button']['url']); ?>" class="btn btn-primary">
                                <?php echo esc_html($blog_page['button']['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                    <?php if (!empty($blog_page['banner_image']['url'])) : ?>
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
            <div class="row align-items-center blog-page-main-archive-page">
                <div class="col-12 blog-page-main-title">
                    <div class="title-block-wrapper title-block text-center">
                        <h2 class="title h1">Our Blog</h2>
                    </div>
                </div>
                <div class="col-12 blog-page-main-search">
                       <form id="blog-filter-form" class="row g-2 justify-content-center">
                        <div class="col-md-6 position-relative">
                            <input
                                type="search"
                                name="s"
                                id="blog-search"
                                class="form-control"
                                placeholder="Search...">
                            <input type="hidden" name="post_type" value="post">

                            <button type="submit" class="blog-search-btn" aria-label="Search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 21L15.8 15.8M18 11C18 14.866 14.866 18 11 18
                                            C7.134 18 4 14.866 4 11
                                            C4 7.134 7.134 4 11 4
                                            C14.866 4 18 7.134 18 11Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </button>
                        </div>

                        <div class="col-md-4">
                            <?php
                            wp_dropdown_categories(array(
                                'show_option_all' => 'All Categories',
                                'taxonomy'        => 'category',
                                'name'            => 'cat',
                                'id'              => 'blog-category',
                                'class'           => 'form-select',
                                'exclude'         => array(1, 66),
                                'value_field'     => 'slug',
                            ));
                            ?>
                        </div>
                    </form>
                    <div class="blog-tabs">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy'   => 'category',
                            'hide_empty' =>  true,
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'exclude'    => array(1, 66),
                        ));

                        $custom_order = array('hrms-payroll', 'crm', 'project-management', 'team-communication', 'email-marketing', 'saas', 'industries');

                        usort($categories, function ($a, $b) use ($custom_order) {
                            $posA = array_search($a->slug, $custom_order);
                            $posB = array_search($b->slug, $custom_order);
                            $posA = $posA === false ? 999 : $posA;
                            $posB = $posB === false ? 999 : $posB;
                            return $posA <=> $posB;
                        });

                        $visible_tabs = 8;
                        $terms = array_slice($categories, 0, $visible_tabs);
                        $terms_drop = array_slice($categories, $visible_tabs);
                        ?>

                        <ul class="nav nav-tabs-main d-none d-lg-flex" id="nav-tabs-main">
                            <li class="nav-item">
                                <a class="nav-link active" data-cat="0" data-toggle="tab" href="#all">
                                    All Blogs
                                </a>
                            </li>

                            <?php foreach ($terms as $term) : ?>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        data-toggle="tab"
                                        data-cat="<?php echo esc_attr($term->term_id); ?>"
                                        href="#<?php echo esc_attr($term->slug); ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>

                            <?php if (!empty($terms_drop)) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle-bar"
                                        data-toggle="dropdown"
                                        href="#">
                                        More
                                    </a>
                                    <div class="dropdown-menu">
                                        <?php foreach ($terms_drop as $term) : ?>
                                            <a class="dropdown-item"
                                                data-toggle="tab"
                                                href="#<?php echo esc_attr($term->slug); ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                            <div class="nav-tabs-mobile d-lg-none dropdown" id="nav-tabs-mobile">
                                <a class="mobile-dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="mobile-selected-text">All Blog</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item active" data-toggle="tab" href="#all">All Category</a>

                                    <?php foreach ($terms as $term) : ?>
                                        <a class="dropdown-item" data-toggle="tab" href="#<?php echo esc_attr($term->slug); ?>">
                                            <?php echo esc_html($term->name); ?>
                                        </a>
                                    <?php endforeach; ?>

                                    <?php foreach ($terms_drop as $term) : ?>
                                        <a class="dropdown-item" data-toggle="tab" href="#<?php echo esc_attr($term->slug); ?>">
                                            <?php echo esc_html($term->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                    </div>
                                            
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        
        <div id="blog-posts" class="blog-grid-wrapper">
            
            <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'paged'          => $paged,
                'cat'            => '-1, -66'
            );
            $blog_query = new WP_Query($args);

            if ($blog_query->have_posts()) {
                $i = 0; // counter

                echo '<div class="blog-grid">';
                while ($blog_query->have_posts()) {
                    $blog_query->the_post();
                    $classIndex   = $i % count($colorClasses);
                    $currentClass = $colorClasses[$classIndex];

            ?>
                    <div class="blog-grid-item">
                        <article class="blog-card">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) { ?>
                                    <div class="blog-thumb"><?php the_post_thumbnail('large'); ?></div>
                                <?php } ?>
                                <div class="blog-content <?php echo esc_attr($currentClass); ?>">
                                    <div class="blog-content-title">
                                        <h2 class="blog-title text-18"><?php the_title(); ?></h2>
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="18" viewBox="0 0 11 18"
                                                fill="none">
                                                <path
                                                    d="M1.54941 17.33C1.92702 17.33 2.30464 17.1909 2.60276 16.8927L9.61851 9.877C10.1949 9.30063 10.1949 8.34665 9.61851 7.77029L2.60276 0.754539C2.0264 0.178175 1.07241 0.178175 0.49605 0.754539C-0.0803146 1.3309 -0.0803146 2.28489 0.49605 2.86125L6.45844 8.82364L0.49605 14.786C-0.0803146 15.3624 -0.0803146 16.3164 0.49605 16.8927C0.774295 17.1909 1.15191 17.33 1.54941 17.33Z"
                                                    fill="black"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <p class="blog-meta">
                                        <span>Author: <?php the_author(); ?></span> <span><?php echo get_the_date('d F, Y'); ?></span>
                                    </p>

                                </div>
                            </a>
                        </article>
                    </div>
            <?php
                    $i++;
                }
                echo '</div>';
            } else {
                echo '<p>No posts found.</p>';
            }
            if ($blog_query->max_num_pages > $paged) {
            ?>
                <div id="load-more-wrapper" class="text-center mt-4">
                    <button
                        id="load-more"
                        class="btn btn-primary"
                        data-page="<?php echo $paged + 1; ?>"
                        data-max="<?php echo $blog_query->max_num_pages; ?>">
                        Load More
                    </button>
                </div>
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>
        <!-- Load More Button -->
        <!-- <div class="text-center mt-4">
            <button id="load-more" class="btn btn-outline-primary" data-page="2"
                data-max="<?php //echo (int) $blog_query->max_num_pages; 
                            ?>">
                Load More
            </button>
        </div> -->
    </div>
</section>

<?php get_footer(); ?>
