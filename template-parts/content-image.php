<?php
/**
 * Post Format: Image
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
            
                            <figure class="featured-image index-featured">
                                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                                    <?php the_post_thumbnail(); ?>
                                </a>
                            </figure>
            
                        <?php 
                        // Or else, find the first image in the Post and use that
                        else :
                            $img_exists = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
                            $img_url = !empty( $matches[1][0] ) ? $matches[1][0] : '';

                            // Be sure there IS an image
                            if( $img_exists ) { ?>
            
                                <figure class="featured-image index-featured">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                                        <img src="<?php echo $img_url; ?>">
                                    </a>
                                </figure>
            
                            <?php }
                        endif;
                        
                        the_excerpt();
                        
		?>
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
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
