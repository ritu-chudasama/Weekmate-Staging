<?php
/**
 * News Archive 
 */
get_header();
// If fields are in ACF Options Page
$title        = get_field('news_event_title', 'option');
$content      = get_field('news_event_content', 'option');
$primary_text = get_field('news_event_primary_cta_text', 'option');
$primary_link = get_field('news_event_primary_cta_link', 'option');
$secondary_text = get_field('news_event_secondary_cta_text', 'option');
$secondary_link = get_field('news_event_secondary_cta_link', 'option');
$banner_image = get_field('news_event_banner_image', 'option');
?>

    <section class="news-hero">
        <div class="container">
            <div class="news-hero__wrapper">

                <!-- LEFT CONTENT -->
                <div class="news-hero__content">
                    
                    <?php if ($title): ?>
                        <h1 class="news-hero__title"><?php echo esc_html($title); ?></h1>
                    <?php endif; ?>

                    <?php if ($content): ?>
                        <p class="news-hero__description">
                            <?php echo esc_html($content); ?>
                        </p>
                    <?php endif; ?>

                    <div class="news-hero__buttons">
                        
                        <?php if ($primary_text && $primary_link): ?>
                            <a href="<?php echo esc_url($primary_link); ?>" class="news-hero__btn news-hero__btn--primary btn">
                                <?php echo esc_html($primary_text); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($secondary_text && $secondary_link): ?>
                            <a href="<?php echo esc_url($secondary_link); ?>" class="news-hero__btn news-hero__btn--secondary btn">
                                <?php echo esc_html($secondary_text); ?>
                                <span class="news-hero__arrow" aria-hidden="true">
                                    <svg class="news-hero__arrow-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- RIGHT IMAGE -->
                <?php if ($banner_image): ?>
                    <div class="news-hero__image">
                        <img src="<?php echo esc_url($banner_image['url']); ?>" alt="<?php echo esc_attr($banner_image['alt']); ?>">
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <?php
    /**
     * News Listing Section with Tabs
     * Insert this between news-hero and onboarding-cta sections
     */

    // TO
    $current_category = isset($_GET['news_category']) ? sanitize_text_field($_GET['news_category']) : 'upcoming-events';

    if ($current_category === 'upcoming-events') {
        $args = array(); 
    } elseif ($current_category === 'latest-updates') {

        // ALL latest BLOG POSTS
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
             'paged'          => 1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );

    } else {

        // Default = NEWS CPT
        $args = array(
            'post_type' => 'news-events',
            'posts_per_page' => 6,
            'paged'          => 1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );
    }





    $news_query = new WP_Query($args);
    $news_has_more = ($current_category !== 'upcoming-events') && (1 < $news_query->max_num_pages);
    ?>

    <section class="news-listing">
        <div class="container">
            
            <!-- Tab Navigation -->
            <div class="news-listing__tabs">
                <button class="news-listing__tab <?php echo $current_category === 'upcoming-events' ? 'news-listing__tab--active' : ''; ?>" data-type="upcoming-events">
                    Upcoming Events
                </button>
                <button class="news-listing__tab <?php echo $current_category === 'news' ? 'news-listing__tab--active' : ''; ?>" data-type="news">
                    News
                </button>
                <button class="news-listing__tab <?php echo $current_category === 'latest-updates' ? 'news-listing__tab--active' : ''; ?>" data-type="latest-updates">
                    Latest Updates
                </button>
            </div>

            <?php if ($current_category === 'upcoming-events') : ?>
                <div id="news-listing-results">
                    <?php
                    $announcement_section = get_field('news_event_announcement_section', 'option');
                    $slides               = $announcement_section['announcement_section_main_content'] ?? null;
                    $section_image        = $announcement_section['announcement_section_image'] ?? null;

                    $active_slides = get_active_sorted_announcement_slides($slides);
                    ?>

                    <div class="announcement-section__inner">

                        <?php if ($section_image) : ?>
                            <div class="announcement-section__image">
                                <img src="<?php echo esc_url($section_image['url']); ?>" alt="<?php echo esc_attr($section_image['alt']); ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($active_slides)) : ?>
                            <div class="announcement-slider">
                                <div class="announcement-slider__track">

                                    <?php foreach ($active_slides as $slide) :
                                        $group       = $slide['announcement_section_group'];
                                        $title_ann   = $group['announcement_section_title'];
                                        $content_ann = $group['announcement_section_content'];
                                        $date_icon   = $group['announcement_date_section_image'];
                                        $date_group  = $group['announcement_date_and_time_section'] ?? [];
                                        $date_from   = $date_group['date_from'] ?? '';
                                        $date_to     = $date_group['date_to']   ?? '';
                                        $time_icon   = $group['announcement_time_section_image'];
                                        $time_text   = $group['announcement_time_section'];
                                    ?>
                                        <div class="announcement-slider__slide">
                                            <div class="announcement-section__card">

                                                <?php if ($title_ann) : ?>
                                                    <h2 class="announcement-section__title"><?php echo esc_html($title_ann); ?></h2>
                                                <?php endif; ?>

                                                <?php if ($content_ann) : ?>
                                                    <div class="announcement-section__content"><?php echo wp_kses_post($content_ann); ?></div>
                                                <?php endif; ?>
                                                
                                                <div class="announcement-section__meta">

                                                    <?php if ($date_from || $date_to) : ?>
                                                        <div class="announcement-section__meta-item">

                                                            <?php if ($date_icon) : ?>
                                                                <img src="<?php echo esc_url($date_icon['url']); ?>" alt="date">
                                                            <?php endif; ?>

                                                            <span class="announcement-section__meta-text">
                                                                <?php
                                                                if ($date_from && $date_to) {
                                                                    echo esc_html(format_acf_date_range($date_from, $date_to));
                                                                } elseif ($date_from) {
                                                                    echo esc_html(format_acf_date_range($date_from, null));
                                                                }
                                                                ?>
                                                            </span>

                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($time_text)) : ?>
                                                        <div class="announcement-section__meta-item">

                                                            <?php if ($time_icon) : ?>
                                                                <img src="<?php echo esc_url($time_icon['url']); ?>" alt="time">
                                                            <?php endif; ?>

                                                            <span class="announcement-section__meta-text">
                                                                <?php echo esc_html($time_text); ?>
                                                            </span>

                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                                
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>

                        <?php else : ?>
                            <p class="announcement-section__empty">No upcoming events.</p>
                        <?php endif; ?>

                    </div>
                </div>

            <?php else : ?>
                <div id="news-listing-results" class="news-listing__grid">
                    <?php if ($news_query->have_posts()) : ?>
                        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                            <article class="news-card">
                            
                                <!-- Card Content Top -->
                                <div class="news-card__content">
                                    <h3 class="news-card__title">
                                        <?php the_title(); ?>
                                    </h3>
                                    
                                    <p class="news-card__excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                    </p>
                                    
                                    <a href="<?php the_permalink(); ?>" class="news-card__link">
                                        See more
                                    </a>
                                    
                                    <!-- Author and Meta -->
                                    <div class="news-card__meta">
                                        <div class="news-card__author">
                                            <div class="post-single-meta-author-container-image">
                                                <?php
                                                $author_id = get_the_author_meta('ID');
                                                $profile_image = get_field('profile_image', 'user_' . $author_id);

                                                if ($profile_image) {
                                                    echo wp_get_attachment_image(
                                                        is_array($profile_image) ? $profile_image['ID'] : $profile_image,
                                                        'medium',
                                                        false,
                                                        [
                                                            'alt' => 'Profile Image'
                                                        ]
                                                    );
                                                } else {
                                                    echo '<img src="' . get_template_directory_uri() . '/images/test-img-avatar.png" width="160" height="160">';
                                                }
                                                ?>
                                            </div>
                                            <span class="news-card__author-name">
                                                <?php
                                                $author_id  = get_the_author_meta('ID');
                                                $first_name = get_the_author_meta('first_name', $author_id);
                                                $last_name  = get_the_author_meta('last_name', $author_id);
                                                echo esc_html(trim($first_name . ' ' . $last_name));
                                                ?>
                                            </span>
                                            <span class="news-card__date"><?php echo get_the_date('d M Y'); ?></span>
                                        </div>
                                        <span class="news-card__read-time">
                                            <?php 
                                            $word_count   = str_word_count(strip_tags(get_the_content()));
                                            $reading_time = ceil($word_count / 200);
                                            echo $reading_time . ' min Read';
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Featured Image -->
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="news-card__image">
                                        <?php the_post_thumbnail('medium_large', array('class' => 'news-card__img')); ?>
                                    </div>
                                <?php endif; ?>

                            </article>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <p class="news-listing__no-posts">No posts found in this category.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
                 <div class="news-listing__load-more-wrap">
                <button
                    type="button"
                    class="news-load-more btn"
                    data-type="<?php echo esc_attr($current_category); ?>"
                    data-page="1"
                    style="<?php echo $news_has_more ? '' : 'display:none;'; ?>"
                >
                    Load More
                </button>
            </div>

        </div>
    </section>

    <?php
    // CTA Section from ACF Options Page
    $cta = get_field('onboarding_cta', 'option');

    if ($cta): 
        $bg_style = '';
        if (!empty($cta['bg_image'])) {
            $bg_style = 'style="background-image: url(\'' . esc_url($cta['bg_image']) . '\');"';
        }
    ?>
    <section class="onboarding-cta" <?php echo $bg_style; ?>>
        <div class="onboarding-cta__overlay">
            <div class="onboarding-cta__container">
                <div class="onboarding-cta__content">
                    
                    <div class="onboarding-cta__text">
                        <?php if (!empty($cta['title'])): ?>
                            <h2 class="onboarding-cta__title">
                                <?php echo esc_html($cta['title']); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if (!empty($cta['description'])): ?>
                            <div class="onboarding-cta__description">
                                <?php echo wp_kses_post(wpautop($cta['description'])); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($cta['button_primary']['text']) || !empty($cta['button_secondary']['text'])): ?>
                            <div class="onboarding-cta__buttons">
                                
                                <?php if (!empty($cta['button_primary']['text'])): ?>
                                    <a href="<?php echo esc_url($cta['button_primary']['url']); ?>" 
                                    class="onboarding-cta__button onboarding-cta__button--primary">
                                        <?php echo esc_html($cta['button_primary']['text']); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($cta['button_secondary']['text'])): ?>
                                    <a href="<?php echo esc_url($cta['button_secondary']['url']); ?>" 
                                    class="onboarding-cta__button onboarding-cta__button--secondary">
                                        <?php echo esc_html($cta['button_secondary']['text']); ?>
                                    </a>
                                <?php endif; ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($cta['side_image'])): ?>
                        <div class="onboarding-cta__image">
                            <img 
                                src="<?php echo esc_url($cta['side_image']['url']); ?>" 
                                alt="<?php echo esc_attr($cta['side_image']['alt'] ?: 'CTA Image'); ?>"
                                class="onboarding-cta__img"
                            >
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
<?php get_footer(); ?>