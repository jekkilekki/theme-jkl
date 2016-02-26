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

<aside id="secondary-footer" class="footer-widget-area group" role="complementary">
	<?php dynamic_sidebar( 'sidebar-footer' ); ?>
</aside><!-- #secondary-footer -->
