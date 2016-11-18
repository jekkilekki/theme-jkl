<?php
/**
 * Post Format: Gallery
 * Template part for displaying Gallery post formats on index pages.
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
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta index-meta">
			<?php jkl_index_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content index-content">
		<?php
                        
                        // Add Featured Image after the Lead-in (if there is one)
                        if ( has_post_thumbnail() ) { ?>
                            <ul class="index-gallery">
                                <li>
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                                        <figure class="gallery-image-index" style="background-image: url( <?php the_post_thumbnail_url( 'large' ); ?> )">
                                        </figure>
                                    </a>
                                </li>
            
                        <?php }  else { ?>
                            <ul class="index-gallery">
                        <?php }
                            
                            // Get the remainder of the gallery images
                            $images = jkl_get_gallery_images( 3 );
                            if( !empty( $images ) ) { 
                                
                                for( $i = 0; $i < count( $images ); $i++ ) {
                                ?>
                                
                                <li>
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                                        <figure class="gallery-image-index" style="background-image: url( <?php echo $images[$i]; ?> )">
                                        </figure>
                                    </a>
                                </li>
            
                                <?php } // end for
                            } // end if
                        
                        ?>
                            </ul>
            
                        <div class="clear"></div>

                        <?php
                        $total = jkl_get_gallery_count();
                        $total_galleries = $total[0];
                        $total_images = $total[1];
                        
                        if( $total_galleries === 1 ) : ?>
                        <p class="gallery-count"><em><?php printf( _n( 'There is %1$s photo in this gallery.', 'There are %1$s photos in this gallery.', $total_images, 'jkl' ), 
                                        number_format_i18n( $total_images ) 
                                ); ?></em></p>
            
                        <?php else : ?>
			<p class="gallery-count"><em><?php printf( _n( 'There is %1$s photo in %2$s galleries.', 'There are %1$s photos in %2$s galleries.', $total_images, $total_galleries, 'jkl' ), 
                                        number_format_i18n( $total_images ),
                                        number_format_i18n( $total_galleries )
                                ); ?></em></p>
                        <?php endif; ?>
                        
                        <?php the_excerpt(); ?>

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
