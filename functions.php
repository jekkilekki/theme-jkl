<?php
/**
 * jkl functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package jkl
 */

if ( ! function_exists( 'jkl_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jkl_setup() {
    
        /*
         * @Todo - ADD Editor styles here.
         * This theme styles the visual editor to resemble the theme style.
         */
        // $font_url = 'http://fonts.googleapis.com/css?family=Khula:300,400,600,700,800';
        // add_editor_style( array( 'inc/editor-style.css', str_replace( ',', '%2C', $font_url ) ) );
    
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on jkl, use a find and replace
	 * to change 'jkl' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'jkl', get_template_directory() . '/languages' );

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
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary', 'jkl' ),
                'social'    => esc_html__( 'Social', 'jkl' ),
                'footer'    => esc_html__( 'Footer', 'jkl' ), 
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
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
                'gallery',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'jkl_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'jkl_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jkl_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jkl_content_width', 840 );  // @Todo - check content width
}
add_action( 'after_setup_theme', 'jkl_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jkl_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'jkl' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
        register_sidebar( array(
                'name'          => esc_html__( 'Footer', 'jkl' ),
                'description'   => esc_html__( 'Widgets appearing in the footer of the site.', 'jkl' ),
                'id'            => 'sidebar-footer',
                'before_widget' => '<aside id="%1$s" class="widget small-6 medium-4 large-3 %2$s">', // @Todo - check Foundation width for footer widgets
                'after_widget'  => '</aside>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
        ) );
}
add_action( 'widgets_init', 'jkl_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jkl_scripts() {

    
        /* Add Foundation CSS */
        wp_enqueue_style( 'foundation', get_stylesheet_directory_uri() . '/foundation/css/foundation.css' );
        
        /* Add Foundation JS */
        wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/foundation/js/foundation.min.js', array( 'jquery' ), '20160211', true );
        
        /* @Todo - Add Custom Fonts */
        wp_enqueue_style( 'gfonts', 'https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,400italic,300,300italic,700,700italic|Volkhov|Source+Code+Pro' );
        // wp_enqueue_style( 'jkl-local-fonts', get_template_directory_uri() . '/fonts/custom-fonts.css' );
        wp_enqueue_style( 'fawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );  
        
        
        /* Run Foundation */
        wp_enqueue_script( 'foundation-init', get_template_directory_uri() . '/js/foundation.js', array( 'jquery' ), '20160211', true );
        
        /* Masonry settings for Footer widgets */ // @Todo - decide if we want these
        /* Toggle Main Search script */ //@Todo - decide if we want this
        
        /* Add dynamic back to top button */
        wp_enqueue_script( 'jkl-topbutton', get_template_directory_uri() . '/js/topbutton-search-imgs.js', array( 'jquery' ), '20160211', true );        
        
        
        /* Custom stylesheets for custom Page templates */
        
        
        /* Default Underscores styles & scripts */
	wp_enqueue_style( 'jkl-style', get_stylesheet_uri() );

	wp_enqueue_script( 'jkl-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20120206', true );
        wp_localize_script( 'jkl-navigation', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'jkl' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'jkl' ) . '</span>',
	) );
        
	wp_enqueue_script( 'jkl-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
        
        
}
add_action( 'wp_enqueue_scripts', 'jkl_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
