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
        add_image_size( 'jkl_featured', 1600, 600, array( 'center', 'center' ) ); // or could set the arry to "true" and it does that, but wanted to remember, x_crop_position, y_crop_position

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
		'aside',    // style added
                'status',   // style added
                'quote',    // style added
                'link',     // style added
                'image',    // style added
                'gallery',  // style added
                'video',    // style added
                'audio',    // style added
                'chat',     // style added	
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'jkl_custom_background_args', array(
		'default-color'     => 'ffffff',
		'default-image'     => '',
                'wp-head-callback'  => 'jkl_custom_background_cb'
	) ) );
        
        /**
         * Add editor styles
         */
        add_editor_style( array( 
            'foundation/css/foundation.css',
            'inc/editor-style.css', 
            'fonts/custom-fonts.css',
            'fonts/font-awesome.css',
            ) 
        );
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
		'name'          => esc_html__( 'Widget Area', 'jkl' ),
                'description'   => esc_html__( 'Widgets appearing in the main widget area.', 'jkl' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        
        register_sidebar( array(
                'name'          => esc_html__( 'Footer Widgets', 'jkl' ),
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
        
        /* Add Custom Fonts */
        wp_enqueue_style( 'jkl-local-fonts', get_template_directory_uri() . '/fonts/custom-fonts.css' );
        wp_enqueue_style( 'jkl-fawesome', get_template_directory_uri() . '/fonts/font-awesome.css' );    
        
        /* Run Foundation */
        wp_enqueue_script( 'foundation-init', get_template_directory_uri() . '/js/foundation.js', array( 'jquery' ), '20160211', true );
        
        /* Add dynamic back to top button */
        wp_enqueue_script( 'jkl-topbutton', get_template_directory_uri() . '/js/topbutton-search-imgs.js', array( 'jquery' ), '20160211', true );        
        
        /* Add Prism Syntax Highlighting */
        wp_enqueue_script( 'jkl-prism-script', get_template_directory_uri() . '/js/prism.min.js', array(), '20161104', true );
        wp_enqueue_style( 'jkl-prism-style', get_template_directory_uri() . '/css/prism.css' );
        
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


/**
 * =============================================================================
 * My Custom Functions here
 * =============================================================================
 */

/**
 * Add Excerpts to Pages
 */
function jkl_add_excerpt_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'jkl_add_excerpt_to_pages' );

/**
 * Better Title Filter
 * 
 * Rather than using 'the_title_rss' which has 'strip_tags' hooked to it (removes all title markup),
 * use a different filter called 'the_title_export' which wraps the output in CDATA tags
 * Works like `the_content_export` and `the_excerpt_export`
 * 
 * @see https://core.trac.wordpress.org/ticket/29621
 * @see https://core.trac.wordpress.org/attachment/ticket/29621/29621.2.diff
 */
//function jkl_better_post_title() {
//    remove_filter( 'the_title_rss', 'strip_tags' );
//    remove_filter( 'the_title_rss', 'ent2ncr', 8 );
//    remove_filter( 'the_title_rss', 'esc_html' );
//    
//    add_filter( 'the_title_rss', 'wxr_cdata' );
//    
//    remove_filter( 'the_title_rss', '')
//}

/**
 * Better Post Excerpts
 * 
 * Based on Post Format, it trims the excerpt in various ways and returns various pieces of content
 */
function jkl_better_excerpts( $text, $raw_excerpt ) {
    
    /**
     * Post Format: Quote
     * 
     * Only get the first <blockquote> from a Post Format quote (no additional writing) 
     * for the index and archive pages.
     * 
     * @link http://www.codecheese.com/2013/11/get-the-first-paragraph-as-an-excerpt-for-wordpress/
     */
    if( 'quote' === get_post_format() && !$raw_excerpt ) {
        if( !$raw_excerpt ) {
            $content = apply_filters( 'the_content', get_the_content() );
            $text = substr( $content, 0, strpos( $content, '</blockquote>' ) + 13 );
        } else {
            $text = apply_filters( 'the_excerpt', get_the_excerpt() );
        } 
    }
    
    /**
     * Post Format: Chat
     * 
     * Retrieve the first 100 characters of the chat as styled post content (not the unstyled excerpt)
     */
    else if( 'chat' === get_post_format() && !$raw_excerpt ) {
        $content = apply_filters( 'the_content', get_the_content() );
        $text = substr( $content, 0, 500 ) . '…';
    }
    
    /**
     * Post Format: Link
     * 
     * Find the first link, extract its data, grab a screenshot and display it
     * 
     * @link https://code.tutsplus.com/articles/how-to-generate-website-screenshots-for-your-wordpress-site--wp-22888
     */
    else if( 'link' === get_post_format() && !$raw_excerpt ) {
        $content = apply_filters( 'the_content', get_the_content() );
        
        if( strpos( $content, '</a>' ) === false ) {
            $text = $content;
        } else {

            $first_link = substr( $content, strpos( $content, '<a>' ), strpos( $content, '</a>' ) + 4 );
            preg_match_all( '/<a[^>]+href=([\'"])(.+?)\1[^>]*>/i', $first_link, $site );
            
            //if( !empty( $site ) ) {
                $query_url = 'http://s.wordpress.com/mshots/v1/';
                $site_url = $site[2][0]; // something like www.example.com
                $image_tag = '<img class="link-screenshot-img" alt="' . $site_url . '" width="150" src="http://' . $site_url . '">';
            
                $text = '<a class="link-screenshot" href="http://' . $site_url . '">' . $image_tag . '</a>' . $first_link;
            //} else {
                //$text = $content;
            //}
        }
    }
    
    // Return the result
    return $text;
    
}
add_filter( 'wp_trim_excerpt', 'jkl_better_excerpts', 5, 2 );

/**
 * Get 'Large' Gallery image sizes on index and archive pages
 * 
 * @link http://mekshq.com/change-image-thumbnail-size-in-wordpress-gallery/
 */
function jkl_large_gallery_images( $output, $pairs, $atts ) {
    //if( !is_singular() && 'gallery' === get_post_format() ) {
        $output[ 'size' ] = 'large';
    //} 
    return $output;
}
add_filter( 'shortcode_atts_gallery', 'jkl_large_gallery_images', 10, 3 );

/**
 * Custom Background Callback to make the .site-logo-housing (above the menu) match
 * the chosen custom background color in body.custom-background
 * 
 * @link http://wordpress.stackexchange.com/questions/189361/add-custom-background-to-div-in-home-page
 */
function jkl_custom_background_cb() {
    ob_start();
    _custom_background_cb(); // Default handler
    $style = ob_get_clean();
    $style = str_replace( 'body.custom-background', 'body.custom-background, .site-logo-housing, .site-logo', $style );
    echo $style;
}

/**
 * Filter added to the content for Asides, Links, Quotes, and Statuses to append
 * an infinity sign to the end of that content
 * 
 * @link http://justintadlock.com/archives/2012/09/06/post-formats-aside
 */
function jkl_infinity_link( $content ) {
    if( (   has_post_format( 'aside' ) ||
            has_post_format( 'quote' ) ||
            has_post_format( 'link' ) ||
            has_post_format( 'status' ) ) && !is_singular() ) {
        $content .= '<a class="infinity-link" href="' . get_permalink() . '">&#8734;</a>';
    } 
//    elseif( has_post_format( 'link' ) && !is_singular() ) {
//        $content = '<a class="infinity-link" href="' .get_permalink() . '">&#8734;</a>' . $content;
//    }
    return $content;
}
add_filter( 'the_content', 'jkl_infinity_link', 9 ); // run before wpautop
add_filter( 'the_excerpt', 'jkl_infinity_link', 9 );

/**
 * Filter a Quote Post Format to add <blockquote> around the whole thing if 
 * no existing tag is found
 * 
 * @link https://github.com/justintadlock/hybrid-core/blob/master/inc/functions-formats.php
 */
function jkl_quote_blockquote( $excerpt ) {
    if( 'quote' === get_post_format() ) {
        preg_match( '/<blockquote.*?>/', $excerpt, $matches );
        
        if( empty( $matches ) ) {
            $excerpt = "<blockquote>{$excerpt}</blockquote>";
        }
    }
    
    return $excerpt;
}
add_filter( 'the_excerpt', 'jkl_quote_blockquote', 8 ); // run before wpautop

/**
 * Filter a Video Post to add an 'entry-meta' <div> around the <iframe> video to
 * give the video a bit of a darker backdrop for viewing
 * 
 * @param   string  $content
 * @return  string  $content    Updated $content string with 'entry-meta' <div> surrounding the <iframe> video
 */
function jkl_video_backdrop( $content ) {
    if( 'video' === get_post_format() && is_singular() ) {
        $vid_start = strpos( $content, '<iframe>' );
        $vid_end = strpos( $content, '</iframe>' ) + 9;
        
        if( $vid_end > 9 ) { // Be sure that the end of the video is after the beginning
            $before_video = substr( $content, 0, $vid_start );
            $video = substr( $content, $vid_start, $vid_end - $vid_start );
            $after_video = substr( $content, $vid_end );

            $content = $before_video . '<div class="entry-meta video-backdrop">' . $video . '</div>' . $after_video;
        }
    }
    return $content;
}
add_filter( 'the_content', 'jkl_video_backdrop' );

/**
 * Show thumbnail image sizes in galleries on index/archive pages
 * 
 * @link http://wordpress.stackexchange.com/questions/125781/changing-gallery-images-size
 */
function jkl_gallery_thumbnails( $output, $pairs, $atts ) {
    if( !is_singular() ) {
        $output[ 'size' ] = 'thumbnail';
    }
    return $output;
}
add_filter( 'shortcode_atts_gallery', 'jkl_gallery_thumbnails', 10, 3 );

/**
 * Post Format: Quote
 * 
 * Only get the first <blockquote> from a Post Format quote (no additional writing) 
 * for the index and archive pages.
 * 
 * @link http://www.codecheese.com/2013/11/get-the-first-paragraph-as-an-excerpt-for-wordpress/
 
function jkl_quote_excerpt( $text, $raw_excerpt ) {
    if( 'quote' === get_post_format() && !$raw_excerpt ) {
        $content = apply_filters( 'the_content', get_the_content() );
        $text = substr( $content, 0, strpos( $content, '</blockquote>' ) + 13 );
    }
    return $text;
}
add_filter( 'wp_trim_excerpt', 'jkl_quote_excerpt', 5, 2 );

/**
 * Post Format: Video
 * 
 * Only get the first 'video' element from a Post for index and archive pages.
 
function jkl_video_excerpt( $text, $raw_excerpt ) {
    if( 'video' === get_post_format() && !$raw_excerpt ) {
        $content = apply_filters( 'the_content', get_the_content() );
        if( strpos( $content, '</iframe>' ) === false ) {
            $text = $content;
        } else {
            $text = substr( $content, 0, strpos( $content, '</iframe>' ) + 9 );
        }
    }
    return $text;
}
add_filter( 'wp_trim_excerpt', 'jkl_video_excerpt', 5, 2 );

/**
 * Post Format: Chat
 * 
 * Retrieve the first 100 characters of the chat as styled post content (not the unstyled excerpt)
 
function jkl_chat_excerpt( $text, $raw_excerpt ) {
    if( 'chat' === get_post_format() && !$raw_excerpt ) {
        $content = apply_filters( 'the_content', get_the_content() );
        $text = substr( $content, 0, 500 ) . '…';
    }
    return $text;
}
add_filter( 'wp_trim_excerpt', 'jkl_chat_excerpt', 5, 2 );

/**
 * Retrieve the IDs for images in a gallery.
 *
 * @uses get_post_galleries() First, if available. Falls back to shortcode parsing,
 *                            then as last option uses a get_posts() call.
 *
 * @since Twenty Ten 1.6.
 *
 * @return array List of image IDs from the post gallery.
 
function jkl_get_gallery_images() {
    $images = array();

    $galleries = get_post_galleries( get_the_ID(), false );
    if( isset( $galleries[0]['ids'] ) )
        $images = explode( ',', $galleries[0]['ids'] );
    
    if( !$images ) {
        $images = get_posts( array(
                'fields'        => 'ids',
                'numberposts'   => 999,
                'order'         => 'ASC',
                'orderby'       => 'menu_order',
                'post_mime_type'=> 'image',
                'post_parent'   => get_the_ID(),
                'post_type'     => 'attachment',
        ) );
    }
    return $images;
}

/**
 * Get first image in a post
 * Requires WordPress 3.6.0
 * @link https://developer.wordpress.org/reference/functions/get_post_gallery_images/
 
function jkl_get_first_image_url() {
    $img_url = get_post_gallery_images();
    return !empty( $img_url ) ? $img_url[0] : ''; 
}
 *
 */