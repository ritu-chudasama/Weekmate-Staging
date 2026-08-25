<?php
/**
 * The template for displaying all calculator posts and attachments
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

 get_header(); ?>
<?php
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

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


<section class="sectionCvr free-tools-hero-section blog-hero-sec border-btm">
    <div class="container">
        <div class="row align-items-center free-tools-main-title">


            <div class="col-lg-6 col-md-12 order-1 order-lg-0">
                <div class="blog-hero-wrap">


                    <div class="freetools-meta">
                        <h1 class="fw-bold blog-hero-title tools-hero-title tools-hero-main-title"><?php the_title(); ?></h1>
                        <?php 
                            $quote = get_field('free-tools-quote'); 
                            if ( $quote ) : ?>
                                <p class="free-tools-quote"><?php echo esc_html($quote); ?></p>
                            <?php endif; ?>
                    </div>

                    

                </div>
            </div>

           
        </div>
    </div>
</section>

<section class="single-blog sectionCvr">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="blog-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                 <?php
                    $blog_side_section = get_field('blog_side_section', 'option');
                    if( $blog_side_section ) : 
                    $heading      = $blog_side_section['heading'];
                    $detail_block = $blog_side_section['detail_block'];
                    $button       = $blog_side_section['button'];
                 ?>
                <aside class="blog-side-section">
                    <?php if( $heading ): ?>
                    <h3 class="side-heading"><?php echo esc_html($heading); ?></h3>
                    <?php endif; ?>

                    <?php if( $detail_block ): ?>
                    <ul class="side-detail-block">
                        <?php foreach( $detail_block as $item ): ?>
                        <?php if( !empty($item['text']) ): ?>
                        <li><?php echo esc_html($item['text']); ?></li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <?php if( $button ): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="side-btn btn btn-primary mt-3"
                        target="<?php echo esc_attr($button['target']); ?>">
                        <?php echo esc_html($button['title']); ?>
                    </a>
                    <?php endif; ?>
                </aside>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- <section class="author-bio-section sectionCvr pt-0">
    <div class="container">
        <div class="blog_footer author-profile-about-section">
            <div class="author_thumbnail">
                <div class="thumb_cover author-profile-image-single-page">
                    <?php
                    $author_id = get_the_author_meta('ID');
                    $profile_image = get_field('profile_image', 'user_' . $author_id);

                    if ($profile_image) {
                        echo wp_get_attachment_image(
                            is_array($profile_image) ? $profile_image['ID'] : $profile_image,
                            'medium',
                            false,
                            [
                                'alt'    => 'Profile Image'
                            ]
                        );
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/images/test-img-avatar.png" width="160" height="160">';
                    }
                    ?>
                    </div>


                <div class="author-desc">
                <h4 class="heading-bold about-author">About Author</h4>
                
                <?php 
                // Get the current user's ID
                $user_id = get_current_user_id(); 

                // Fetch the first and last name using ACF custom fields
                $first_name = get_user_meta($author_id, 'first_name', true); 
                $last_name = get_user_meta($author_id, 'last_name', true); 
                
                // Combine first and last name
                $full_name = $first_name . ' ' . $last_name; 
                ?>
                
                <h5 class="heading-bold"><?php echo esc_html($full_name); ?> - <?php echo esc_html(get_user_meta($author_id, 'designation', true)); ?></h5>
                <p><?php echo esc_html(get_the_author_meta('description', $author_id)); ?></p>

                <div class="blog-footer-social-links">
                    <div class="blog-share ftrsocialLinks">
                        <li>
                            <a href="<?php echo esc_url(get_user_meta($author_id, 'linkedin_url', true)); ?>" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </li>
                    </div>
                </div>

                <div class="bookbtn">
                    <a href="https://app.weekmate.in/register-company" class="btn btn-secondary">Let's Connect</a>
                </div>
            </div>



            </div>
        </div>
    </div>
</section> -->
<!-- 📑 Related Free Tools -->
<section class="free_tools-listing">
    <div class="container">
    <div class="free__tools__title-container"><h2 class="free__tools__title">View Other free Tools</h2></div>
        <div class="free_tools-grid">
            <?php
            $args = array(
                'post_type'      => 'freetools',
                'posts_per_page' => 3,
                'post__not_in'   => [get_the_ID()],
                
            );
            $blog_query = new WP_Query( $args );

            if ( $blog_query->have_posts() ) :
                while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>

            <a class="free_tools-card <?php echo get_post_field( 'post_name', get_post() ); ?>" style="color : #000" href="<?php the_permalink(); ?>">
                
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="free_tools-thumb">
                        <?php the_post_thumbnail( 'medium' ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="free_tools-card-content">
                        <div class="free_tools-card-content-title">
                        <h2 class="free_tools-card-title tools-hero-title"><?php the_title(); ?></h2>
                        </div>
                        <div class="free_tools-card-content-description">
                        <p class="free_tools-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                        
                            <span class="free_tools-read-more"><span class="text">Calculate Now</span>
                            <span class="arrow"><img src="<?php echo get_template_directory_uri(); ?>/images/right-arrow.png" alt="icon" style="width:18px; height:auto;"></span>
                        
                        </div>
                        
                        
                    </div>
                
            </a>

            <?php endwhile; ?>

            <div class="free_tools-pagination">
                <?php
                    echo paginate_links( array(
                        'total'   => $blog_query->max_num_pages,
                        'current' => max( 1, get_query_var('paged') )
                    ));
                ?>
            </div>

            <?php else : ?>
            <p class="no-posts">No calculators found.</p>
            <?php endif; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<?php endwhile; endif; ?>
<?php get_footer(); ?>