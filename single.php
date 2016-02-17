<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package jkl
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single' /* get_post_format() */ );
                        
                        jkl_post_nav();
                        
                        /*
                        // @Snippet: Nice little snippet for some cool stuff - also with flexbox in the CSS
			the_post_navigation( array(
                                'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next time', 'jkl' ) . '</span>' .
                                    '<span class="screen-reader-text">' . __( 'Next post:', 'jkl' ) . '</span>' .
                                    '<span class="post-title">%title</span>',
                                'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previously', 'jkl' ) . '</span>' .
                                    '<span class="screen-reader-text">' . __( 'Previous post:', 'jkl' ) . '</span>' .
                                    '<span class="post-title">%title</span>',
                            )
                        );
                         */
                        
                        
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
