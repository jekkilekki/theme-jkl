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
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'jkl' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
            <div class="top-bar">
                <div class="row">
                    <div class="site-branding top-bar-title medium-6 large-3 columns">
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

                    <?php 
                    if ( has_site_icon() ) {
                        
                            // Display logo in the center of the menu 
                            // split_main_nav();
                        
                    } else { ?>
                    
                            <div class="top-bar-right medium-6 large-9 columns">
                                <nav id="site-navigation" class="main-navigation" role="navigation">
                                        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'jkl' ); ?></button>
                                        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
                                </nav><!-- #site-navigation -->
                            </div><!-- .top-bar-right Foundation -->
                            
                    <?php } ?>
                
                </div><!-- .row Foundation -->
            </div><!-- .top-bar Foundation -->
            
            <?php if ( get_header_image() ) : ?>
            <div class="row site-header-image">
                <div class="small-12 columns" style="background-image: url(<?php header_image(); ?>)"></div><!-- .site-header-image -->
            </div>
            <?php endif; // End header image check. ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
