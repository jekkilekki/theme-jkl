<?php
/**
 * Template part for displaying Media posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

$sticky_class = is_sticky() ? 'single-sticky' : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $sticky_class ); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
                        
                        if( 'video' === get_post_format() ) {
                            echo '<div class="single-featured-video">';
                            jkl_get_the_video();
                            echo '</div>';
                        } else if( 'audio' === get_post_format() ) {
                            echo '<div class="single-featured-audio">';
                            jkl_get_the_audio();
                            echo '</div>';
                        } else if( has_post_thumbnail() ) {
                            echo '<div class="single-featured-image featured-image">';
                            the_post_thumbnail();
                            echo '</div>';
                        }
                ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php 
                        // Add a Lead-in (from the Excerpt) if there is one
                        if ( is_single() && 'post' === get_post_type() && has_excerpt( $post->ID ) ) { ?>
                            <div class="entry-meta">
                                <?php jkl_posted_on(); ?>
                            </div><!-- .entry-meta -->
                            <div class="lead-in">
                                <?php echo '<p>' . get_the_excerpt() . '</p>'; ?>
                            </div><!-- .lead-in -->
                        <?php }

                        // No additional Featured images for Video / Audio single posts (only in the header)
                
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'jkl' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jkl' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
        
	<footer class="entry-footer">
            <div class="footer-content group">
		<?php jkl_entry_footer(); ?>
            </div>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
