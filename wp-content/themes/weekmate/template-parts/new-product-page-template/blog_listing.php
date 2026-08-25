<?php
// Get current post's categories
$categories = get_the_category();
$category_id = !empty($categories) ? $categories[0]->term_id : 0;

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post__not_in'   => array(get_the_ID()), // exclude current post
);

if ($category_id > 0) {
    $args['cat'] = $category_id;
}

$title = get_sub_field('title');

$blog_query = new WP_Query($args);

$bg_colors = array(
    'light-mint-bg-clr',
    'soft-peach-bg-clr',
    'light-ivory-bg-clr',
    'sky-blue-bg-clr',
    'lavender-mist-bg-clr',
    'off-white-bg-clr',
);
?>
<section class="blog-listing sectionCvr pt-0">
    <div class="container">
        <div class="blog-grid-title title-block-wrapper text-center title-block">
            <h2 class="title-block title text-none"><?php echo esc_html($title) ?></h2>
        </div>
        <div class="blog-grid">
            <?php if ($blog_query->have_posts()) :
                $i = 0;
                while ($blog_query->have_posts()) : $blog_query->the_post();
            ?>
                <div class="blog-grid-item">
                    <article class="blog-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="blog-thumb">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="blog-content <?php echo esc_attr($bg_colors[$i % count($bg_colors)]); ?>">
                                <div class="blog-content-title">
                                    <h2 class="blog-title text-18"><?php the_title(); ?></h2>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="18" viewBox="0 0 11 18" fill="none">
                                            <path d="M1.54941 17.33C1.92702 17.33 2.30464 17.1909 2.60276 16.8927L9.61851 9.877C10.1949 9.30063 10.1949 8.34665 9.61851 7.77029L2.60276 0.754539C2.0264 0.178175 1.07241 0.178175 0.49605 0.754539C-0.0803146 1.3309 -0.0803146 2.28489 0.49605 2.86125L6.45844 8.82364L0.49605 14.786C-0.0803146 15.3624 -0.0803146 16.3164 0.49605 16.8927C0.774295 17.1909 1.15191 17.33 1.54941 17.33Z" fill="black"></path>
                                        </svg>
                                    </div>
                                </div>

                                <p class="blog-meta">
                                    <span>Author: <?php the_author(); ?></span>
                                    <span><?php echo get_the_date('d F, Y'); ?></span>
                                </p>
                            </div>
                        </a>
                    </article>
                </div>
            <?php
                $i++;
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <p>No related posts found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>