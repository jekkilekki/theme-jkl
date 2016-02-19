<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

get_header(); ?>

	<div id="primary" class="content-area">
            
            <?php jkl_breadcrumbs(); ?>
            
            <?php if ( !is_404() && !is_search() ) : ?>
                <div id="site-search-container" class="search-box-wrapper clear row">
                    <div class="site-search clear large-12 columns">
                        <?php get_search_form(); ?>
                    </div><!-- .site-search -->
                </div><!-- #site-search-container -->
            <?php endif; ?>
                
                
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();
                        
                                // Is this the first post of the front page?
                                $first_post = $wp_query->current_post == 0 && !is_paged() && is_front_page() ? true : false;
                                
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				if ( $first_post ) {
                                    get_template_part( 'template-parts/content', 'single' );
                                } else {
                                    get_template_part( 'template-parts/content', get_post_format() );
                                }
                                    
			endwhile;

			jkl_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
