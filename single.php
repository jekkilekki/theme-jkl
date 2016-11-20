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
            
                
                <div id="breadcrumbs-container" class="small-12 columns">
                    <?php jkl_breadcrumbs(); ?>
                </div>

            
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

                        // Statuses and Quotes - use their own Post Format designs
                        if( has_post_format( array( 'status', 'quote' ) ) ) {
                            get_template_part( 'template-parts/content', get_post_format() );
                        } 
                        
                        // Video, Audio, Images, and Galleries - have a special Media Post Format design (media content above meta info)
                        else if( has_post_format( array( 'video', 'audio', 'image', 'gallery' ) ) ) {
                            get_template_part( 'template-parts/content', 'single-media' );
                        }
                        
                        // Asides, Chats, and Links - get a smaller title and meta
                        else if( has_post_format( array( 'aside', 'chat', 'link', 'quote' ) ) ) {
                             get_template_part( 'template-parts/content', 'single-small' );
                        } 
                        
                        // Everything else gets the standard Single Post design
                        else {
                             get_template_part( 'template-parts/content', 'single' );
                        }
                        
                        jkl_post_nav();
                        
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
