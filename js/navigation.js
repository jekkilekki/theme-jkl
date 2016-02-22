/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
( function( $ ) {
	var container, button, menu, links, subMenus;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}
        
        function initMainNavigation( container ) {
		// Add dropdown toggle that display child menu items.
		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( '<button class="dropdown-toggle" aria-expanded="false">' + screenReaderText.expand + '</button>' );

		// Toggle buttons and submenu items with active children menu items.
		container.find( '.current-menu-ancestor > button' ).addClass( 'toggle-on' );
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

		container.find( '.dropdown-toggle' ).click( function( e ) {
			var _this = $( this );
			e.preventDefault();
			_this.toggleClass( 'toggle-on' );
			_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			_this.html( _this.html() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
		} );
	}
	initMainNavigation( $( '.main-navigation' ) );

	// Re-initialize the main navigation when it is updated, persisting any existing submenu expanded states.
	$( document ).on( 'customize-preview-menu-refreshed', function( e, params ) {
		if ( 'primary' === params.wpNavMenuArgs.theme_location ) {
			initMainNavigation( params.newContainer );

			// Re-sync expanded states from oldContainer.
			params.oldContainer.find( '.dropdown-toggle.toggle-on' ).each(function() {
				var containerId = $( this ).parent().prop( 'id' );
				$( params.newContainer ).find( '#' + containerId + ' > .dropdown-toggle' ).triggerHandler( 'click' );
			});
		}
	});
        
        /**
         *  Scrolling funtions
         *  1. Make the header "thin" on scroll
         *  2. Show/hide the menu toggle on smaller screens
         *  2. Show/hide the menu bar on larger screens
         */
        var position, direction, previous;
        
        $( window ).scroll( function() {
            
            // Make the header "thin" on scroll
            var fixMenuHeight = 400;
            
            if ( $(this).scrollTop() >= fixMenuHeight ) {
                $( '.site-header' ).addClass( 'thin-bar' );
                $( '.top-bar' ).addClass( 'thin-bar' );
            } else {
                $( '.site-header' ).removeClass( 'thin-bar' );
                $( '.top-bar' ).removeClass( 'thin-bar' );
            }
            
            
            var winWidth = $( window ).width();
            
            // Show/hide the menu toggle on smaller screens
            if ( winWidth < 800 ) {
                if ( $(this).scrollTop() >= position && !( $( '#site-navigation' ).hasClass( 'toggled' ) ) ) {
                    direction = 'down';
                    if ( direction !== previous ) {
                        $( '#primary-nav-bar' ).addClass( 'hide' );
                        $( '#social-links-division' ).addClass( 'hide' );

                        previous = direction;
                    }
                } else {
                    direction = 'up';
                    if ( direction !== previous ) {
                        $( '#primary-nav-bar' ).removeClass( 'hide' );
                        $( '#social-links-division' ).removeClass( 'hide' );

                        previous = direction;
                    }
                }
            }
            // Show/hide the menu bar on larger screens
            else {
                if ( $(this).scrollTop() >= position && $(this).scrollTop() >= fixMenuHeight ) {
                    direction = 'down';
                    if ( direction !== previous ) {
                        $( '.thin-bar #primary-nav-bar' ).addClass( 'hide' );

                        previous = direction;
                    }
                } else {
                    direction = 'up';
                    if ( direction !== previous ) {
                        $( '.thin-bar #primary-nav-bar' ).removeClass( 'hide' );

                        previous = direction;
                    }
                }
            }
            position = $(this).scrollTop();
            
            
            
            
        } );
        
        // Appropriately resize the window 
        $( window ).resize( function() {
            if ( $( window ).width() > 640 ) {
                $( '#primary-nav-bar' ).removeClass( 'hide' );
                $( '.top-bar' ).removeClass( 'hide' );
            } else if ( $( window ).width() <= 640 && !( $( '#primary-nav-bar' ).hasClass( 'hide' ) ) ) {
                $( '#primary-nav-bar' ).removeClass( 'hide' );
                $( '.top-bar' ).removeClass( 'hide' );
            } else {
                $( '#primary-nav-bar' ).addClass( 'hide' );
                $( '.top-bar' ).addClass( 'hide' );
            }
        } );
        
        // Hide/show site menu on scroll (medium to large screens)
        /*var position2, direction2, previous2;
        
        $( window ).scroll( function() {
            var winWidth2 = $( window ).width();

            // If the nav-menu bar is showing
            if( winWidth2 > 800 ) {
                
            }
            if( $(this).scrollTop() <= 150 ) {
                $( '#primary-nav-bar' ).css( 'top', '92px' );
            }
            else if ( $(this).scrollTop() <= position2 && winWidth2 > 800 ) {
                direction2 = 'down';
                if ( direction2 !== previous2 ) {
                    $( '#primary-nav-bar' ).css( 'top', '50px' );
                    previous2 = direction2;
                }
            } else {
                direction2 = 'up';
                if ( direction2 !== previous2 ) {
                    $( '#primary-nav-bar' ).css( 'top', '0px' );
                    previous2 = direction2;
                }
            }
            position2 = $(this).scrollTop();
        } );*/
        
} )( jQuery );
