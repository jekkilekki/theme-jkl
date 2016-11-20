<?php
/**
 * Footer
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
            
            <?php
            if ( has_nav_menu( 'footer' ) || is_active_sidebar( 'footer' ) ) : ?>
            <div class="site-footer-content <?php echo has_nav_menu( 'footer' ) ? 'has-footer-menu' : ''; ?>">
                <div class="row">
                <?php get_sidebar( 'footer' ); ?>
               
                <?php 
                if ( has_nav_menu( 'footer' ) ) : ?>
                    <div class="footer-navigation large-12">
                        <?php wp_nav_menu( array( 
                            'theme_location'    => 'footer', 
                            'menu_id'           => 'footer-menu', 
                            'menu_class'        => 'nav-menu',
                            'depth'             => 1
                        ) ); ?>
                    </div>
                <?php
                endif; ?>
                </div><!-- .row -->
            </div><!-- .site-footer-content -->
            <?php 
            endif; ?>
            
            <div class="site-info">
                <div class="row columns">
                <div class="small-12 medium-6 columns copyright">
                    <?php echo jkl_dynamic_copyright(); ?>
                </div>
                <div class="small-12 medium-6 columns publisher text-right">
                    <?php printf( 
                            esc_html__( '%1$s %2$s Theme by %3$s.', 'jkl' ),  
                                    '<a class="wporg-link" href="https://wordpress.org/"><i class="fa fa-wordpress"></i><span class="screen-reader-text">WordPress</span></a>', 
                                    'jkl',
                                    '<a href="http://www.aaronsnowberger.com" rel="designer">Aaron Snowberger</a>' 
                            ); ?>
                </div>
                </div><!-- .row -->
            </div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
