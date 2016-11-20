<?php
/**
 * Post Format: Page
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
                
                        // Add a Lead-in (from the Excerpt) if there is one
                        if ( has_excerpt( $post->ID ) ) {
                            echo '<div class="lead-in">';
                            echo '<p>' . get_the_excerpt() . '</p>';
                            echo '</div><!-- .lead-in -->';
                        }
                
                        // Add Featured Image after the Lead-in (if there is one)
                        if ( has_post_thumbnail() ) { ?>
                            <figure class="featured-image">
                                <?php the_post_thumbnail(); ?>
                            </figure>
                        <?php }
                
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jkl' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'jkl' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
