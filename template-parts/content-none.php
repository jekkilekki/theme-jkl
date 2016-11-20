<?php
/**
 * Post Format: None
 * Template part for displaying a message that posts cannot be found (no posts, error 404, or search).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jkl
 */

?>

<section class="<?php if ( is_404() ) { echo 'error-404'; } else { echo 'no-results'; } ?> not-found">
	<header class="page-header">
		<h1 class="page-title">
                    <?php
                    if ( is_404() ) { esc_html_e( 'Page not available', 'jkl' );
                    } else if ( is_search() ) {
                        /* translators: %s = search query */
                        printf( esc_html__( 'Nothing found for &ldquo;%s&rdquo;', 'jkl' ) );
                    } else {
                        esc_html_e( 'Nothing Found', 'jkl' );
                    } ?>
                </h1>
	</header><!-- .page-header -->

	<div class="page-content sticky">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'jkl' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php 
                elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'jkl' ); ?></p>
			<?php
				get_search_form();
                
                elseif ( is_404() ) : ?>
                        
                        <p><?php esc_html_e( 'Are you lost? Maybe one of the a Search or one of the Latest Posts (below) will help.', 'jkl' ); ?></p>
                        <?php
                                get_search_form();

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'jkl' ); ?></p>
			<?php
				get_search_form();

		endif; ?>
	</div><!-- .page-content -->
        
        <?php 
        if ( is_404() || is_search() ) : ?>
            
            <h1 class="page-title secondary-title"><?php esc_html_e( 'Most recent posts', 'jkl' ); ?></h1>
            <?php 
            
            // Get the 6 latest posts
            $args = array(
                    'posts_per_page'    => 6
            );
            $latest_posts_query = new WP_Query( $args );
            
            // The Loop
            if ( $latest_posts_query->have_posts() ) {
                    while ( $latest_posts_query->have_posts() ) {
                        $latest_posts_query->the_post();

                        // Get the standard index page content
                        get_template_part( 'template-parts/content', get_post_format() );
                    }
            }
            
            /* Restore original Post Data */
            wp_reset_postdata();
        
        endif; ?>
        
</section><!-- .no-results -->
