<?php
/**
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
            
                            <figure class="featured-image index-featured">
                                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                                    <?php the_post_thumbnail(); ?>
                                </a>
                            </figure>
            
                        <?php } else {
                            $img_url = get_post_gallery_images();
                            if( !empty( $img_url ) ) { ?>
            
                                <figure class="featured-image index-featured">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                                        <img src="<?php echo $img_url[0]; ?>">
                                    </a>
                                </figure>
            
                        <?php }
                        }
                        
                        // Count the number of images in the Gallery (or Galleries)
                        $images = get_post_galleries_images();  // from WordPress 3.6.0
                        if( $images ) :
                            $total_images = count( $images, COUNT_RECURSIVE ) - count( $images );
                            $total_galleries = count( $images );
                            $image = reset( $images );
                        endif;
                        
                        the_excerpt();
                        
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
        
    </div><!-- .hentry-index -->
</article><!-- #post-## -->
