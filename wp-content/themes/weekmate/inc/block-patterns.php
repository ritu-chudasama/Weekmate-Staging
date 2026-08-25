<?php
/**
 * WeekMate Theme: Block Patterns
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 2.3
 */

/**
 * Register Block Pattern Category.
 */
if ( function_exists( 'register_block_pattern_category' ) ) {

	register_block_pattern_category(
		'weekmate',
		array( 'label' => __( 'WeekMate', 'weekmate' ) )
	);
}

/**
 * Register Block Patterns.
 */
if ( function_exists( 'register_block_pattern' ) ) {
	register_block_pattern(
		'weekmate/large-heading-short-description',
		array(
			'title'      => __( 'Large heading with short description', 'weekmate' ),
			'categories' => array( 'weekmate' ),
			'content'    => '<!-- wp:group {"align":"full","backgroundColor":"background"} -->
            <div class="wp-block-group alignfull has-background-background-color has-background"><div class="wp-block-group__inner-container"><!-- wp:spacer {"height":60} -->
            <div style="height:60px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->
            <!-- wp:heading {"level":6,"style":{"typography":{"lineHeight":"1.5","fontSize":35}}} -->
            <h6 style="font-size:35px;line-height:1.5"><strong>' . esc_html__( 'WeekMate is a modern take on the horizontal masthead with an optional right sidebar. It works perfectly for WordPress websites and blogs.', 'weekmate' ) . '</strong></h6>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.8"}}} -->
            <p style="line-height:1.8">' . esc_html__( 'WeekMate will make your WordPress website look beautiful everywhere. Take advantage of custom color options, beautiful default color schemes, a harmonious fluid grid using a mobile-first approach, and impeccable polish in every detail.', 'weekmate' ) . '</p>
            <!-- /wp:paragraph -->
            <!-- wp:spacer {"height":60} -->
            <div style="height:60px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer --></div></div>
            <!-- /wp:group -->',
		)
	);

	register_block_pattern(
		'weekmate/big-title-two-columns-text',
		array(
			'title'      => __( 'Big Title with Two Columns Text', 'weekmate' ),
			'categories' => array( 'weekmate' ),
			'content'    => '<!-- wp:spacer -->
            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->

            <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":55}}} -->
            <h1 style="font-size:55px">' . esc_html__( 'WeekMate', 'weekmate' ) . '</h1>
            <!-- /wp:heading -->

            <!-- wp:spacer {"height":30} -->
            <div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->

            <!-- wp:columns -->
            <div class="wp-block-columns"><!-- wp:column -->
            <div class="wp-block-column"><!-- wp:paragraph {"dropCap":true} -->
            <p class="has-drop-cap">' . esc_html__( 'WeekMate will make your WordPress website look beautiful everywhere. Take advantage of its custom color options and beautiful default color schemes.', 'weekmate' ) . '</p>
            <!-- /wp:paragraph --></div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column"><!-- wp:paragraph -->
            <p>' . esc_html__( 'The theme features a harmonious fluid grid using a mobile-first approach. The layout is a modern take on the horizontal masthead with an optional right sidebar.', 'weekmate' ) . '</p>
            <!-- /wp:paragraph --></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns -->

            <!-- wp:spacer -->
            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->',
		)
	);

	register_block_pattern(
		'weekmate/large-blockquote',
		array(
			'title'      => __( 'Large Blockquote', 'weekmate' ),
			'categories' => array( 'weekmate' ),
			'content'    => '<!-- wp:spacer -->
            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->

            <!-- wp:separator {"color":"dark-gray","className":"is-style-wide"} -->
            <hr class="wp-block-separator has-text-color has-background has-dark-gray-background-color has-dark-gray-color is-style-wide"/>
            <!-- /wp:separator -->

            <!-- wp:heading {"style":{"typography":{"lineHeight":"1.5","fontSize":40}}} -->
            <h2 style="font-size:40px;line-height:1.5"><em>' . esc_html__( 'WeekMate will make your WordPress look beautiful everywhere.', 'weekmate' ) . '</em></h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"textColor":"medium-gray"} -->
            <p class="has-medium-gray-color has-text-color">' . esc_html__( '— Takashi Irie', 'weekmate' ) . '</p>
            <!-- /wp:paragraph -->

            <!-- wp:spacer {"height":52} -->
            <div style="height:52px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->

            <!-- wp:separator {"color":"dark-gray","className":"is-style-wide"} -->
            <hr class="wp-block-separator has-text-color has-background has-dark-gray-background-color has-dark-gray-color is-style-wide"/>
            <!-- /wp:separator -->

            <!-- wp:spacer -->
            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->',
		)
	);

	register_block_pattern(
		'weekmate/call-to-action',
		array(
			'title'      => __( 'Call to Action', 'weekmate' ),
			'categories' => array( 'weekmate' ),
			'content'    => '<!-- wp:spacer -->
            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->

            <!-- wp:separator {"color":"dark-gray","className":"is-style-wide"} -->
            <hr class="wp-block-separator has-text-color has-background has-dark-gray-background-color has-dark-gray-color is-style-wide"/>
            <!-- /wp:separator -->

            <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":35,"lineHeight":"1.5"}}} -->
            <h1 style="font-size:35px;line-height:1.5">' . esc_html__( 'My new book “WeekMate” is available for pre-order.', 'weekmate' ) . '</h1>
            <!-- /wp:heading -->

            <!-- wp:columns -->
            <div class="wp-block-columns"><!-- wp:column -->
            <div class="wp-block-column"><!-- wp:buttons -->
            <div class="wp-block-buttons"><!-- wp:button {"borderRadius":0,"backgroundColor":"bright-blue"} -->
            <div class="wp-block-button"><a class="wp-block-button__link has-bright-blue-background-color has-background no-border-radius">' . esc_html__( 'Pre-Order Now', 'weekmate' ) . '</a></div>
            <!-- /wp:button --></div>
            <!-- /wp:buttons --></div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column"><!-- wp:spacer {"height":54} -->
            <div style="height:54px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer --></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns -->

            <!-- wp:spacer -->
            <div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->',
		)
	);
}
