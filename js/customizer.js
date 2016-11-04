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
			$( '#main-nav-left li a, #main-nav-right li a, #primary-menu li a' ).css( {
                            'color': to 
                        } );
		} );
	} );
        
        // Body (content) color
        wp.customize( 'body_text_color', function( value ) {
		value.bind( function( to ) {
			$( 'body, .entry-title' ).css( {
                            'color': to 
                        } );
		} );
	} );
        
        // Highlight colors
        wp.customize( 'highlight_color', function( value ) {
		value.bind( function( to ) {
			$( 'a:visited, a:hover, a:focus, a:active, .entry-content a, .entry-summary a' ).css( {
                            'color': to 
                        } );
                        $( '.search-toggle, .search-box-wrapper' ).css( {
                            'background-color': to
                        } );
                        
                        // For Sticky Posts headers (using :before pseudo-class)
                        // @see http://wpgothemes.com/add-customizer-color-pickers-for-hover-styles/
                        var style, el;
                        
                        style = '<style class="sticky-post-label">.sticky:before { background: ' + to + '; }</style>';
                        el = $( '.sticky-post-label' ); // look for a matching style element
                        
                        // add the style element into the DOM or replace the matching style element
                        if( el.length ) {
                            el.replaceWith( style );
                        } else {
                            $( 'head' ).append( style ); // style element doesn't exist so add it
                        }
                        
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
