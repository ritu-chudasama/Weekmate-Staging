<?php
/**
 * The template for displaying all single posts and attachments
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

<!-- 📌 Blog Hero Section -->
<section class="sectionCvr blog-hero-sec border-btm">
    <div class="container">
        <div class="row align-items-center">

            <!-- Left Column: Title + Meta -->
            <div class="col-lg-6 col-md-12 order-1 order-lg-0">
                <div class="blog-hero-wrap">

                    <!-- 📅 Meta -->
                    <div class="blog-meta">
                        <div class="post-single-meta-button-content">
                        <div class="post-single-meta">
                            <?php
                             $author_id   = get_the_author_meta('ID');
                             $author_url  = get_author_posts_url($author_id);
                            ?>
                        <div class="post-meta post-single-meta-author-container">
                            <a class="post-single-meta-author-container-link" href="<?php echo esc_url($author_url); ?>" class="author-link">
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
                                                    'alt'    => 'Profile Image'
                                                ]
                                            );
                                        } else {
                                            echo '<img src="' . get_template_directory_uri() . '/images/test-img-avatar.png" width="160" height="160">';
                                        }
                                    ?>
                                </div>
                            </a>

                            <div class="author-name post-single-meta-author-name">
                                <a class="post-single-meta-author-container-link" href="<?php echo esc_url($author_url); ?>" class="author-link"><strong>Author</strong>: <?php echo get_the_author(); ?></a>
                                <div class="post-single-meta-description-container">
                                    <p class="post-meta post-single-meta-descripiton">
                                    <strong>Published:</strong> <?php echo get_the_date('F j, Y'); ?>
                                    </p>
                                    <p class="post-meta post-single-meta-descripiton">
                                    <strong>Updated:</strong> <?php echo get_the_modified_date('F j, Y'); ?>
                                    </p>
                                </div>
                            </div>
                            
                            </div>
                            </div>
                            <a href="https://app.weekmate.in/register-company" class="side-btn btn btn-primary mt-3 post-single-meta-button" target="">Start free Trial</a>
                            </div>
                        
                            <!-- 🏷 Title -->
                        <h1 class="fw-bold blog-hero-title"><?php the_title(); ?></h1>
                    </div>

                    <!-- 🔗 Social Share -->
                    <!-- <ul class="blog-share ftrsocialLinks">
                        <li>
                            <a href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
                                target="_blank"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank"><i
                                    class="fab fa-x-twitter"></i></a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(); ?>"
                                target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>" target="_blank"><i
                                    class="fab fa-whatsapp"></i></a>
                        </li>
                    </ul> -->

                </div>
            </div>

            <!-- Right Column: Featured Image -->
            <div class="col-lg-6 col-md-12">
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="blog-hero-image text-center">
                    <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- End Blog Hero Section -->
<!-- 📑 Single Blog Content -->
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
                <div class="blogpage__social-link">
                <p class="blogpage__social-link-title">Share: </p>
                <ul class="blog-share ftrsocialLinks">
                        <li>
                            <a href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
                                target="_blank"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank"><i
                                    class="fab fa-x-twitter"></i></a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(); ?>"
                                target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>" target="_blank"><i
                                    class="fab fa-whatsapp"></i></a>
                        </li>
                    </ul>
                </div>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<section class="author-bio-section sectionCvr pt-0">
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
</section>
<!-- 📑 Related Posts -->
<section class="related-posts blog-listing sectionCvr pt-0">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="heading-bold h1">Related Posts</h2>
        </div>
        <div class="blog-grid">
            <?php
      $related = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post__not_in'   => [get_the_ID()],
        'orderby'        => 'rand'
      ]);

      if ( $related->have_posts() ) :
          $i = 0; // counter
          while ( $related->have_posts() ) : $related->the_post(); 
              $classIndex   = $i % count($colorClasses);
              $currentClass = $colorClasses[$classIndex];
      ?>
            <div class="blog-grid-item">
                            <article class="blog-card">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if ( has_post_thumbnail() ) { ?>
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
              $i++; // increment inside loop
          endwhile; 
          wp_reset_postdata();
      else :
        echo '<p>No related posts.</p>';
      endif;
      ?>
        </div>
    </div>
</section>

<?php endwhile; endif; ?>
<?php get_footer(); ?>