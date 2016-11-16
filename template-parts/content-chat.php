<?php
/**
 * Post Format: Chat
 * Template part for displaying Chats.
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
                        
                        jkl_index_posted_on();
                        
                        // Add a Lead-in (from the Excerpt) if there is one
                        if ( is_single() && 'post' === get_post_type() && has_excerpt( $post->ID ) ) {
                            echo '<div class="lead-in">';
                            echo '<p>' . get_the_excerpt() . '</p>';
                            echo '</div><!-- .lead-in -->';
                        }
                        
                        // Add Featured Image after the Lead-in (if there is one)
                        if ( has_post_thumbnail() && !has_excerpt( $post->ID ) &&
                                'quote' !== get_post_format() ) { ?>
                            <figure class="featured-image">
                                <?php the_post_thumbnail(); ?>
                            </figure>
                        <?php } ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
                        // Add Featured Image after the Lead-in (if there is one)
                        if ( has_post_thumbnail() && has_excerpt( $post->ID ) &&
                                'quote' !== get_post_format() ) { ?>
                            <figure class="featured-image">
                                <?php the_post_thumbnail(); ?>
                            </figure>
                        <?php }
                
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
        
        <div class="entry-footer-index">
            <?php jkl_entry_footer(); ?>
        </div>
</article><!-- #post-## -->

