<?php
/**
 * KRDS functions and definitions
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
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage KRDS
 * @since krds 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'krds_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own krds_setup() function to override in a child theme.
 *
 * @since krds 1.0
 */
function krds_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Sixteen, use a find and replace
	 * to change 'krds' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'krds', get_template_directory() . '/languages' );

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
	 *  @since KRDS 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );


	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'krds' ),
		'social'  => __( 'Social Links Menu', 'krds' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'assets/css/editor-style.css', krds_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // krds_setup

add_action( 'after_setup_theme', 'krds_setup' );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since krds 1.0
 */
function krds_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'krds' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'krds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'krds' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'krds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'krds' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'krds' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'krds_widgets_init' );


if ( ! function_exists( 'krds_fonts_url' ) ) :
/**
 * Register Google fonts for KRDS
 *
 * Create your own krds_fonts_url() function to override in a child theme.
 *
 * @since KRDS 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function krds_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'krds' ) ) {
		$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'krds' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'krds' ) ) {
		$fonts[] = 'Inconsolata:400';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;


/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since krds 1.0
 */
function krds_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'krds_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since krds 1.0
 */
/*** add scripts ***/
function add_scripts() {
    wp_enqueue_script( 'manifest_js', webpack_asset('manifest.js'), [], null );
    wp_enqueue_script( 'lib_js', webpack_asset('lib.js'), [], null );
    wp_enqueue_script( 'main_js', webpack_asset('main.js'), [], null );
    wp_localize_script('main_js','ajax', array(
		'ajax_url'    => admin_url('admin-ajax.php'),
		'nonce'       => wp_create_nonce('ajax-nonce')
	));
}
add_action( 'wp_footer', 'add_scripts' );

/*** add stylesheets ***/
function add_styles() {
	wp_enqueue_style( 'main_style', webpack_asset('main.css'), [], null );
}
add_action( 'wp_print_styles', 'add_styles' );

/***Fetch webpack asset ***/
if (! function_exists('webpack_asset')) {

    function webpack_asset($asset) {
		echo '<pre>';
	
        $json = json_decode(file_get_contents(get_template_directory() . '/build/webpack-manifest.json'));
			print_r($json);
        return get_template_directory_uri() . $json->{$asset};
    }
}

/*** remove dafault wordpress scripts ***/
function remove_scripts($scripts) {
    wp_deregister_script( 'jquery' );
    wp_deregister_script('wp-embed');

}
add_filter( 'wp_enqueue_scripts', 'remove_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since krds 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function krds_body_classes( $classes ) {
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
add_filter( 'body_class', 'krds_body_classes' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/* @@@ Custom Functions starts here @@@@ */

/* Shortcode  For Editor Use    */

function krds_site_url()
{
	return get_site_url();
}

add_shortcode('krds_site_url', 'krds_site_url');

/* Template Url Short Code */

function krds_template_url()
{
	return get_template_directory_uri();
}

add_shortcode('krds_template_url', 'krds_template_url');

//Disable All Notification Updates in dashboard

function remove_core_updates()
{
	global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version);
}

if(WP_ENV == 'PROD' || WP_ENV == 'TESTING' || WP_ENV == 'STAG')
{
	add_filter('pre_site_transient_update_core','remove_core_updates');
	add_filter('pre_site_transient_update_plugins','remove_core_updates');
	add_filter('pre_site_transient_update_themes','remove_core_updates');
}


//Google Analytics
if(WP_ENV == 'PROD') //Only on Production
	add_action('wp_footer', 'add_googleanalytics');

function add_googleanalytics()
{
	echo "
		<!-- Paste your Google Analytics script here -->
		";
}