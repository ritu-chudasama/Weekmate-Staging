<?php
/**
 * Template Name: New Product Page
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

$colorClasses = [
    "light-mint-bg-clr",
    "soft-peach-bg-clr",
    "light-ivory-bg-clr",
    "sky-blue-bg-clr",
    "lavender-mist-bg-clr",
    "off-white-bg-clr",
    "light-lavender-bg-clr"
];

get_header();

if ( have_rows('page_sections') ) :
    while ( have_rows('page_sections') ) : the_row();

        $layout = get_row_layout();

        $section_file = get_template_directory() . '/template-parts/new-product-page-template/' . $layout . '.php';

        if ( file_exists($section_file) ) {
            include $section_file;
        }

    endwhile;
endif;

get_footer();