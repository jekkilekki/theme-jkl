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
    <div class="hentry-index">

	<div class="entry-content index-content">
            
            <?php jkl_posted_on(); ?>
            
            <?php the_content(); ?>
            
            <div class="entry-footer-index">
                <?php jkl_entry_footer(); ?>
            </div>
            
	</div><!-- .entry-content -->
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
