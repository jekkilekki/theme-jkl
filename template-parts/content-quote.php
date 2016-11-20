<?php
/**
 * Post Format: Quote
 * Template part for displaying Quotes.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if( is_single() ) { ?>
        <header class="entry-header">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>                                
	</header><!-- .entry-header -->
    <?php } ?>
    
    <?php jkl_index_posted_on(); ?>
    
    <div class="hentry-index entry-meta" <?php if ( has_post_thumbnail() ) : ?>
                style="background-image: url(<?php echo get_the_post_thumbnail_url( $post, 'jkl_featured' ); ?>)"
                <?php endif; // End header image check. ?>>
        
        <div class="quote-overlay">
            <div class="entry-content index-content">
                <?php if( is_single() ) {
                    jkl_get_the_quote(); 
                } else {
                    the_excerpt(); 
                } ?>
            </div>
        </div>
        
    </div><!-- .hentry-index -->
    
    <?php if( is_single() ) { ?>
            <?php
                // Add a Lead-in (from the Excerpt) if there is one
                if ( is_single() && 'post' === get_post_type() && has_excerpt( $post->ID ) ) { ?>
                    <div class="lead-in">
                        <?php echo '<p>' . get_the_excerpt() . '</p>'; ?>
                    </div><!-- .lead-in -->
                <?php }
            ?>
            <div class="entry-content after-quote">

                <?php the_content(); ?>

            </div><!-- .entry-content -->
    <?php } ?>
    
    <div class="entry-footer-index">
        <?php jkl_entry_footer(); ?>
    </div>
    
</article><!-- #post-## -->
