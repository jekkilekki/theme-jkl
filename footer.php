<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package jkl
 */

?>

	</div><!-- #content -->
        
        <a href="#topbutton" class="topbutton"></a>
        
	<footer id="colophon" class="site-footer" role="contentinfo">
            <div class="row">

                <?php get_sidebar( 'footer' ); ?>
                
                <div class="footer-navigation large-12 columns">
                    <?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu', 'menu_class' => 'nav-menu' ) ); ?>
                </div>
                
		<div class="site-info">
                    <div class="small-12 medium-6 columns copyright">
                        <?php echo jkl_dynamic_copyright(); ?>
                    </div>
                    <div class="small-12 medium-6 columns publisher text-right">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'jkl' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'jkl' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'jkl' ), 'jkl', '<a href="http://www.aaronsnowberger.com" rel="designer">Aaron Snowberger</a>' ); ?>
                    </div>
                </div><!-- .site-info -->
            </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
