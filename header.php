<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package jkl
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
<?php if ( is_page_template( 'page-templates/page-sidebar-right.php' ) ) { ?>
    
    <div id="page" class="site sidebar-right">
        
<?php } else if ( is_page_template( 'page-templates/page-sidebar-left.php' ) ) { ?>
        
    <div id="page" class="site sidebar-left">
        
<?php } else if ( is_page_template( 'page-templates/page-no-sidebar.php' ) ) { ?>
        
    <div id="page" class="site no-sidebar">
        
<?php } else if ( is_page_template( 'page-templates/page-full-width.php' ) ) { ?>
        
    <div id="page" class="site no-sidebar page-full-width">
        
<?php } else { ?>   
        
    <div id="page" class="site <?php echo get_theme_mod( 'layout_setting', 'no-sidebar' ); ?>">
        
<?php } ?>
        
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'jkl' ); ?></a>
        
	<header id="masthead" class="site-header" role="banner">
            
            <!-- Site Search over EVERYTHING else - pushes site down if opened -->
            <div id="site-search-container" class="search-box-wrapper clear">
                <div class="site-search clear small-12 columns">
                    <?php get_search_form(); ?>
                </div><!-- .site-search -->
            </div><!-- #site-search-container -->
            
            <div class="top-bar">
                <div class="row">
                
                <?php 
                // Only create a shadow (outline) for the site icon IF there is an icon
                if ( has_custom_logo() ) { ?>
                    <div class="site-logo-shadow"></div>
                <?php } ?>
                    
                    
                <div class="site-logo-housing">
                    <div class="site-branding top-bar-title small-6 medium-12 large-12 columns <?php echo has_custom_logo() ? 'with-icon' : ''; ?> ">

                            <?php 
                            // Add logo (site icon)
                            // BUT only show the site logo IF there is one, otherwise, show nothing
                            if ( has_custom_logo() ) : 
                                $site_title = get_bloginfo( 'name' );
                                //$site_icon = esc_url( get_site_icon_url( 200 ) ); 
                                ?>
                            
                                <div class="site-logo">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <div class="screen-reader-text">
                                            <?php printf( esc_html( 'Go to the homepage of %1$s', 'jkl' ), $site_title ); ?>
                                        </div>
                                        <div class="site-icon-title">
                                            <?php if( function_exists( 'the_custom_logo' ) ) { the_custom_logo(); }
                                            /* if ( has_site_icon() ) : */ ?>
                                                 <!--<img class="site-icon" src="<?php // echo $site_logo[0]; ?>" alt="">-->
                                            <?php
                                            /* else : // We could use this LATER in v.2 if we want to the site title in place of the icon - styles exist EXCEPT for thin-bar and responsive ?>
                                                <p><?php echo $site_title; ?></p>
                                            <?php
                                            endif; */ ?>
                                        </div>
                                    </a>
                                </div>
                        
                            <?php endif; ?>
                        
                        
                            <?php
                            if ( is_front_page() && is_home() ) : ?>
                                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php else : ?>
                                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php
                            endif;

                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ) : ?>
                                    <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                            <?php
                            endif; ?>
                    </div><!-- .site-branding -->
                    
                    <div class="search-toggle">
                        <i class="fa fa-search"></i>
                        <a href="#search-container" class="screen-reader-text"><?php _e( 'Search this site', 'jkl' ); ?></a>
                    </div>
                    
                </div><!-- .site-logo-housing -->    
                </div><!-- .row Foundation -->
                    
                <div id="primary-nav-bar" class="columns">
                    <div id="main-nav-division" class="small-4 medium-2 medium-push-10 large-8">
                            <nav id="site-navigation" class="main-navigation" role="navigation">
                                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'jkl' ); ?></button>

                                    <?php 

                                    // If the primary menu is set, and there's a site logo, obviously split the menu
                                    if ( has_custom_logo() ) :

                                            // This is the split menu, only showing up on larger screens - custom menu output ?>
                                            <div class="split-navigation-menu show-for-large">
                                                <?php 
                                                if ( has_nav_menu( 'primary' ) ) {
                                                    $split_nav = jkl_split_main_nav( 'primary', false ); 
                                                    echo $split_nav->left_menu;
                                                    echo $split_nav->right_menu;
                                                } else {
                                                    echo '<em class="menu-warning">' . __( 'Please select a menu for your primary navigation.', 'jkl') . '</em>';
                                                }
                                                ?>
                                            </div>

                                    <?php
                                    endif; 
                                    // The next menu is the FULL navigation menu, original from Underscores, using TwentyFifteen toggles - shown on tablets and mobile devices 
                                    ?>

                                    <div class="full-navigation-menu <?php echo has_custom_logo() ? 'hide-for-large' : 'split-navigation-menu'; ?>">
                                        <?php wp_nav_menu( array( 
                                                    'theme_location' => 'primary', 
                                                    'menu_id' => 'primary-menu', 
                                                    'menu_class' => 'nav-menu',
                                                    // 'depth' => 2
                                            ) ); ?>
                                    </div>


                            </nav><!-- #site-navigation -->
                    </div><!-- .top-bar-center NON-Foundation -->      
                </div><!-- #primary-nav-bar -->
                
                <?php
                if ( has_nav_menu( 'social' ) ) : ?>
                        <div id="social-links-division" class="small-8 medium-6 hide-for-medium large-6 columns">
                                <nav id="social-menu-container" class="social-menu">
                                    <?php jkl_social_menu(); ?>
                                </nav>
                        </div><!-- #social-links-division -->
                <?php 
                endif; ?>
                
            </div><!-- .top-bar Foundation -->
               
	</header><!-- #masthead -->
        
        <div class="row site-header-image">
                <?php if ( get_header_image() && !has_post_thumbnail() /* && !is_front_page() */ ) : ?>
                    <div class="site-header-img small-12 columns" style="background-image: url(<?php header_image(); ?>)"></div><!-- .site-header-image -->
                        
                        <?php if ( !is_single() && !is_page() ) : ?>
                        <div class="site-main-title-container">
                            <div class="site-main-title-box">
                                <hgroup>
                                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                        <?php
                                        $description = get_bloginfo( 'description', 'display' );
                                        if ( $description || is_customize_preview() ) : ?>
                                            <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                                        <?php
                                        endif; ?>
                                </hgroup>
                            </div><!-- .site-main-title-box -->
                        </div><!-- .site-main-title-container -->
                        <?php endif; ?>
                       
                <?php elseif ( has_post_thumbnail() ) : ?>
                    <div class="site-header-img small-12 columns" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post, 'jkl_featured' ); ?>)"></div><!-- .site-header-image .featured-image -->
                <?php endif; // End header image check. ?>
            </div>

	<div id="content" class="site-content">
