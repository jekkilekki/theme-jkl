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
            <?php the_content(); ?>
            <?php // jkl_index_posted_on(); ?>
	</div><!-- .entry-content -->
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
