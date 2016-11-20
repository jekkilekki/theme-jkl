<?php
/**
 * Post Format: Link
 * Template part for displaying Links.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="hentry-index entry-meta">

            <div class="entry-title">
                <?php jkl_link_screenshot( 150, true ); ?>
            </div>


	<div class="entry-content index-content">
            
            <div class="featured-image-index">
                <?php if( has_post_thumbnail() ) {
                    the_post_thumbnail( 'thumbnail' );
                } else {
                    jkl_link_screenshot( 150 ); 
                } ?>
            </div>
            
            <?php the_excerpt(); ?>
            
	</div><!-- .entry-content -->
        
    </div><!-- .hentry-index -->
    
    <div class="entry-footer-index">
        <?php jkl_entry_footer(); ?>
    </div>
</article><!-- #post-## -->
