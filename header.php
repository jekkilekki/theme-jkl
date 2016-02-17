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
                    <div class="site-branding top-bar-title small-6 medium-12 large-12 columns <?php echo has_site_icon() ? 'with-icon' : ''; ?> ">
                            <?php 
                            // Add logo (site icon) 
                            $site_title = get_bloginfo( 'name' ); 
                            $site_icon = esc_url( get_site_icon_url( 200 ) ); ?>

                            <div class="site-logo">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <div class="screen-reader-text">
                                        <?php printf( esc_html( 'Go to the homepage of %1$s', 'jkl' ), $site_title ); ?>
                                    </div>
                                    <div class="site-icon-title">
                                        <?php 
                                        if ( has_site_icon() ) : ?>
                                            <img class="site-icon" src="<?php echo $site_icon; ?>" alt="">
                                        <?php
                                        else : ?>
                                            <p><?php echo $site_title; ?></p>
                                        <?php
                                        endif; ?>
                                    </div>
                                </a>
                            </div>
                        
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
                    
                </div><!-- .row Foundation -->
                    
                <div id="primary-nav-bar">
                        <div class="row">
                            <div id="main-nav-division" class="small-4 medium-2 medium-push-10 large-8 columns">
                                    <nav id="site-navigation" class="main-navigation" role="navigation">
                                            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'jkl' ); ?></button>
                                            
                                            <?php 
                                            // This is the split menu, only showing up on larger screens - custom menu output ?>
                                            <div class="split-navigation-menu show-for-large">
                                                <?php 
                                                $split_nav = jkl_split_main_nav( 'primary', false ); 
                                                echo $split_nav->left_menu;
                                                echo $split_nav->right_menu;
                                                ?>
                                            </div>
                                            
                                            <?php
                                            // This is the full navigation menu, original from Underscores, using TwentyFifteen toggles - shown on tablets and mobile devices ?>
                                            <div class="full-navigation-menu show-for-medium-down hide-for-large-up">
                                                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'nav-menu' ) ); ?>
                                            </div>

                                    </nav><!-- #site-navigation -->
                            </div><!-- .top-bar-center NON-Foundation -->

                            <div id="social-links-division" class="small-8 medium-6 hide-for-medium large-6 columns">
                                    <nav id="social-menu-container" class="social-menu">
                                        <?php jkl_social_menu(); ?>
                                    </nav>
                            </div><!-- .top-bar-right Foundation -->
                        </div><!-- .row Foundation -->        
                </div><!-- #primary-nav-bar -->
                
            </div><!-- .top-bar Foundation -->
               
            <div class="row site-header-image">
                <?php if ( get_header_image() && !has_post_thumbnail() ) : ?>
                    <div class="small-12 columns" style="background-image: url(<?php header_image(); ?>)"></div><!-- .site-header-image -->
                        
                        <?php if ( !is_single() && !is_page() ) : ?>
                        <div class="site-main-title-box">
                            <hgroup>
                            
                            <?php
                            if ( is_front_page() && is_home() ) : ?>
                                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                    <?php
                                    $description = get_bloginfo( 'description', 'display' );
                                    if ( $description || is_customize_preview() ) : ?>
                                        <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                                    <?php
                                    endif; ?>
                            <?php 
                            else : ?>
                                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php
                            endif; ?>

                            </hgroup>
                        </div><!-- .site-main-title-box -->
                        <?php endif; ?>
                       
                <?php elseif ( has_post_thumbnail() ) : ?>
                    <div class="small-12 columns" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post, 'featured' ); ?>)"></div><!-- .site-header-image .featured-image -->
                <?php endif; // End header image check. ?>
            </div>
	</header><!-- #masthead -->
        
        <div id="site-search-container" class="search-box-wrapper clear row">
            <div class="site-search clear large-12 columns">
                <?php get_search_form(); ?>
            </div><!-- .site-search -->
        </div><!-- #site-search-container -->

	<div id="content" class="site-content">
