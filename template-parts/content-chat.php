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
	<div class="hentry-index">
	<header class="entry-header index-header group">
		<?php
			
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta index-meta">
			<?php jkl_index_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content index-content">
		<?php
                        // Add Featured Image
                        if ( has_post_thumbnail() ) : ?>

                            <figure class="featured-image-index">
                                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                </a>
                            </figure>
                            <div class="excerpt-has-image">

                        <?php else : ?>
                            <div class="excerpt-no-image">

                        <?php endif; ?>

                                    <?php the_excerpt(); ?>

                            </div><!-- END excerpt div -->
                            
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
        
        <div class="entry-footer-index">
            <?php jkl_entry_footer(); ?>
        </div>
</article><!-- #post-## -->

