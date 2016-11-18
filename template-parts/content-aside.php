<?php
/**
 * Post Format: Aside
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
            <?php the_content(); ?>
	</div><!-- .entry-content -->
        
        <footer class="entry-footer">
            <div class="footer-content group">
		<?php jkl_index_posted_on(); ?>
            </div>
	</footer><!-- .entry-footer -->
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
