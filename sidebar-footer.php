<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package jkl
 */

if ( ! is_active_sidebar( 'sidebar-footer' ) ) {
	return;
}
?>

<aside id="secondary-footer" class="footer-widget-area large-12 columns" role="complementary">
    <div class="row">
	<?php dynamic_sidebar( 'sidebar-footer' ); ?>
    </div>
</aside><!-- #secondary-footer -->
