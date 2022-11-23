<?php
/**
 * Тёплый день functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Тёплый_день
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function warm_day_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Тёплый день, use a find and replace
		* to change 'warm_day' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'warm_day', get_template_directory() . '/languages' );

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
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'warm_day' ),
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
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'warm_day_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'warm_day_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function warm_day_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'warm_day_content_width', 640 );
}
add_action( 'after_setup_theme', 'warm_day_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function warm_day_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'warm_day' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'warm_day' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'warm_day_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function warm_day_scripts() {

	wp_enqueue_style( 'warm_day-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'warm_day-style', 'rtl', 'replace' );

	wp_enqueue_style( 'warm_day-base-style', get_template_directory_uri() . '/assets/css/base.css', array(), _S_VERSION );
	wp_style_add_data( 'warm_day-base-style', 'rtl', 'replace' );

	wp_enqueue_script('warm_day-script-base', get_template_directory_uri() . '/assets/js/base.js', array(), _S_VERSION);

	global $post;
	$pagename = $post->post_name;

	if (is_single() || is_tax()) {
		$pagename = $post->post_type;
	}
	
	if (file_exists(get_template_directory() . '/assets/css/' . $pagename . '.css')) {
		wp_enqueue_style( 'warm_day-style-' . $pagename, get_template_directory_uri() . '/assets/css/' . $pagename . '.css', array(), _S_VERSION );
		wp_style_add_data( 'warm_day-style-' . $pagename, 'rtl', 'replace' );
	}

	if (file_exists(get_template_directory() . '/assets/js/' . $pagename . '.js')) {
		wp_enqueue_script('warm_day-script-' . $pagename, get_template_directory_uri() . '/assets/js/' . $pagename . '.js', array(), _S_VERSION);
	}

	wp_enqueue_style( 'warm_day-show-style', get_template_directory_uri() . '/assets/css/components/snow.css', array(), _S_VERSION );
	wp_style_add_data( 'warm_day-show-style', 'rtl', 'replace' );
}
add_action( 'wp_enqueue_scripts', 'warm_day_scripts' );

function add_type_attribute($tag, $handle, $src) {
    global $post;
	if (!$post) {
		return $tag;
	}
	$pagename = $post->post_name;

	if (is_single() || is_tax()) {
		$pagename = $post->post_type;
	}

    if ( 'warm_day-script-' . $pagename !== $handle ) {
        return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute' , 10, 3);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
* Custom posts.
*/
require get_template_directory() . '/inc/custom-posts.php';

/**
* Ajax.
*/
require get_template_directory() . '/inc/ajax.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

