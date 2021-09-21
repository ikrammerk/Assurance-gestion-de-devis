/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title a' ).html( newval );
		} );
	} );
	
	//Update the site description in real time...
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '.site-description' ).html( newval );
		} );
	} );

	//Update site background color...
	wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {
			
			$('body').css('background-color', newval );
		} );
	} );

	wp.customize( 'show_title', function( value ){

		value.bind( function( newval ){
			if( newval ){
				$( '.site-title' ).slideDown();
			}else{
				$( '.site-title' ).slideUp();
			}
		});
	} );

	wp.customize( 'show_tagline', function( value ){

		value.bind( function( newval ){
			if( newval ){
				$( '.site-description' ).slideDown();
			}else{
				$( '.site-description' ).slideUp();
			}
		})
	} );

	//Update site title color...
	wp.customize( 'site_title_color', function( value ){

		value.bind( function( newval ){
			$( '.site-title a' ).css( 'color', newval );
		});
	} );

	//Update site tagline color...
	wp.customize( 'site_tagline_color', function( value ){

		value.bind( function( newval ){
			$( '.site-description' ).css( 'color', newval );
		});
	} );

	wp.customize( 'slider_control', function( value ){

		value.bind( function( newval ){
			if( newval ){
				$( '.block-slider .controls' ).animate( { opacity: 1 }, 300 );
				$( '.block-slider .owl-pager' ).animate( { opacity: 1 }, 300 );
			}else{
				$( '.block-slider .controls' ).animate( { opacity: 0 }, 500 );
				$( '.block-slider .owl-pager' ).animate( { opacity: 0 }, 500 );
			}
		});
	} );

	wp.customize( 'menu_padding_top', function( value ){

		value.bind( function( newval ){
			console.log( newval );
			$( '#primary-nav-container' ).animate({
				'paddingTop': newval
			});
		});
	});

	wp.customize( 'enable_scroll_top_in_mobile', function( value ){
		value.bind( function( newval ){
			if( newval ){
				$( '#go-top' ).removeClass( 'hidden-xs' );
			}else{
				$( '#go-top' ).addClass( 'hidden-xs' );
			}
		})
	} )

} )( jQuery );
