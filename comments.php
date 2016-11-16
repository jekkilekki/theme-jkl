<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'jkl' ) ),
					number_format_i18n( get_comments_number() )
				);
			?>
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'         => 'ol',
					'short_ping'    => true,
                                        'avatar_size'   => '96',
                                        'type'          => 'comment'
				) );
			?>
		</ol><!-- .comment-list -->
                
                <?php
                //$comments = get_comments( 'status=approve&type=ping&post_id=' . get_the_ID() );
                //$comments = separate_comments( $comments );
                
                //if( 0 < count( $comments[ 'pings' ] ) ) : ?>
                
                    <ol class="pings-list">
                        <h5 class="pings-list-title"><?php esc_attr_e( 'Pings', 'jkl' ); ?></h5>
                            <?php
                                    wp_list_comments( array(
                                            'style'         => 'ol',
                                            'short_ping'    => true,
                                            'type'          => 'pings'
                                    ) );
                            ?>
                    </ol><!-- .pings-list -->
                    
                <?php //endif; ?>

		<?php 
                // Paginate comments
                if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-pagination" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'jkl' ); ?></h2>
			<div class="nav-links">

				<?php paginate_comments_links(); ?>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. 

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'jkl' ); ?></p>
	<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
