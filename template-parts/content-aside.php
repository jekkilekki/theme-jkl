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
                <?php
                edit_post_link(
                        sprintf(
                                /* translators: %s: Name of current post */
                                esc_html__( 'Edit %s', 'jkl' ),
                                the_title( '<span class="screen-reader-text">"', '"</span>', false )
                        ),
                        '<span class="edit-link">',
                        '</span>'
                );
                ?>
            </div>
	</footer><!-- .entry-footer -->
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
