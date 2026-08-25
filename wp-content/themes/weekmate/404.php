<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

get_header(); ?>
<section class="404-page sectionCvr">
	<div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-9 col-md-12 col-xs-12 me-auto ms-auto">
            	<div class="title-block text-center mb-3">
            		<h1 class="title">404 - Not Found!</h1>
            	</div>
            	<div class="not-found-img mb-3">
                	<img src="<?php echo get_template_directory_uri(); ?>/images/not-found-img.png" alt="Not Found">
                </div>
                <div class="page-content text-center mt-3">
					<h2 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'weekmate' ); ?></h2>
					<p><?php _e( 'It looks like nothing was found at this location.', 'weekmate' ); ?></p>
				</div>
            </div>
        </div>
		</div>
</section>
<?php get_footer(); ?>
