/* 
 * A dynamic back to top button.
 * 
 * @source: https://premium.wpmudev.org/blog/back-to-top-button-wordpress/
 */

jQuery( document ).ready( function( $ ){
   var offset = 300;
   var speed = 250;
   var duration = 500;
   
   $( window ).scroll( function() {
      if ( $ ( this ).scrollTop() < offset ) {
          $( '.topbutton' ).fadeOut( duration );
      } else {
          $( '.topbutton' ).fadeIn( duration );
      }
   });
   
   $( '.topbutton' ).on( 'click', function() {
      $( 'html, body' ).animate( { scrollTop:0 }, speed);
      return false;
   });
   
   $( '.search-toggle' ).click( function() {
       $( '#site-search-container' ).slideToggle( 'slow', function() {
           $( '.search-toggle' ).toggleClass( 'active' );
       });
   });
});