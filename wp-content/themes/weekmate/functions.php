<?php
/**
 * WeekMate functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://developer.wordpress.org/plugins/}
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

/**
 * WeekMate only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'weekmate_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own weekmate_setup() function to override in a child theme.
	 *
	 * @since WeekMate 1.0
	 */
	function weekmate_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/weekmate
		 * If you're building a theme based on WeekMate, use a find and replace
		 * to change 'weekmate' to the name of your theme in all the template files.
		 *
		 * Manual loading of text domain is not required after the introduction of
		 * just in time translation loading in WordPress version 4.6.
		 *
		 * @ticket 58318
		 */
		if ( version_compare( $GLOBALS['wp_version'], '4.6', '<' ) ) {
			load_theme_textdomain( 'weekmate' );
		}

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 *
		 *  @since WeekMate 1.2
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 240,
				'width'       => 240,
				'flex-height' => true,
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'weekmate' ),
				'social'  => __( 'Social Links Menu', 'weekmate' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://developer.wordpress.org/advanced-administration/wordpress/post-formats/
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'status',
				'audio',
				'chat',
			)
		);

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width. When fonts are
		 * self-hosted, the theme directory needs to be removed first.
		 */
		$font_stylesheet = str_replace(
			array( get_template_directory_uri() . '/', get_stylesheet_directory_uri() . '/' ),
			'',
			(string) weekmate_fonts_url()
		);
		add_editor_style( array( 'css/editor-style.css', $font_stylesheet ) );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom color scheme.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Dark Gray', 'weekmate' ),
					'slug'  => 'dark-gray',
					'color' => '#1a1a1a',
				),
				array(
					'name'  => __( 'Medium Gray', 'weekmate' ),
					'slug'  => 'medium-gray',
					'color' => '#686868',
				),
				array(
					'name'  => __( 'Light Gray', 'weekmate' ),
					'slug'  => 'light-gray',
					'color' => '#e5e5e5',
				),
				array(
					'name'  => __( 'White', 'weekmate' ),
					'slug'  => 'white',
					'color' => '#fff',
				),
				array(
					'name'  => __( 'Blue Gray', 'weekmate' ),
					'slug'  => 'blue-gray',
					'color' => '#4d545c',
				),
				array(
					'name'  => __( 'Bright Blue', 'weekmate' ),
					'slug'  => 'bright-blue',
					'color' => '#007acc',
				),
				array(
					'name'  => __( 'Light Blue', 'weekmate' ),
					'slug'  => 'light-blue',
					'color' => '#9adffd',
				),
				array(
					'name'  => __( 'Dark Brown', 'weekmate' ),
					'slug'  => 'dark-brown',
					'color' => '#402b30',
				),
				array(
					'name'  => __( 'Medium Brown', 'weekmate' ),
					'slug'  => 'medium-brown',
					'color' => '#774e24',
				),
				array(
					'name'  => __( 'Dark Red', 'weekmate' ),
					'slug'  => 'dark-red',
					'color' => '#640c1f',
				),
				array(
					'name'  => __( 'Bright Red', 'weekmate' ),
					'slug'  => 'bright-red',
					'color' => '#ff675f',
				),
				array(
					'name'  => __( 'Yellow', 'weekmate' ),
					'slug'  => 'yellow',
					'color' => '#ffef8e',
				),
			)
		);

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );
	}
endif; // weekmate_setup()
add_action( 'after_setup_theme', 'weekmate_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since WeekMate 1.0
 */
function weekmate_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'weekmate_content_width', 840 );
}
add_action( 'after_setup_theme', 'weekmate_content_width', 0 );

/**
 * Add preconnect for Google Fonts.
 *
 * @since WeekMate 1.6
 * @deprecated WeekMate 2.9 Disabled filter because, by default, fonts are self-hosted.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function weekmate_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'weekmate-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
// add_filter( 'wp_resource_hints', 'weekmate_resource_hints', 10, 2 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since WeekMate 1.0
 */
function weekmate_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'weekmate' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'weekmate' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Content Bottom 1', 'weekmate' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'weekmate' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Content Bottom 2', 'weekmate' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'weekmate' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'weekmate_widgets_init' );

if ( ! function_exists( 'weekmate_fonts_url' ) ) :
	/**
	 * Register fonts for WeekMate.
	 *
	 * Create your own weekmate_fonts_url() function to override in a child theme.
	 *
	 * @since WeekMate 1.0
	 * @since WeekMate 2.9 Replaced Google URL with self-hosted fonts.
	 *
	 * @return string Fonts URL for the theme.
	 */
	function weekmate_fonts_url() {
		$fonts_url = '';
		$fonts     = array();

		/*
		 * translators: If there are characters in your language that are not supported
		 * by Merriweather, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'weekmate' ) ) {
			$fonts[] = 'merriweather';
		}

		/*
		 * translators: If there are characters in your language that are not supported
		 * by Montserrat, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'weekmate' ) ) {
			$fonts[] = 'montserrat';
		}

		/*
		 * translators: If there are characters in your language that are not supported
		 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'weekmate' ) ) {
			$fonts[] = 'inconsolata';
		}

		if ( $fonts ) {
			$fonts_url = get_template_directory_uri() . '/fonts/' . implode( '-plus-', $fonts ) . '.css';
		}

		return $fonts_url;
	}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since WeekMate 1.0
 */
function weekmate_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'weekmate_javascript_detection', 0 );

function weekmate_asset_version( $relative_path ) {
    $file = get_template_directory() . $relative_path;
    return file_exists( $file ) ? filemtime( $file ) : '1.0';
}

/**
 * Enqueues scripts and styles.
 *
 * @since WeekMate 1.0
 */
function weekmate_scripts() {
	// Add custom fonts, used in the main stylesheet.
	$font_version = ( 0 === strpos( (string) weekmate_fonts_url(), get_template_directory_uri() . '/' ) ) ? '20230328' : null;
	wp_enqueue_style( 'weekmate-fonts', weekmate_fonts_url(), array(), $font_version );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '20201208' );

	// Theme stylesheet.
	wp_enqueue_style( 'weekmate-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Theme block stylesheet.
	wp_enqueue_style( 'weekmate-block-style', get_template_directory_uri() . '/css/blocks.css', array( 'weekmate-style' ), weekmate_asset_version( '/css/blocks.css' ) );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'weekmate-ie', get_template_directory_uri() . '/css/ie.css', array( 'weekmate-style' ), '20170530' );
	wp_style_add_data( 'weekmate-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'weekmate-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'weekmate-style' ), '20170530' );
	wp_style_add_data( 'weekmate-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'weekmate-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'weekmate-style' ), '20170530' );
	wp_style_add_data( 'weekmate-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'weekmate-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'weekmate-html5', 'conditional', 'lt IE 9' );

	// Skip-link fix is no longer enqueued by default.
	wp_register_script( 'weekmate-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20230526', array( 'in_footer' => true ) );

    // City page template — CSS and JS.
    if ( is_page_template( array( 'page-templates/city-page-template.php', 'page-templates/city-page.php' ) ) || wmcp_is_city_page_url()  ) {
        wp_enqueue_style(
            'wmcp-city-page',
            get_template_directory_uri() . '/css/city-page.css',
            array( 'weekmate-style' ),
            weekmate_asset_version( '/css/city-page.css' )
        );
        wp_enqueue_script(
            'wmcp-city-hydrate',
            get_template_directory_uri() . '/js/city-page-hydrate.js',
            array(),
            weekmate_asset_version( '/js/city-page-hydrate.js' ),
            true
        );
    }

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'weekmate-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20170530' );
	}

    if ( is_singular('partner') ) {
        wp_enqueue_style( 'weekmate-partner', get_template_directory_uri() . '/css/weekmate-partner.css', array(), weekmate_asset_version( '/css/weekmate-partner.css' ) );
    }

	if (is_page_template('page-templates/product-page.php') || is_page_template('page-templates/new-product-page.php')) {
		wp_enqueue_style( 'product-page-tamplate', get_template_directory_uri() . '/css/product-page.css', array( 'weekmate-style' ), weekmate_asset_version( '/css/product-page.css' ) );
	}
	if (is_page_template('page-templates/cotact-us.php')) {
		wp_enqueue_style( 'contact-us-page-tamplate', get_template_directory_uri() . '/css/contact-us.css', array( 'weekmate-style' ), weekmate_asset_version( '/css/contact-us.css' ) );
	}
	if (is_page_template('page-templates/about-us.php')) {
		wp_enqueue_style( 'about-us-page-tamplate', get_template_directory_uri() . '/css/about-us.css', array( 'weekmate-style' ), weekmate_asset_version( '/css/about-us.css' ) );
	}
    if (is_page_template('page-templates/onboarding.php')|| is_post_type_archive('news-events')) {
		wp_enqueue_style( 'onboarding-page-tamplate', get_template_directory_uri() . '/css/weekmate-onboarding.css', array( 'weekmate-style' ), weekmate_asset_version( '/css/weekmate-onboarding.css' ) );
	}
	if (is_page_template('page-templates/become-partner.php')) {
		wp_enqueue_style( 'become-partner-tamplate', get_template_directory_uri() . '/css/contact-us.css', array( 'weekmate-style' ), weekmate_asset_version( '/css/contact-us.css' ) );
	}
	if (is_page_template('page-templates/partner-page.php') || is_singular('partner') || is_post_type_archive( 'partner' )) {
		wp_enqueue_style( 'partner-page-tamplate', get_template_directory_uri() . '/css/partner-page.css', array( 'weekmate-style' ), weekmate_asset_version( '/css/partner-page.css' ) );
	}

    if (is_page_template('page-templates/integration-page.php')) {
        wp_enqueue_style('weekmate-integration', get_template_directory_uri() . '/css/weekmate-integration.css', array('weekmate-style'), weekmate_asset_version('/css/weekmate-integration.css'));
        wp_enqueue_script('weekmate-integration', get_template_directory_uri() . '/js/weekmate-integration.js', array(), weekmate_asset_version('/js/weekmate-integration.js'), true);
    }

    
    if ( is_post_type_archive('news-events') || is_singular('news-events')) {
    wp_enqueue_style( 'news-event-page-style', get_template_directory_uri() . '/css/weekmate-news-event.css', array('weekmate-style'), weekmate_asset_version('/css/weekmate-news-event.css') );
    
    // Enqueue AJAX script for archive page only
    if (is_post_type_archive('news-events')) {
        wp_enqueue_script(
            'news-ajax',
            get_template_directory_uri() . '/js/news-events.js',
            array('jquery'),
            weekmate_asset_version('/js/news-events.js'),
            true
        );
        
        wp_localize_script('news-ajax', 'newsAjax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('news_load_more_nonce')
        ));
    }
    }
	if ( is_post_type_archive('glossary') || is_singular('glossary')) {
        wp_enqueue_style( 'glossary-page-style', get_template_directory_uri() . '/css/weekmate-glossary.css', array('weekmate-style'), weekmate_asset_version('/css/weekmate-glossary.css') );

         wp_enqueue_script(
            'glossary-ajax',
            get_template_directory_uri() . '/js/weekmate-glossary.js',
            array('jquery'),
            filemtime( get_template_directory() . '/js/weekmate-glossary.js' ),
            true
        );

        wp_localize_script(
        'glossary-ajax',
        'glossaryAjax',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('glossary_search_nonce'),
        )
        );

    }

	wp_enqueue_script(
		'weekmate-script',
		get_template_directory_uri() . '/js/functions.js',
		array( 'jquery' ),
		weekmate_asset_version('/js/functions.js'),
		array(
			'in_footer' => false, // Because involves header.
			'strategy'  => 'defer',
		)
	);

	wp_localize_script(
		'weekmate-script',
		'screenReaderText',
		array(
			'expand'   => __( 'expand child menu', 'weekmate' ),
			'collapse' => __( 'collapse child menu', 'weekmate' ),
		)
	);

	//JS for POPUP form
    wp_enqueue_script('weekmate-popup-js', get_template_directory_uri() . '/js/weekmate-popup.js', array('jquery', 'contact-form-7'), weekmate_asset_version('/js/weekmate-popup.js'), true);

	// CSS for POPUP form
    wp_enqueue_style('weekmate-popup-css', get_template_directory_uri() . '/css/weekmate-popup.css', array(), weekmate_asset_version('/css/weekmate-popup.css'));
    
	// JS for Calculator 
	wp_enqueue_script('calculator-shortcode-js', get_template_directory_uri() . '/js/freetools-calculator.js', array(), weekmate_asset_version('/js/freetools-calculator.js'), true);
	// CSS for Calculator
    wp_enqueue_style('salary-calculator-css', get_template_directory_uri() . '/css/freetools-calculator.css', array(), weekmate_asset_version('/css/freetools-calculator.css'));


    if (is_page('pricing')) {
        wp_enqueue_script('pricing-page-js', get_template_directory_uri() . '/js/pricing-page.js', array(), weekmate_asset_version('/js/pricing-page.js'), true);
    }

	if ( is_home() ) {

		wp_enqueue_script('home-blog-filter', get_template_directory_uri() . '/js/blog-filter.js', array('jquery'), weekmate_asset_version('/js/blog-filter.js'), true);

		wp_localize_script(
			'home-blog-filter',
			'homeBlogFilter',
			array(
				'ajaxurl' => admin_url('admin-ajax.php')
			)
		);
	}

	// CSS for Author
    wp_enqueue_style('weekmate-author-css', get_template_directory_uri() . '/css/weekmate-author.css', array(), weekmate_asset_version('/css/weekmate-author.css'));

    if ( is_page_template( 'page-templates/wage-rule.php' ) ) {
        wp_enqueue_style(
            'wage-rule',
            get_template_directory_uri() . '/css/wage-rule.css',
            [],
            weekmate_asset_version('/css/wage-rule.css')
        );
        wp_enqueue_script(
            'wage-rulejs',
            get_template_directory_uri() . '/js/wage-rule.js',
            [],
            weekmate_asset_version('/js/wage-rule.js'),
            true // load in footer
        );
    }

	//Js for Author
	if (is_author()) {
    

    wp_enqueue_script(
        'author-load-more',
        get_template_directory_uri() . '/js/weekmate-author.js',
        [],
        weekmate_asset_version('/js/weekmate-author.js'),
        true
    );

    wp_localize_script(
        'author-load-more',
        'authorLoadMore',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]
    );
    }
	if(is_page('hrms-payroll-software')){
        wp_enqueue_script(
        'mira-ai-video',
        get_template_directory_uri() . '/js/mira-ai.js',
        [],
        weekmate_asset_version('/js/mira-ai.js'),
        true
    );
    }
}
add_action( 'wp_enqueue_scripts', 'weekmate_scripts' );

/**
 * Enqueue styles for the block-based editor.
 *
 * @since WeekMate 1.6
 */
function weekmate_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'weekmate-block-editor-style', get_template_directory_uri() . '/css/editor-blocks.css', array(), '20241202' );
	// Add custom fonts.
	$font_version = ( 0 === strpos( (string) weekmate_fonts_url(), get_template_directory_uri() . '/' ) ) ? '20230328' : null;
	wp_enqueue_style( 'weekmate-fonts', weekmate_fonts_url(), array(), $font_version );
}
add_action( 'enqueue_block_editor_assets', 'weekmate_block_editor_styles' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since WeekMate 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function weekmate_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'weekmate_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since WeekMate 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function weekmate_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

//Enqueing POPUP form
require get_template_directory() . '/functions/popup-functions.php';

require get_template_directory() . '/functions/tracking-info-functions.php';

//Enqueing Freetools shortcode 
require get_template_directory() . '/functions/calculator-function.php';


function wmcp_is_city_page_url()
{
    if (! isset($_SERVER['REQUEST_URI'])) {
        return false;
    }
    $path = trim(parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH), '/');
    return (bool) preg_match('#(payroll|hr)-software-in-[^/]+#', $path);
}

/**
 * Register block patterns and pattern categories.
 *
 * @since WeekMate 3.4
 */
function weekmate_register_block_patterns() {
	require get_template_directory() . '/inc/block-patterns.php';
}

add_action( 'init', 'weekmate_register_block_patterns' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Schema and articles additions for Blog Posts.
 */
require get_template_directory() . '/functions/schema-functions.php';
require get_template_directory() . '/functions/og-image-functions.php';


require get_template_directory() . '/functions/city-page-functions.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since WeekMate 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function weekmate_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 840 <= $width ) {
		$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
	}

	if ( 'page' === get_post_type() ) {
		if ( 840 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	} else {
		if ( 840 > $width && 600 <= $width ) {
			$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		} elseif ( 600 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'weekmate_content_image_sizes_attr', 10, 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since WeekMate 1.0
 *
 * @param string[]     $attr       Array of attribute values for the image markup, keyed by attribute name.
 *                                 See wp_get_attachment_image().
 * @param WP_Post      $attachment Image attachment post.
 * @param string|int[] $size       Requested image size. Can be any registered image size name, or
 *                                 an array of width and height values in pixels (in that order).
 * @return string[] The filtered attributes for the image markup.
 */
function weekmate_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		} else {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
		}
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'weekmate_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since WeekMate 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function weekmate_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'weekmate_widget_tag_cloud_args' );

add_filter('use_block_editor_for_post', '__return_false', 10);

// acf option page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Site Settings',
        'menu_title'    => 'Site Settings',
        'menu_slug'     => 'site-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

// Hook for sending email and genrate Unique ID
add_action('wpcf7_before_send_mail', 'add_serial_number_mail');
function add_serial_number_mail($WPCF7_ContactForm)
{
    $wpcf7 = WPCF7_ContactForm::get_current();
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $posted_data = $submission->get_posted_data();
        // nothing's here... do nothing...
        if (empty($posted_data))
            return;

        $mail = $WPCF7_ContactForm->prop('mail');
        $mail['subject'] = $mail['subject'] . ' #' . mt_rand(100000, 999999);
        // Save the email body
        $WPCF7_ContactForm->set_properties(array("mail" => $mail));
        return $WPCF7_ContactForm;
    }
}

function wee_fetch_url($url) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // timeout in seconds
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    if ($response === false || $http_code !== 200) {
        // Log error or handle gracefully
        echo "Failed to fetch URL. HTTP Code: $http_code. cURL Error: $curl_error";
        return false;
    }

    return $response;
}
// Change default "post" permalinks to use /blog/ prefix
// Change default "post" permalinks to use /blog/ base
function elsner_set_post_permalinks() {
    global $wp_post_types;

    // Check if "post" type exists
    if ( isset( $wp_post_types['post'] ) ) {
        $args = $wp_post_types['post'];

        // Force new rewrite
        $args->rewrite = array(
            'slug'       => 'blog',
            'with_front' => false,
            'feeds'      => true,
            'pages'      => true,
        );

        // Re-register with updated args
        register_post_type( 'post', (array) $args );
    }
}
add_action( 'init', 'elsner_set_post_permalinks', 1 );



// Add /blog/ slug only for default posts
function add_blog_prefix_to_post_permalinks( $permalink, $post, $leavename ) {
    if ( $post->post_type === 'post' ) {
        
        $permalink = home_url( '/blog/' . $post->post_name . '/' );

        if( $post->post_status == 'draft' ){
            //print_r($post);
            $permalink = home_url( '/?p=' . $post->ID . '&preview=true' );
            return $permalink;
        }
        //echo  '-------------';
        //echo $permalink;
        return $permalink;
    }
    return $permalink;
}
add_filter( 'post_link', 'add_blog_prefix_to_post_permalinks', 10, 3 );

// Rewrite rules for blog posts (including preview support)
function add_blog_prefix_to_post_rewrite_rules( $rules ) {
    $new_rules = array(
        'blog/([^/]+)/?$' => 'index.php?post_type=post&name=$matches[1]',
        'blog/([^/]+)/?$' => 'index.php?name=$matches[1]', // ensures preview works too
        'blog/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?name=$matches[1]&feed=$matches[2]',
        'blog/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?name=$matches[1]&feed=$matches[2]',
        'blog/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?name=$matches[1]&cpage=$matches[2]',
    );
    return $new_rules + $rules;
}
add_filter( 'rewrite_rules_array', 'add_blog_prefix_to_post_rewrite_rules' );
// Register Case Studies CPT
function register_case_studies_cpt() {
    $labels = array(
        'name'               => 'Case Studies',
        'singular_name'      => 'Case Study',
        'menu_name'          => 'Case Studies',
        'name_admin_bar'     => 'Case Study',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Case Study',
        'new_item'           => 'New Case Study',
        'edit_item'          => 'Edit Case Study',
        'view_item'          => 'View Case Study',
        'all_items'          => 'All Case Studies',
        'search_items'       => 'Search Case Studies',
        'not_found'          => 'No case studies found.',
        'not_found_in_trash' => 'No case studies found in Trash.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'case-studies' ),
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'       => true, 
    );

    register_post_type( 'case_study', $args );
}
add_action( 'init', 'register_case_studies_cpt' );


// Register News Event CPT 
function register_news_event_post_type() {
    $labels = array(
        'name'                  => _x('News Events', 'Post Type General Name', 'weekmate'),
        'singular_name'         => _x('News Event', 'Post Type Singular Name', 'weekmate'),
        'menu_name'             => __('News Events', 'weekmate'),
        'name_admin_bar'        => __('News Event', 'weekmate'),
        'archives'              => __('News Event Archives', 'weekmate'),
        'attributes'            => __('News Event Attributes', 'weekmate'),
        'parent_item_colon'     => __('Parent News Event:', 'weekmate'),
        'all_items'             => __('All News Events', 'weekmate'),
        'add_new_item'          => __('Add New News Event', 'weekmate'),
        'add_new'               => __('Add New', 'weekmate'),
        'new_item'              => __('New News Event', 'weekmate'),
        'edit_item'             => __('Edit News Event', 'weekmate'),
        'update_item'           => __('Update News Event', 'weekmate'),
        'view_item'             => __('View News Event', 'weekmate'),
        'view_items'            => __('View News Events', 'weekmate'),
        'search_items'          => __('Search News Event', 'weekmate'),
        'not_found'             => __('Not found', 'weekmate'),
        'not_found_in_trash'    => __('Not found in Trash', 'weekmate'),
        'featured_image'        => __('Featured Image', 'weekmate'),
        'set_featured_image'    => __('Set featured image', 'weekmate'),
        'remove_featured_image' => __('Remove featured image', 'weekmate'),
        'use_featured_image'    => __('Use as featured image', 'weekmate'),
        'insert_into_item'      => __('Insert into news event', 'weekmate'),
        'uploaded_to_this_item' => __('Uploaded to this news event', 'weekmate'),
        'items_list'            => __('News Events list', 'weekmate'),
        'items_list_navigation' => __('News Events list navigation', 'weekmate'),
        'filter_items_list'     => __('Filter news events list', 'weekmate'),
    );

    $args = array(
        'label'                 => __('News Event', 'weekmate'),
        'description'           => __('News and Product Updates', 'weekmate'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-megaphone',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array('slug' => 'news-events'),
    );

    register_post_type('news-events', $args);
}
add_action('init', 'register_news_event_post_type', 0);

/**
 * Register Glossary CPT
 */
function register_glossary_cpt() {

    $labels = array(
        'name'               => __('Glossary', 'weekmate'),
        'singular_name'      => __('Glossary Term', 'weekmate'),
        'menu_name'          => __('Glossary', 'weekmate'),
        'name_admin_bar'     => __('Glossary Term', 'weekmate'),
        'add_new'            => __('Add New', 'weekmate'),
        'add_new_item'       => __('Add New Term', 'weekmate'),
        'new_item'           => __('New Term', 'weekmate'),
        'edit_item'          => __('Edit Term', 'weekmate'),
        'view_item'          => __('View Term', 'weekmate'),
        'all_items'          => __('All Terms', 'weekmate'),
        'search_items'       => __('Search Terms', 'weekmate'),
        'not_found'          => __('No terms found.', 'weekmate'),
        'not_found_in_trash' => __('No terms found in Trash.', 'weekmate'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-book',
        'supports'           => array(
            'title',    // Glossary term
            'editor',   // Definition
            'excerpt',  // Short definition
        ),
        'has_archive'        => true,
        'rewrite'            => array(
            'slug' => 'glossary',
        ),
        'show_in_rest'       => true, // Gutenberg + API
        'publicly_queryable' => true,
        'exclude_from_search'=> false,
    );

    register_post_type('glossary', $args);
}
add_action('init', 'register_glossary_cpt');


// Register Partners CPT
function register_partners_cpt() {
    $labels = array(
        'name'               => 'Partners',
        'singular_name'      => 'Partner',
        'menu_name'          => 'Partners',
        'name_admin_bar'     => 'Partner',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Partner',
        'new_item'           => 'New Partner',
        'edit_item'          => 'Edit Partner',
        'view_item'          => 'View Partner',
        'all_items'          => 'All Partners',
        'search_items'       => 'Search Partners',
        'not_found'          => 'No partners found.',
        'not_found_in_trash' => 'No partners found in Trash.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'partners' ),
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'       => true,
        // Remove 'taxonomies' => array( 'country' ), from here
    );

    register_post_type( 'partner', $args );
}
add_action( 'init', 'register_partners_cpt' );
// Register Free Tools CPT
function register_freetools_cpt() {

    $labels = array(
        'name'               => 'Free Tools',
        'singular_name'      => 'Free Tool',
        'menu_name'          => 'Free Tools',
        'add_new'            => 'Add New Tool',
        'add_new_item'       => 'Add New Tool',
        'edit_item'          => 'Edit Tool',
        'view_item'          => 'View Tool',
        'all_items'          => 'All Tools',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
		'rewrite'            => array('slug' => 'freetools'),
        'supports'           => array('title', 'editor', 'thumbnail','excerpt', 'author'),
        'menu_icon'          => 'dashicons-calculator',
    );

    register_post_type('freetools', $args);
}

add_action('init', 'register_freetools_cpt');

// Register Country Custom Taxonomy For Partners Post Type
function register_country_taxonomy() {
    $labels = array(
        'name'              => 'Countries',
        'singular_name'     => 'Country',
        'search_items'      => 'Search Countries',
        'all_items'         => 'All Countries',
        'parent_item'       => 'Parent Country',
        'parent_item_colon' => 'Parent Country:',
        'edit_item'         => 'Edit Country',
        'update_item'       => 'Update Country',
        'add_new_item'      => 'Add New Country',
        'new_item_name'     => 'New Country Name',
        'menu_name'         => 'Countries',
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true, // Use true for categories, false for tags
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'country' ),
    );

    // This is the correct way to register the taxonomy and associate it with the 'partner' CPT
    register_taxonomy( 'country', 'partner', $args );
}
add_action( 'init', 'register_country_taxonomy' );

function filter_partners() {
    $tax_query = array('relation' => 'AND');
    $meta_query = array('relation' => 'AND');
    $search_query = '';
    $selected_countries = [];

    // Filter by country
    if (isset($_POST['country']) && !empty($_POST['country'])) {
        $selected_countries = explode(',', sanitize_text_field($_POST['country']));
        $tax_query[] = array(
            'taxonomy' => 'country',
            'field'    => 'slug',
            'terms'    => $selected_countries,
        );
    }

    // Search by title
    if (isset($_POST['s']) && !empty($_POST['s'])) {
        $search_query = sanitize_text_field($_POST['s']);
    }

    $args = array(
        'post_type'      => 'partner',
		'posts_per_page' => -1,
		'tax_query'      => $tax_query,
		's'              => $search_query,
    );

    $query = new WP_Query($args);
    ob_start(); // Start output buffering to capture the HTML

    if ($query->have_posts()) {
        partner_query_html($query);
        wp_reset_postdata();
    } else {
        echo '<p class="no-results-message col-12">No partners found for your selected filters.</p>';
    }

    $response = ob_get_clean(); // Get the HTML from the buffer
    
    echo json_encode(array(
        'html' => $response,
        'countries' => $selected_countries
    ));
    
    die();
}
add_action('wp_ajax_filter_partners', 'filter_partners');
add_action('wp_ajax_nopriv_filter_partners', 'filter_partners');


function partner_query_html($query){
	while ($query->have_posts()) {
		$query->the_post();
		$partner_details = get_field('partner_post_list_detail');
		if ($partner_details) {
			$logo_section = $partner_details['logo_section'] ?? [];
			$logo1        = $logo_section['logo_1'] ?? null;
			$logo2        = $logo_section['logo_2'] ?? null;
			$heading      = $partner_details['heading'];
			$location     = $partner_details['location'];
			$website_url  = $partner_details['website_url'];

			// Partner card HTML
			?>
			<div class="col-xxl-4 col-lg-6 card-item">
				<div class="partners-card-item">
					<?php if ($logo1) : ?>
					<div class="company-logo">
						<a href="<?php the_permalink(); ?>"> <img src="<?php echo esc_url($logo1['url']); ?>"
								alt="<?php echo esc_attr($logo1['alt']); ?>"> </a>
					</div>
					<?php endif; ?>
					<div class="partners-card-content">
						<div class="partners-card-title">
							<h4><?php echo esc_html($heading ?: get_the_title()); ?></h4>
						</div>

						<ul>
							<?php if ($location) : ?>
							<li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
										fill="none">
										<path
											d="M7.8372 13.1835C9.0601 11.6265 11.8492 7.85301 11.8492 5.73343C11.8492 3.16277 9.79908 1.07715 7.27224 1.07715C4.74539 1.07715 2.69531 3.16277 2.69531 5.73343C2.69531 7.85301 5.48438 11.6265 6.70727 13.1835C7.00048 13.5545 7.54399 13.5545 7.8372 13.1835ZM7.27224 4.18134C7.67686 4.18134 8.06491 4.34486 8.35103 4.63593C8.63714 4.92701 8.79788 5.32179 8.79788 5.73343C8.79788 6.14507 8.63714 6.53985 8.35103 6.83093C8.06491 7.122 7.67686 7.28552 7.27224 7.28552C6.86761 7.28552 6.47956 7.122 6.19344 6.83093C5.90733 6.53985 5.74659 6.14507 5.74659 5.73343C5.74659 5.32179 5.90733 4.92701 6.19344 4.63593C6.47956 4.34486 6.86761 4.18134 7.27224 4.18134Z"
											fill="#383838" />
									</svg><span class="icon-text"><?php echo esc_html($location); ?></span></a></li>
							<?php endif; ?>
							<?php if ($website_url) : ?>
							<?php 
							if (strpos($website_url, 'http') !== 0) {
								$website_url = 'https://' . $website_url;
							}
							?>
							<li>
								<a href="<?php echo esc_url($website_url); ?>" target="_blank" rel="noopener">
									<span class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"
											fill="none">
											<path
												d="M9.6226 7.68929H4.38015C4.45979 9.46057 4.85249 11.0918 5.40997 12.2864C5.72303 12.9592 6.06081 13.4343 6.37387 13.7254C6.68144 14.0137 6.8929 14.0604 7.00275 14.0604C7.11259 14.0604 7.32405 14.0137 7.63162 13.7254C7.94468 13.4343 8.28246 12.9565 8.59553 12.2864C9.153 11.0918 9.5457 9.46057 9.62534 7.68929H9.6226ZM4.3774 6.37113H9.61985C9.54296 4.59984 9.15026 2.96862 8.59278 1.77403C8.27972 1.10396 7.94194 0.626128 7.62887 0.335033C7.3213 0.0466849 7.10985 0 7 0C6.89015 0 6.6787 0.0466849 6.37113 0.335033C6.05806 0.626128 5.72028 1.10396 5.40722 1.77403C4.84974 2.96862 4.45704 4.59984 4.3774 6.37113ZM3.05924 6.37113C3.15535 4.0204 3.76226 1.83719 4.64927 0.403688C2.12005 1.29894 0.25814 3.60298 0 6.37113H3.05924ZM0 7.68929C0.25814 10.4574 2.12005 12.7615 4.64927 13.6567C3.76226 12.2232 3.15535 10.04 3.05924 7.68929H0ZM10.9408 7.68929C10.8446 10.04 10.2377 12.2232 9.35073 13.6567C11.88 12.7587 13.7419 10.4574 14 7.68929H10.9408ZM14 6.37113C13.7419 3.60298 11.88 1.29894 9.35073 0.403688C10.2377 1.83719 10.8446 4.0204 10.9408 6.37113H14Z"
												fill="#383838" />
										</svg>
									</span>
									<span class="icon-text">
										<?php echo esc_html(parse_url($website_url, PHP_URL_HOST)); ?>
									</span>
								</a>
							</li>
							<?php endif; ?>
						</ul>

						<?php if ($logo2) : ?>
						<div class="partners-logo-wrapper">
							<div class="image-wrapper">
								<img src="<?php echo esc_url($logo2['url']); ?>" alt="<?php echo esc_attr($logo2['alt']); ?>">
							</div>
						</div>
						<?php endif; ?>
						<div class="partners-card-link">
							<a href="<?php the_permalink(); ?>"> View more → </a>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

// In functions.php, enqueue the script
function my_theme_scripts() {
    wp_enqueue_script('filter-partners', get_template_directory_uri() . '/js/filter-partners.js', array('jquery'), null, true);
    wp_localize_script('filter-partners', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');
function filter_search_by_title_only( $search, $wp_query ) {
    global $wpdb;

    // Only run on frontend AJAX search for partners
    if ( 
        ! empty( $wp_query->get( 's' ) ) 
        && $wp_query->get( 'post_type' ) === 'partner'
    ) {
        $search = $wpdb->prepare(
            " AND {$wpdb->posts}.post_title LIKE %s ",
            '%' . $wpdb->esc_like( $wp_query->get( 's' ) ) . '%'
        );
    }

    return $search;
}
add_filter( 'posts_search', 'filter_search_by_title_only', 10, 2 );


add_action('wp_footer', function(){
    ?>
<!-- Modal -->
<div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupModalTitle">Get Started – No Payment Needed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <g clip-path="url(#clip0_186_96)">
                            <path
                                d="M11.8323 10.0164L19.62 2.22853C20.1268 1.72195 20.1268 0.902867 19.62 0.396351C19.1134 -0.110226 18.2943 -0.110226 17.7878 0.396351L9.99991 8.18415L2.21229 0.396351C1.70547 -0.110226 0.886691 -0.110226 0.380115 0.396351C-0.126705 0.902928 -0.126705 1.72195 0.380115 2.22853L8.16767 10.0164L0.380175 17.8042C-0.126644 18.3108 -0.126644 19.1299 0.380175 19.6364C0.500338 19.7569 0.643127 19.8524 0.80034 19.9176C0.957552 19.9827 1.12609 20.0162 1.29627 20.016C1.62791 20.016 1.95967 19.889 2.21236 19.6364L9.99991 11.8486L17.7878 19.6364C17.908 19.7569 18.0508 19.8524 18.208 19.9176C18.3652 19.9827 18.5337 20.0162 18.7039 20.016C19.0356 20.016 19.3673 19.889 19.62 19.6364C20.1268 19.1298 20.1268 18.3108 19.62 17.8042L11.8323 10.0164Z"
                                fill="black" />
                        </g>
                        <defs>
                            <clipPath id="clip0_186_96">
                                <rect width="20" height="20" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-formCvr">
                    <div class="cta-frm">
                        <?php echo do_shortcode('[contact-form-7 id="22f3dfb" title="Popup Form"]'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('wpcf7mailsent', function(event) {
   if (event.detail.contactFormId == 345) {
        location = 'https://weekmate.in/thank-you/';
    }
}, false);
</script>
<?php
});


//Ajax function for the query of blog listing page
add_action('wp_ajax_ajax_blog_filter', 'ajax_blog_filter');
add_action('wp_ajax_nopriv_ajax_blog_filter', 'ajax_blog_filter');

function ajax_blog_filter() {

    $search   = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $category = isset($_POST['category']) ? intval($_POST['category']) : '';
    $paged    = isset($_POST['paged']) ? max(1, intval($_POST['paged'])) : 1;

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 6,          // ← was -1, now paginated
        'paged'          => $paged,     // ← added
        'post_status'    => 'publish',
    );

    if (!empty($search)) {
        $args['s'] = $search;
        $args['search_columns'] = array('post_title');
    }

    $tax_query = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => array(1),
            'operator' => 'NOT IN',
        ),
    );

    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => array($category),
            'operator' => 'IN',
        );
    }

    $args['tax_query'] = $tax_query;

    $colorClasses = [
        "light-mint-bg-clr", "soft-peach-bg-clr", "light-ivory-bg-clr",
        "sky-blue-bg-clr", "lavender-mist-bg-clr", "off-white-bg-clr", "light-lavender-bg-clr"
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $i = 0;
        echo '<div class="blog-grid">';
        while ($query->have_posts()) {
            $query->the_post();
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="18" viewBox="0 0 11 18" fill="none">
                                        <path d="M1.54941 17.33C1.92702 17.33 2.30464 17.1909 2.60276 16.8927L9.61851 9.877C10.1949 9.30063 10.1949 8.34665 9.61851 7.77029L2.60276 0.754539C2.0264 0.178175 1.07241 0.178175 0.49605 0.754539C-0.0803146 1.3309 -0.0803146 2.28489 0.49605 2.86125L6.45844 8.82364L0.49605 14.786C-0.0803146 15.3624 -0.0803146 16.3164 0.49605 16.8927C0.774295 17.1909 1.15191 17.33 1.54941 17.33Z" fill="black"></path>
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
            $i++;
        }
        echo '</div>';

        // ← added: Load More button, only if more pages exist
        if ($query->max_num_pages > $paged) {
            ?>
            <div id="load-more-wrapper" class="text-center mt-4">
                <button
                    id="load-more"
                    class="btn btn-primary"
                    data-page="<?php echo $paged + 1; ?>"
                    data-max="<?php echo $query->max_num_pages; ?>">
                    Load More
                </button>
            </div>
            <?php
        }
    } else {
        echo '<p>No posts found.</p>';
    }

    wp_reset_postdata();

    wp_die();
}


// Ajax function fo rload more button in Author page
add_action('wp_ajax_load_more_author_posts', 'load_more_author_posts');
add_action('wp_ajax_nopriv_load_more_author_posts', 'load_more_author_posts');

function load_more_author_posts() {

    $page      = intval($_POST['page']);
    $author_id = intval($_POST['author']);

    $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'paged'          => $page,
        'author'         => $author_id,
        'post_status'    => 'publish',
		'category__not_in' => [11],
    ]);

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
            ?>
            <div class="blog-grid-item">
                <article class="blog-card">
                    <a href="<?php the_permalink(); ?>">

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="blog-thumb">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="blog-content">
                            <div class="blog-content-title">
                                <h2 class="blog-title text-18"><?php the_title(); ?></h2>

                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="18" viewBox="0 0 11 18">
                                        <path d="M1.54941 17.33C1.92702 17.33 2.30464 17.1909 2.60276 16.8927L9.61851 9.877C10.1949 9.30063 10.1949 8.34665 9.61851 7.77029L2.60276 0.754539C2.0264 0.178175 1.07241 0.178175 0.49605 0.754539C-0.0803146 1.3309 -0.0803146 2.28489 0.49605 2.86125L6.45844 8.82364L0.49605 14.786C-0.0803146 15.3624 -0.0803146 16.3164 0.49605 16.8927C0.774295 17.1909 1.15191 17.33 1.54941 17.33Z" fill="black"/>
                                    </svg>
                                </div>
                            </div>

                            <p class="blog-meta">
                                <span>Author: <?php the_author(); ?></span>
                                <span><?php echo get_the_date('d F, Y'); ?></span>
                            </p>
                        </div>
                    </a>
                </article>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    endif;

    wp_die();
}

// Redirecting to some specific url
add_action('template_redirect', function () {

    $redirects = [
        '/kpo/'        => '/accounting/',
    ];

    $current_path = trailingslashit(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if (isset($redirects[$current_path])) {
        wp_redirect(home_url($redirects[$current_path]), 301);
        exit;
    }
});


// Change site title for Free Tools archive page
add_filter('pre_get_document_title', function($title) {
    if (is_post_type_archive('freetools')) {
        return 'Free Tools';
    }
    return $title;
});



// Ajax Search Function for glossary 
function glossary_search_title_only( $search, $wp_query ) {
    global $wpdb;

    // Run only when explicitly enabled
    if ( ! $wp_query->get( 'search_in_title_only' ) ) {
        return $search;
    }

    $search_terms = $wp_query->get( 'search_terms' );

    if ( empty( $search_terms ) ) {
        return $search;
    }

    $sql = '';

    foreach ( $search_terms as $term ) {
        $term = esc_sql( $wpdb->esc_like( $term ) );
        $sql .= " AND {$wpdb->posts}.post_title LIKE '%{$term}%'";
    }

    return $sql; // ⬅️ FULL REPLACEMENT (no content search)
}
add_filter( 'posts_search', 'glossary_search_title_only', 20, 2 );

// AJAX search for Glossary
add_action('wp_ajax_glossary_ajax_search', 'glossary_ajax_search');
add_action('wp_ajax_nopriv_glossary_ajax_search', 'glossary_ajax_search');

function glossary_ajax_search() {

    check_ajax_referer('glossary_search_nonce', 'nonce');
    $mode = isset($_POST['mode']) ? sanitize_text_field($_POST['mode']) : 'archive';

    $keyword = ! empty($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
    $letter  = ! empty($_POST['letter']) ? strtoupper(sanitize_text_field($_POST['letter'])) : '';

    $args = [
        'post_type'      => 'glossary',
        'posts_per_page' => ($mode === 'redirect') ? 1 : ($mode === 'suggest' ? 5 : -1),
        'orderby'        => 'title',
        'order'          => 'ASC',
        's'              => $keyword,
        'search_in_title_only' => true, // ✅ THIS activates filter
        'suppress_filters'     => false,
    ];

    if ($keyword) {
        // $args['s'] = $keyword;
        $args['glossary_title_only'] = true; 
    }

    $query = new WP_Query($args);
    
    //     echo "DEBUG - SEARCH TERM: " . $keyword . "\n";
    // echo "DEBUG - SQL QUERY: " . $query->request . "\n";
    // wp_die(); // Stop everything here so we can read the output

    if ($mode === 'redirect') {
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                if (strcasecmp(get_the_title(), $keyword) === 0) {
                    echo esc_url(get_permalink());
                    wp_reset_postdata();
                    wp_die();
                }
            }

            // fallback to first result
            $query->rewind_posts();
            $query->the_post();
            echo esc_url(get_permalink());
        } else {
            echo 'no-results';
        }

        wp_reset_postdata();
        wp_die();
    }
  
    if ($mode === 'suggest') {

        if ( ! $query->have_posts() ) {
        echo '<ul class="glossary-suggestion-list">';
        echo '<li class="no-results"><a>No related terms found.</a></li>';
        echo '</ul>';
        wp_die();
    }


        echo '<ul class="glossary-suggestion-list">';

        while ($query->have_posts()) {
            $query->the_post();
            echo '<li>
                    <a href="' . esc_url(get_permalink()) . '">
                        ' . esc_html(get_the_title()) . '
                    </a>
                </li>';
        }

        echo '</ul>';

        wp_reset_postdata();
        wp_die();
    }

    if (! $query->have_posts()) {
        echo '<p class="no-results">No glossary terms found.</p>';
        wp_die();
    }

    $grouped_posts = [];

    while ($query->have_posts()) {
        $query->the_post();

        $first_letter = strtoupper(mb_substr(get_the_title(), 0, 1));

        // ✅ LETTER FILTER LOGIC
        if ($letter && $first_letter !== $letter) {
            continue;
        }

        $grouped_posts[$first_letter][] = [
            'title' => get_the_title(),
            'link'  => get_permalink(),
        ];
    }

    wp_reset_postdata();
    

    if (empty($grouped_posts)) {
        echo '<p class="no-results">No glossary terms found.</p>';
        wp_die();
    }

    echo '<div class="glossary-grid">';

    foreach ($grouped_posts as $char => $posts) {
        echo '<div class="glossary-col">';
        echo '<h3>' . esc_html($char) . '</h3><ul>';

        foreach ($posts as $post) {
            echo '<li><a href="' . esc_url($post['link']) . '">' . esc_html($post['title']) . '</a></li>';
        }

        echo '</ul></div>';
    }

    echo '</div>';

    wp_die();
}

function format_acf_date_range($from, $to) {
    if (!$from) return '';
    $from_date = DateTime::createFromFormat('Ymd', $from);
    if (!$from_date) return '';
    $to_date = $to ? DateTime::createFromFormat('Ymd', $to) : null;
    if (!$to_date) return $from_date->format('d F Y');
    if ($from_date->format('Y') === $to_date->format('Y') && $from_date->format('m') === $to_date->format('m')) {
        return $from_date->format('d') . '–' . $to_date->format('d F Y');
    }
    if ($from_date->format('Y') === $to_date->format('Y')) {
        return $from_date->format('d F') . ' – ' . $to_date->format('d F Y');
    }
    return $from_date->format('d F Y') . ' – ' . $to_date->format('d F Y');
}

function get_active_sorted_announcement_slides($slides) {
    $today = new DateTime('today');
    $active_slides = [];

    if (!empty($slides)) {
        foreach ($slides as $slide) {
            $group      = $slide['announcement_section_group'];
            $date_group = $group['announcement_date_and_time_section'] ?? [];
            $date_from  = $date_group['date_from'] ?? '';
            $date_to    = $date_group['date_to']   ?? '';

            $expiry_date = $date_to ?: $date_from;
            if ($expiry_date) {
                $expiry = DateTime::createFromFormat('Ymd', $expiry_date);
                if ($expiry && $expiry < $today) {
                    continue;
                }
            }
            $active_slides[] = $slide;
        }
    }

    usort($active_slides, function($a, $b) {
        $a_date = $a['announcement_section_group']['announcement_date_and_time_section']['date_from'] ?? '';
        $b_date = $b['announcement_section_group']['announcement_date_and_time_section']['date_from'] ?? '';
        $a_parsed = $a_date ? DateTime::createFromFormat('Ymd', $a_date) : null;
        $b_parsed = $b_date ? DateTime::createFromFormat('Ymd', $b_date) : null;
        if (!$a_parsed && !$b_parsed) return 0;
        if (!$a_parsed) return 1;
        if (!$b_parsed) return -1;
        return $a_parsed <=> $b_parsed;
    });

    return $active_slides;
}

add_action('wp_ajax_filter_news_posts', 'filter_news_posts');
add_action('wp_ajax_nopriv_filter_news_posts', 'filter_news_posts');

function filter_news_posts()
{

    check_ajax_referer('news_load_more_nonce', 'nonce');

    $type  = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'news';
    $paged = isset($_POST['paged']) ? max(1, intval($_POST['paged'])) : 1;

    if ($type === 'upcoming-events') {

        $announcement_section = get_field('news_event_announcement_section', 'option');
        $slides        = $announcement_section['announcement_section_main_content'] ?? null;
        $section_image = $announcement_section['announcement_section_image'] ?? null;
        $html = '';

        $active_slides = get_active_sorted_announcement_slides($slides);

        if (!empty($active_slides)) {
            ob_start(); ?>
            <div class="announcement-section__inner">

                <?php if ($section_image) : ?>
                    <div class="announcement-section__image">
                        <img src="<?php echo esc_url($section_image['url']); ?>" alt="<?php echo esc_attr($section_image['alt']); ?>">
                    </div>
                <?php endif; ?>

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
                                        <?php if ($time_text) : ?>
                                            <div class="announcement-section__meta-item">
                                                <?php if ($time_icon) : ?>
                                                    <img src="<?php echo esc_url($time_icon['url']); ?>" alt="time" class="announcement-section__meta-icon">
                                                <?php endif; ?>
                                                <span class="announcement-section__meta-text"><?php echo esc_html($time_text); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
            <?php $html = ob_get_clean();
        } else {
            $html = '<p class="announcement-section__empty">No upcoming events.</p>';
        }

        echo '<div id="news-listing-results">' . $html . '</div>';
        wp_die();
    }

    // ─────────────────────────────────────────────
    // Grid types: "news" (news-events CPT) and "latest-updates" (blog posts)
    // ─────────────────────────────────────────────
    $is_blog_layout = ($type === 'latest-updates');

    if ($is_blog_layout) {
        $per_page = 3;
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $per_page,
            'paged'          => $paged,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
    } else {
        $per_page = 6;
        $args = array(
            'post_type'      => 'news-events',
            'posts_per_page' => $per_page,
            'paged'          => $paged,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
    }

    $query = new WP_Query($args);
    $html  = '';

    if ($query->have_posts()) :

        ob_start();

        while ($query->have_posts()) : $query->the_post();

            if ($is_blog_layout) : ?>

                <div class="blog-grid-item">
                    <article class="blog-card">
                        <a href="<?php the_permalink(); ?>">

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="blog-thumb">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>

                            <?php
                            $colors = ['light-mint-bg-clr', 'soft-peach-bg-clr', 'light-ivory-bg-clr'];
                            // Use absolute post index across pages so colors keep cycling correctly
                            $absolute_index = (($paged - 1) * $per_page) + $query->current_post;
                            $color_class    = $colors[$absolute_index % 3];
                            ?>

                            <div class="blog-content <?php echo $color_class; ?>">
                                <div class="blog-content-title">
                                    <h2 class="blog-title text-18"><?php the_title(); ?></h2>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="18" viewBox="0 0 11 18" fill="none">
                                            <path d="M1.54941 17.33C1.92702 17.33 2.30464 17.1909 2.60276 16.8927L9.61851 9.877C10.1949 9.30063 10.1949 8.34665 9.61851 7.77029L2.60276 0.754539C2.0264 0.178175 1.07241 0.178175 0.49605 0.754539C-0.0803146 1.3309 -0.0803146 2.28489 0.49605 2.86125L6.45844 8.82364L0.49605 14.786C-0.0803146 15.3624 -0.0803146 16.3164 0.49605 16.8927C0.774295 17.1909 1.15191 17.33 1.54941 17.33Z" fill="black"></path>
                                        </svg>
                                    </div>
                                </div>

                                <p class="blog-meta">
                                    <span>Author: <?php the_author(); ?></span>
                                    <span><?php echo get_the_date('d F, Y'); ?></span>
                                </p>
                            </div>

                        </a>
                    </article>
                </div>

            <?php else : ?>

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
                                    $author_id     = get_the_author_meta('ID');
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

            <?php endif;

        endwhile;

        $html = ob_get_clean();

        wp_reset_postdata();

    endif;

    wp_send_json(array(
        'html'     => $html !== '' ? $html : '<p class="news-listing__no-posts">No posts found.</p>',
        'has_more' => $paged < $query->max_num_pages,
        'paged'    => $paged,
    ));
    // wp_send_json() already calls wp_die() for us.
}

// ── Auto-delete expired announcement slides ──────────────
function register_expired_events_cron() {
    if ( ! wp_next_scheduled( 'delete_expired_announcement_slides' ) ) {
        wp_schedule_event( time(), 'daily', 'delete_expired_announcement_slides' );
    }
}
add_action( 'init', 'register_expired_events_cron' );

add_action( 'delete_expired_announcement_slides', 'process_delete_expired_slides' );

function process_delete_expired_slides() {
    $options_slides = get_field( 'news_event_announcement_section', 'option' );
    $slides         = $options_slides['announcement_section_main_content'] ?? [];

    if ( empty( $slides ) ) return;

    $today          = new DateTime( 'today' );
    $updated_slides = [];

    foreach ( $slides as $slide ) {
        $group      = $slide['announcement_section_group'];
        $date_group = $group['announcement_date_and_time_section'] ?? [];
        $date_to    = $date_group['date_to']   ?? '';
        $date_from  = $date_group['date_from'] ?? '';

        // Delete slides with no title or no dates
        if ( empty( $group['announcement_section_title'] ) || ( empty( $date_from ) && empty( $date_to ) ) ) {
            continue;
        }

        $expiry_date = $date_to ?: $date_from;

        if ( $expiry_date ) {
            $expiry = DateTime::createFromFormat( 'Ymd', $expiry_date );
            if ( $expiry && $expiry < $today ) {
                continue; // expired — delete
            }
        }

        $updated_slides[] = $slide;
    }

    $options_slides['announcement_section_main_content'] = $updated_slides;
    update_field( 'news_event_announcement_section', $options_slides, 'option' );
}


add_filter( 'wpseo_robots', function( $robots ) {
	if ( wmcp_parse_city_permalink_from_request() ) {
		return 'index, follow';
	}
	return $robots;
});


function weekmate_add_categories_to_pages() {
    register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'weekmate_add_categories_to_pages' );

