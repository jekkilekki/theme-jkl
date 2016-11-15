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
    <div class="hentry-index entry-meta">

	<div class="entry-content index-content">
            <?php if ( is_singular() ) :
                jkl_link_screenshot( 600 );
            else :
                jkl_link_screenshot( 150 );
            endif;
            ?>
            
            <?php the_content(); ?>
            
	</div><!-- .entry-content -->
        
        <div class="entry-footer-index">
            <?php jkl_entry_footer(); ?>
        </div>
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
