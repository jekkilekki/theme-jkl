<?php
/**
 * Template part for displaying Asides.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php jkl_index_posted_on(); ?>
    <div class="hentry-index entry-meta" <?php if ( has_post_thumbnail() ) : ?>
                style="background-image: url(<?php echo get_the_post_thumbnail_url( $post, 'jkl_featured' ); ?>)"
                <?php endif; // End header image check. ?>>
        <div class="quote-overlay">
	<div class="entry-content index-content">		
            <?php the_excerpt(); ?>
	</div><!-- .entry-content -->
        </div>
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
