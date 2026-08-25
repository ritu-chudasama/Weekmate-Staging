<?php

/**
 * Author Archive Template (Custom Profile)
 */
get_header();

$author = get_queried_object();
$user_id = $author->ID;

/* ACF Fields */
$author_profile_image   = get_field('author_page_image', 'user_' . $user_id);
$designation     = get_field('designation', 'user_' . $user_id);
$linkedin_url    = get_field('linkedin_url', 'user_' . $user_id);
$author_quote    = get_field('author_quote', 'user_' . $user_id);
$about_author    = get_field('about_author', 'user_' . $user_id);

/* Experience (fallback if not added yet) */
$years_of_exp = get_field('years_of_experience', 'user_' . $user_id);

$bio_description = get_the_author_meta('description', $user_id);

$first_name = get_the_author_meta('first_name', $user_id);
$last_name  = get_the_author_meta('last_name', $user_id);

$author_full_name = trim($first_name . ' ' . $last_name);

// Fallback if first/last name is empty
if (empty($author_full_name)) {
    $author_full_name = $author_full_name;
}

?>

<div class="profile-page-container">

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container hero-container">

            <!-- Left Content -->
            <div class="hero-content">

                <h1 class="name">
                    <?php echo esc_html($author_full_name); ?>
                </h1>

                <?php if ($designation) : ?>
                    <p class="designation">
                        <?php echo esc_html($designation); ?>
                    </p>
                <?php endif; ?>

                <!-- Core Expertise -->
                <?php if (have_rows('core_expertise', 'user_' . $user_id)) : ?>
                    <div class="expertise-block">
                        <span class="label">CORE EXPERTISE:</span>
                        <div class="tags">
                            <?php while (have_rows('core_expertise', 'user_' . $user_id)) : the_row(); ?>
                                <span class="tag">
                                    <?php echo esc_html(get_sub_field('expertise_title')); ?>
                                </span>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Contact -->
                <div class="contact-block">

                    <?php if ($linkedin_url) : ?>
                        <div class="contact-item">
                            <span class="label">Connect With Me At:</span>
                            <a href="<?php echo esc_url($linkedin_url); ?>"
                                class="icon-link"
                                target="_blank"
                                rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
                                    <rect width="43.8477" height="43.8477" rx="5.48096" fill="white" />
                                    <path d="M35.0162 35.0163H29.5225V26.413C29.5225 24.3613 29.4859 21.7213 26.6651 21.7213C23.804 21.7213 23.3655 23.9557 23.3655 26.265V35.0163H17.8736V17.3237H23.1481V19.7408H23.2212C24.2973 17.9029 26.296 16.8049 28.4244 16.8834C33.9931 16.8834 35.018 20.5465 35.018 25.3095L35.0162 35.0163ZM11.6746 14.9048C9.91341 14.9048 8.48654 13.4779 8.48654 11.7167C8.48654 9.95549 9.91341 8.52861 11.6746 8.52861C13.4358 8.52861 14.8627 9.95549 14.8627 11.7167C14.8627 13.4779 13.4358 14.9048 11.6746 14.9048ZM14.4206 35.0163H8.92136V17.3237H14.4206V35.0163ZM37.7549 3.42766H6.16078C4.66813 3.41122 3.44405 4.60789 3.42578 6.10054V37.8243C3.44405 39.3188 4.66813 40.5155 6.16078 40.4991H37.7549C39.2512 40.5173 40.4807 39.3207 40.5008 37.8243V6.09871C40.4789 4.60241 39.2494 3.40574 37.7549 3.42583" fill="#095483" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="contact-item">
                        <span class="label">Or Send Me An Email At</span>
                        <div class="email-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
                                <rect width="43.8477" height="43.8477" rx="5.48096" fill="white" />
                                <g clip-path="url(#clip0_203_433)">
                                    <g clip-path="url(#clip1_203_433)">
                                        <path d="M40.2903 11.8494L27.2868 24.8528C25.8369 26.2991 23.8726 27.1113 21.8247 27.1113C19.7768 27.1113 17.8125 26.2991 16.3626 24.8528L3.35914 11.8494C3.33752 12.0934 3.28809 12.3143 3.28809 12.5569V31.0935C3.29054 33.1411 4.10506 35.1042 5.55298 36.5522C7.0009 38.0001 8.964 38.8146 11.0117 38.8171H32.6377C34.6854 38.8146 36.6485 38.0001 38.0964 36.5522C39.5443 35.1042 40.3589 33.1411 40.3613 31.0935V12.5569C40.3613 12.3143 40.3119 12.0934 40.2903 11.8494Z" fill="#095483" />
                                        <path d="M25.1037 22.6686L39.2132 8.55761C38.5297 7.42428 37.5656 6.4862 36.4141 5.83386C35.2625 5.18151 33.9623 4.83691 32.6388 4.8333H11.0128C9.68931 4.83691 8.38909 5.18151 7.23755 5.83386C6.086 6.4862 5.12198 7.42428 4.43848 8.55761L18.5479 22.6686C19.4185 23.5357 20.5971 24.0225 21.8258 24.0225C23.0545 24.0225 24.2332 23.5357 25.1037 22.6686Z" fill="#095483" />
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_203_433">
                                        <rect width="37.0732" height="37.0732" fill="white" transform="translate(3.28809 3.28857)" />
                                    </clipPath>
                                    <clipPath id="clip1_203_433">
                                        <rect width="37.0732" height="37.0732" fill="white" transform="translate(3.28809 3.28857)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <a href="mailto:<?php echo esc_attr($author->user_email); ?>">
                                <?php echo esc_html($author->user_email); ?>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Image -->
            <div class="hero-image-wrapper">
                <?php if ($author_profile_image) : ?>
                    <img src="<?php echo esc_url($author_profile_image['url']); ?>"
                        alt="<?php echo esc_attr($author_full_name); ?>"
                        class="hero-img">
                <?php else : ?>
                    <?php echo get_avatar($user_id, 300, '', '', ['class' => 'hero-img']); ?>
                <?php endif; ?>
            </div>

        </div>
    </div>


    <!-- About Section -->
     <?php if ($bio_description) : ?>
    <section class="about-section">
        <div class="container">

            <div class="about-wrapper">
                <div class="about-container">
                    <div class="experience-card">
                        <?php if ($years_of_exp) : ?>
                        <div class="experience-number">
                            <?php echo esc_html($years_of_exp); ?>+
                        </div>
                        <div class="experience-text">Years of Experience</div>
                        <?php endif; ?>
                    </div>

                   <?php if ($bio_description) : ?>
                        <div class="about-card">
                            <h2>About <?php echo esc_html($author_full_name); ?></h2>

                            <ul>
                                <?php
                                // Convert bio (line breaks) into <li>
                                $lines = preg_split("/\r\n|\n|\r/", trim($bio_description));

                                foreach ($lines as $line) :
                                    if (!empty(trim($line))) :
                                ?>
                                        <li><?php echo esc_html(trim($line)); ?></li>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>


    <?php if ($author_quote) : ?>
    <section class="quote-section">
        <div class="container">
            <div class="quote-wrapper">
                <div class="quote-container">
                    <div class="quote-card">
                        <p class="quote-text">
                            <?php echo esc_html($author_quote); ?>
                        </p>

                        <p class="quote-author">
                            ~ <?php echo esc_html($author_full_name); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="related-posts blog-listing sectionCvr pt-0 author-page-blog-listing" id="author-insights">
        <div class="container author-page-post-listing-container">

            <div class="section-header text-center author-page-blog-listing-title">
                <h2 class="heading-bold h1">
                    Insights by <?php echo esc_html($author_full_name); ?>
                </h2>
            </div>

            <div class="blog-grid author-page-blog-listing-container" id="author-posts-container">
                <?php
                $paged = 1;

                $author_posts = new WP_Query([
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'author'         => $user_id,
                    'paged'          => $paged,
                    'post_status'    => 'publish',
                    'category__not_in' => [11],
                ]);

                if ($author_posts->have_posts()) :
                    while ($author_posts->have_posts()) :
                        $author_posts->the_post();
                ?>
                        <div class="blog-grid-item">
                            <article class="blog-card">
                                <a href="<?php the_permalink(); ?>">

                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="blog-thumb">
                                            <?php the_post_thumbnail('large'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="blog-content">
                                        <div class="blog-content-title">
                                            <h2 class="blog-title text-18"><?php the_title(); ?></h2>

                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="18" viewBox="0 0 11 18">
                                                    <path d="M1.54941 17.33C1.92702 17.33 2.30464 17.1909 2.60276 16.8927L9.61851 9.877C10.1949 9.30063 10.1949 8.34665 9.61851 7.77029L2.60276 0.754539C2.0264 0.178175 1.07241 0.178175 0.49605 0.754539C-0.0803146 1.3309 -0.0803146 2.28489 0.49605 2.86125L6.45844 8.82364L0.49605 14.786C-0.0803146 15.3624 -0.0803146 16.3164 0.49605 16.8927C0.774295 17.1909 1.15191 17.33 1.54941 17.33Z" fill="black" />
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
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p class="text-center">No posts published yet.</p>';
                endif;
                ?>
            </div>

            <?php if ($author_posts->max_num_pages > 1) : ?>
                <div class="text-center mt-4">
                    <button
                        id="load-more-author-posts"
                        class="btn btn-primary load-more-button-for-author-page"
                        data-page="1"
                        data-max="<?php echo esc_attr($author_posts->max_num_pages); ?>"
                        data-author="<?php echo esc_attr($user_id); ?>">
                        Load More
                    </button>
                </div>
            <?php endif; ?>

        </div>
    </section>





</div>




<?php get_footer(); ?>