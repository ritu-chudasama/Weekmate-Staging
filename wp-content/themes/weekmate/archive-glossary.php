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
<section class="glossary-hero-sec">
     <div class="container">

        <!-- Title -->
        <div class="glossary-title text-center">
            <h1><?php esc_html_e('HR Glossary', 'weekmate'); ?></h1>
            <p><?php esc_html_e('Simple definitions of HR terms, policies, and concepts.', 'weekmate'); ?></p>
        </div>

        <!-- Search Bar -->
        <div class="glossary-search">
            <form id="glossary-search-form">
            <input
                type="text"
                id="glossary-search-input"
                placeholder="<?php esc_attr_e('Search by keyword...', 'weekmate'); ?>"
            >
                <button type="submit" aria-label="Search">
                    <svg width="18" height="18" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="7"
                                stroke="currentColor" stroke-width="2"/>
                        <line x1="16.65" y1="16.65"
                            x2="21" y2="21"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- A to Z Filter -->
                <?php
        // Get all glossary posts (only titles needed)
        $args = array(
            'post_type'      => 'glossary',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'suppress_filters' => false,
        );

        $query = new WP_Query($args);

        $available_letters = [];

        if ( $query->have_posts() ) {
            foreach ( $query->posts as $post_id ) {
                $title = get_the_title( $post_id );
                $letter = strtoupper( mb_substr( $title, 0, 1 ) );

                if ( preg_match('/^[A-Z]$/', $letter ) ) {
                    $available_letters[ $letter ] = true;
                }
            }
        }
        wp_reset_postdata();
        ?>

        <div class="glossary-az-filter">
            <ul>
                <?php foreach ( range('A', 'Z') as $letter ) : ?>
                    <?php if ( empty( $available_letters[ $letter ] ) ) continue; ?>
                    <li>
                        <a href="#"
                        class="glossary-letter"
                        data-letter="<?php echo esc_attr( $letter ); ?>">
                            <?php echo esc_html( $letter ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <!-- ✅ ALL BUTTON -->
                <li>
                    <a href="#"
                    class="glossary-letter glossary-all active"
                    data-letter="">
                        All
                    </a>
                </li>
            </ul>
        </div>


            </div>
        </section>
        <?php endif; ?>


<!-- calculator Listing Grid -->
<div id="scroll-target">
<section class="glossary-listing-sec">
    <div class="container">

        <div id="glossary-results">
            <div class="glossary-grid">

                <?php
                // Loop through A to Z
                foreach (range('A', 'Z') as $letter) :

                    // Query glossary posts starting with this letter
                    $args = array(
                        'post_type'      => 'glossary',
                        'posts_per_page' => -1,
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                        'suppress_filters' => false,
                    );

                    $query = new WP_Query($args);

                    $matched_posts = array();

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();

                            // Get first letter of title
                            $first_letter = strtoupper(mb_substr(get_the_title(), 0, 1));

                            if ($first_letter === $letter) {
                                $matched_posts[] = get_the_ID();
                            }

                        endwhile;
                    endif;

                    wp_reset_postdata();

                    // If no posts for this letter, skip column
                    if (empty($matched_posts)) {
                        continue;
                    }
                ?>

                    <div class="glossary-col" id="letter-<?php echo esc_attr($letter); ?>">
                        <h3><?php echo esc_html($letter); ?></h3>
                        <ul>
                            <?php
                            foreach ($matched_posts as $post_id) :
                            ?>
                                <li>
                                    <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                                        <?php echo esc_html(get_the_title($post_id)); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>

    </div>
</section>

</div>



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




<?php get_footer(); ?>

            