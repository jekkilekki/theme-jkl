<?php
/**
 * Template part for displaying Statuses.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="hentry-index">

	<div class="entry-content index-content">
            
            <?php jkl_posted_on(); ?>
            
            <?php if( has_post_thumbnail() ) { ?>
                <div class="featured-image">
                    <?php the_post_thumbnail( 'large' ); ?>
                </div>
            <?php } ?>
            
            <?php the_content(); ?>
            
            <div class="entry-footer-index">
                <?php jkl_entry_footer(); ?>
            </div>
            
	</div><!-- .entry-content -->
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
