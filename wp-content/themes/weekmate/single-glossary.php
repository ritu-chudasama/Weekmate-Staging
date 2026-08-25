<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

 get_header(); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- Glossary single section page hero banner -->
<section class="glossary-single-hero">
    <div class="container">

        <!-- Breadcrumb -->
        <div class="glossary-breadcrumb">
            <a href="<?php echo esc_url(get_post_type_archive_link('glossary')); ?>">
                <?php esc_html_e('Glossary', 'weekmate'); ?> 
            </a>
            <span>/</span>
            <span class="glossary-breadcrumb-single"><?php the_title(); ?></span>
        </div>

        <!-- Title -->
        <h1 class="glossary-single-title">
            <?php the_title(); ?>
        </h1>

        <!-- Meta -->
        <div class="glossary-meta">
            <?php esc_html_e('Read Time:', 'weekmate'); ?> 5 <?php esc_html_e('Mins', 'weekmate'); ?>
        </div>

        <!-- Search Bar -->
        <div class="glossary-single-search">
        <form id="glossary-single-search-form">
            <input
                type="text"
                autocomplete="off"
                autocorrect="off"
                autocapitalize="off"
                spellcheck="false"
                name="glossary_search"
                placeholder="<?php esc_attr_e('Search by keyword....', 'weekmate'); ?>"
                required
            >
            <input type="hidden" name="post_type" value="glossary">

            <button type="submit" aria-label="Search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="7"
                        stroke="currentColor" stroke-width="2"/>
                    <line x1="16.65" y1="16.65"
                        x2="21" y2="21"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round"/>
                </svg>
            </button>
        </form>
        <div id="glossary-single-suggestions"></div>
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
<?php
// Get Glossary CTA group from Site Settings
$glossary_cta = get_field('glossary_post_type_section', 'options');

// if ( ! empty($glossary_cta) && ! empty($glossary_cta['show_glossary_cta']) ) :

$heading        = $glossary_cta['glossary_cta_heading'] ?? '';
$subheading     = $glossary_cta['glossary_cta_subheading'] ?? '';
$primary_text   = $glossary_cta['glossary_primary_button_text'] ?? '';
$primary_link   = $glossary_cta['glossary_primary_button_link'] ?? '';
$secondary_text = $glossary_cta['glossary_secondary_button_text'] ?? '';
$secondary_link = $glossary_cta['glossary_secondary_button_link'] ?? '';
?>

<section class="glossary-bottom-cta">
    <div class="container">
        <div class="glossary-bottom-cta__inner">

            <?php if ( $heading ) : ?>
                <h2 class="glossary-bottom-cta__title">
                    <?php echo esc_html( $heading ); ?>
                </h2>
            <?php endif; ?>

            <?php if ( $subheading ) : ?>
                <p class="glossary-bottom-cta__text">
                    <?php echo esc_html( $subheading ); ?>
                </p>
            <?php endif; ?>

            <div class="glossary-bottom-cta__buttons">
                <?php if ( $primary_text && $primary_link ) : ?>
                    <a href="<?php echo esc_url( $primary_link ); ?>"
                       class="glossary-btn glossary-btn--primary">
                        <?php echo esc_html( $primary_text ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( $secondary_text && $secondary_link ) : ?>
                    <a href="<?php echo esc_url( $secondary_link ); ?>"
                       class="glossary-btn glossary-btn--outline">
                        <?php echo esc_html( $secondary_text ); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>


<?php endwhile; endif; ?>
<?php get_footer(); ?>