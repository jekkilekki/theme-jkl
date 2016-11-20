<?php
/**
 * Single Post Format: (Standard) posts
 * Template part for displaying standard (default) posts.
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
                        
                        // Add a Lead-in (from the Excerpt) if there is one
                        if ( is_single() && 'post' === get_post_type() && has_excerpt( $post->ID ) && 'video' !== get_post_format() ) {
                            echo '<div class="lead-in">';
                            echo '<p>' . get_the_excerpt() . '</p>';
                            echo '</div><!-- .lead-in -->';
                        }
                        
                        if( 'video' === get_post_format() ) {
                            echo '<div class="single-featured-video">';
                            jkl_get_the_video();
                            echo '</div>';
                        }
                        
                        // Add Featured Image after the Lead-in (if there is one)
                        if ( has_post_thumbnail() && !has_excerpt( $post->ID ) &&
                                'quote' !== get_post_format() ) { ?>
                            <figure class="featured-image">
                                <?php the_post_thumbnail(); ?>
                            </figure>
                        <?php }

		if ( 'post' === get_post_type() && !is_front_page() && 'video' !== get_post_format() ) : ?>
		<div class="entry-meta">
			<?php jkl_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
                elseif ( 'quote' === get_post_format() ||
                         'link' === get_post_format() ||
                         'aside' === get_post_format() || 
                         'chat' === get_post_format() ) : ?>
		<?php jkl_index_posted_on(); 
                
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
                        
                        // Add a Lead-in (from the Excerpt) if there is one
                        if ( is_single() && 'post' === get_post_type() && has_excerpt( $post->ID ) && 'video' === get_post_format() ) { ?>
                            <div class="entry-meta">
                                <?php jkl_posted_on(); ?>
                            </div><!-- .entry-meta -->
                            <div class="lead-in">
                                <?php echo '<p>' . get_the_excerpt() . '</p>'; ?>
                            </div><!-- .lead-in -->
                        <?php }

                        // Add Featured Image after the Lead-in (if there is one)
                        if ( has_post_thumbnail() && has_excerpt( $post->ID ) &&
                                'video' !== get_post_format() ) { ?>
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
        
        <?php 
        if ( 'aside' !== get_post_format() &&
             'link' !== get_post_format() ) : ?>
	<footer class="entry-footer">
            <div class="footer-content group">
		<?php jkl_entry_footer(); ?>
            </div>
	</footer><!-- .entry-footer -->
        <?php else : ?>
            <div class="entry-footer-index">
                <?php jkl_entry_footer(); ?>
            </div>
        <?php endif; ?>
</article><!-- #post-## -->
