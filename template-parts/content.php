<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="hentry-index">
	<header class="entry-header index-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
                        
                        // Add Featured Image after the Lead-in (if there is one)
                        if ( has_post_thumbnail() ) { ?>
                            <figure class="featured-image">
                                <?php the_post_thumbnail(); ?>
                            </figure>
                        <?php }

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta index-meta">
			<?php jkl_index_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content index-content">
		<?php
			the_excerpt();

			/*
                         * wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jkl' ),
				'after'  => '</div>',
			) );
                         * 
                         */
		?>
	</div><!-- .entry-content -->
        
        <div class="continue-reading">
            <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                <?php
                    printf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue … %s', 'jkl' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
                        );
                ?>
            </a>
        </div><!-- .continue-reading -->
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
