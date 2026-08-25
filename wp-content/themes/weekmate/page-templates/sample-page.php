<?php
/**
 * Template Name: CMS Page
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */
//echo get_page_link(351);
//echo get_template_directory_uri();
get_header(); 
?>
<section class="sectionCvr cms-pages">
    <div class="container">
        <?php the_content(); ?>
    </div>
</section>


<?php
get_footer();