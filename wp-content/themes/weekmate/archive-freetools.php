<?php
/**
 * The template for displaying archive pages
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

get_header(); 

// ✅ Get Blog Page ACF fields (from Options Page)
$calculator_page = get_field('calculator_page', 'option');
?>
<?php if ( $calculator_page ) : ?>
<section class="blog-hero-sec sectionCvr advtool-sec">
    <div class="container">
        <div class="row align-items-center">

            <!-- Left Column: Text + Logos + Button -->
            <div class="col-lg-6 col-md-12">
                <div class="blog-hero-content">


                    <!-- Heading -->
                    <?php if ( !empty($calculator_page['heading']) ) : ?>
                    <h1 class="blog-hero-title">
                        <?php echo esc_html($calculator_page['heading']); ?>
                    </h1>
                    <?php endif; ?>

                    <!-- Description -->
                    <?php if ( !empty($calculator_page['description']) ) : ?>
                    <p class="freetools-hero-desc">
                        <?php echo esc_html($calculator_page['description']); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Button -->
                    <?php if ( !empty($calculator_page['button']) ) : ?>
                        <a href="javascript:void(0);" id="acf-scroll-btn" class="btn btn-primary">
                            <?php echo esc_html($calculator_page['button']['title']); ?>
                        </a>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Right Column: Banner Image -->
            <div class="col-lg-6 col-md-12 text-center free-tools-archive">
                <?php if ( !empty($calculator_page['banner_image']['url']) ) : ?>
                <img src="<?php echo esc_url($calculator_page['banner_image']['url']); ?>"
                    alt="<?php echo esc_attr($calculator_page['banner_image']['alt']); ?>" class="img-fluid blog-hero-image">
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
<?php endif; ?>


<!-- calculator Listing Grid -->
<div id="scroll-target">
<section class="free_tools-listing">
    <div class="container">
        <div class="free_tools-grid">
            <?php
            $args = array(
                'post_type'      => 'freetools',
                'posts_per_page' => 9,
                'order'          => 'ASC',  
                'orderby'        => 'date',
                'paged'          => get_query_var('paged') ? get_query_var('paged') : 1
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
                        
                            <span class="free_tools-read-more"><span class="text">
                            <?php
                                $slug = get_post_field( 'post_name', get_post() );
                                echo ( $slug === 'salary-slip-generator' || $slug === 'invoice-generator' ) ? 'Generate Now' : 'Calculate Now';
                            ?>    
                            </span>
                            <span class="arrow"><img src="<?php echo get_template_directory_uri(); ?>/images/right-arrow.png" alt="icon" style="width:18px; height:auto;"></span>
                        
                        </div>
                        
                        
                    </div>
                
            </a>

            <?php endwhile; ?>
            <?php else : ?>
            <p class="no-posts">No calculators found.</p>
            <?php endif; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
</div>




<?php get_footer(); ?>

            