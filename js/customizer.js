/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-main-title-box, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-main-title-box, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
        
        // Custom Customizer Functions
        // Menu color and Menu text color
        wp.customize( 'menu_color', function( value ) {
		value.bind( function( to ) {
			$( '.split-navigation-menu' ).css( {
                            'background-color': to 
                        } );
		} );
	} );
        wp.customize( 'menu_text_color', function( value ) {
		value.bind( function( to ) {
			$( '#main-nav-left li a, #main-nav-right li a' ).css( {
                            'color': to 
                        } );
		} );
	} );
        
        
        // Custome Layout (Sidebar) Options
        wp.customize( 'layout_setting', function( value ) {
		value.bind( function( to ) {
			$( '#page' ).removeClass( 'no-sidebar sidebar-right sidebar-left' ); 
                        $( '#page' ).addClass( to );
		} );
	} );
} )( jQuery );
