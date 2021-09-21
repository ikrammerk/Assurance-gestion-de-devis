;(function( $ ){

jQuery.fn.scrollTo = function( offset ){

	jQuery( document ).on( 'click', '.scroll-to', function( e ){
		e.preventDefault();
		var target = jQuery( this ).attr( 'href' );
		if( 'undefined' != typeof target ){
			if( !offset ){
				offset = 0;
			}
			var pos = jQuery( target ).offset().top - offset;
			jQuery("html, body").animate({ scrollTop: pos }, 800);
		}
	});

	return this;
};

function scrollToTop ( param ){

	this.markup   = null,
	this.selector = null;
	this.fixed    = true;
	this.visible  = false;

	this.init = function(){

		if( this.valid() ){

			if( typeof param != 'undefined' && typeof param.fixed != 'undefined' ){
				this.fixed = param.fixed;
			}

			this.selector = ( param && param.selector ) ? param.selector : '#go-top';

			this.getMarkup();
			var that = this;

			jQuery( 'body' ).append( this.markup );

			if( this.fixed ){

				jQuery( this.selector ).hide();

				var windowHeight = jQuery( window ).height();

				jQuery( window ).scroll(function(){

					var scrollPos = jQuery( window ).scrollTop();

					if(  ( scrollPos > ( windowHeight - 100 ) ) ){

						if( false == that.visible ){
							jQuery( that.selector ).fadeIn();
							that.visible = true;
						}
						
					}else{

						if( true == that.visible ){
							jQuery( that.selector ).fadeOut();
							that.visible = false;
						}
					}
				});

				jQuery( this.selector ).scrollTo();
			}
		}
	}

	this.getMarkup = function(){

		var position = this.fixed ? 'fixed':'absolute';

		var wrapperStyle = 'style="position: '+position+'; z-index:999999; bottom: 20px; right: 20px;"';

		var buttonStyle  = 'style="cursor:pointer;display: inline-block;padding: 10px 20px;background: #f15151;color: #fff;border-radius: 2px;"';

		var markup = '<div ' + wrapperStyle + ' id="go-top"><span '+buttonStyle+'>Scroll To Top</span></div>';

		this.markup   = ( param && param.markup ) ? param.markup : markup;
	}

	this.valid = function(){

		if( param && param.markup && !param.selector ){
			alert( 'Please provide selector. eg. { markup: "<div id=\'scroll-top\'></div>", selector: "#scroll-top"}' );
			return false;
		}

		return true;
	}
};

/**
* Setting up functionality for alternative menu
* @since Business Gravity 1.0.0
*/
function wpMenuAccordion( selector ){

	var $ele = selector + ' .menu-item-has-children > a';
	$( $ele ).each( function(){
		var text = $( this ).text();
		text = text + '<button class="kfi kfi-arrow-carrot-down-alt2 triangle"></button>';
		$( this ).html( text );
	});

	$( document ).on( 'click', $ele + ' .triangle', function( e ){
		e.preventDefault();
		e.stopPropagation();

		$parentLi = $( this ).parent().parent( 'li' );
		$childLi = $parentLi.find( 'li' );

		if( $parentLi.hasClass( 'open' ) ){
			/**
			* Closing all the ul inside and 
			* removing open class for all the li's
			*/
			$parentLi.removeClass( 'open' );
			$childLi.removeClass( 'open' );

			$( this ).parent( 'a' ).next().slideUp();
			$( this ).parent( 'a' ).next().find( 'ul' ).slideUp();
		}else{

			$parentLi.addClass( 'open' );
			$( this ).parent( 'a' ).next().slideDown();
		}
	});
};

/**
* Fire for fixed header
* @since Business Gravity 1.0.0
*/

function primaryHeader(){
	var h,
	fixedHeader = 'fixed-nav-active',
	addClass = function(){
		if( !$( 'body' ).hasClass( fixedHeader ) ){
			$( 'body' ).addClass( fixedHeader );
		}
	},
	removeClass = function(){
		if( $( 'body' ).hasClass( fixedHeader ) ){
			$( 'body' ).removeClass( fixedHeader );
		}
	},
	setPosition = function( top ){
		$( '#fixed-header' ).css( {
			'top' : top
		});
	},
	addCSS = function(){
		$( '#fixed-header' ).css({
			'margin-top' : '0'
		});
	},
	removeCSS = function(){
		$( '#fixed-header' ).css({
			'margin-top' : '-100%'
		});
	},
	init = function(){
		h = $( '.top-header' ).outerHeight() + $( '#masthead' ).outerHeight();
		setPosition( h );
	},
		
	onScroll = function(){
		var scroll = jQuery(document).scrollTop(),
			pos = 0,
			height = h + 12,
			width = $( window ).width();

		if( BUSINESSGRAVITY.is_admin_bar_showing && width >= 782 ){
			scroll = scroll+32;
		}

		if( height ){
			if( height >= scroll ){
				pos = height-jQuery(document).scrollTop();
				removeClass();
				removeCSS();
			}else if( BUSINESSGRAVITY.is_admin_bar_showing && width >= 782 ){
				pos = 32;
				addClass();
				addCSS();
			}else{
				addClass();
				addCSS();
			}

		}else{

			var mh = $( '.top-header, #masthead' ).outerHeight(),
				scroll = jQuery(document).scrollTop();
			if( mh >= scroll ){
				if( BUSINESSGRAVITY.is_admin_bar_showing && width >= 782 ){
					pos = 32-scroll;
				}else{
					pos = -scroll;
				}
				removeClass();
				removeCSS();
			}else{
				
				if( BUSINESSGRAVITY.is_admin_bar_showing && width >= 782 ){
					pos = 32;
				}else{
					pos = 0;
				}
				addClass();
				addCSS();
			}
		}
		
		setPosition( pos );
	};
	
	$( window ).resize(function(){
		init();
		onScroll();
	});

	init();
	onScroll();
	
	$( window ).scroll( onScroll );

	jQuery( window ).load( function(){
		init();
		onScroll();
	});
}

/**
* For Header Four style maintain
* @since Business Gravity 1.0.0
*/
function headerFourstyle(){

	var th = $('.top-header').outerHeight(),
	    mh4 = $('.site-header-four').outerHeight();

	$('.site-header-four').css({
		'top' : th
	});

	if( BUSINESSGRAVITY.is_admin_bar_showing){
		$('.site-header-four').css({
			'top' : th + 45
		});
	}

	$('.wrap-inner-banner .page-header, .block-slider .slide-inner').css({
		'paddingTop' : mh4
	});
}

/**
* Increase cart count when product is added by ajax 
* @uses Woocommerce
* @since Business Gravity 1.0.0
*/
jQuery( document ).on( 'added_to_cart', function(){
	$ele = $( '.cart-icon .count' );
	var count = $ele.text();
	$ele.text( parseInt( count ) + 1 );
});

/**
* Show or Hide Search field on clicking search icon
* @since Business Gravity 1.0.0
*/
jQuery( document ).on( 'click', '.top-header-right .search-icon', function( e ){
	e.preventDefault();
	jQuery( '#search-form' ).toggleClass('search-slide');
});

/**
* Fire equal height
* @since Business Gravity 1.0.0
*/

function equaleHeight( ele ){
	
	var getMaxHeight = function(){
		var height = 0 ;
		jQuery( ele ).height( 'auto' );
		jQuery( ele ).each( function(){
			if( jQuery( this ).height() > height ){
				height = jQuery( this ).height();
			}
		});
		return height;
	};

	var init = function(){

		var width = jQuery( window ).width();
		var height = getMaxHeight();
		jQuery( ele ).each( function(){
			jQuery( this ).height( height );
		});
		
	};



	jQuery( document ).ready( function(){
		init();
	});

	jQuery( window ).resize( function(){
		init();
	});

	jQuery( window ).load( function(){
		init();
	});
};

equaleHeight( '.block-slider .slide-item' );

/**
* Fire Slider for Testimonials
* @link https://owlcarousel2.github.io/OwlCarousel2/docs/started-welcome.html
* @since Business Gravity 1.0.0
*/
function testimonialSlider(){
	$(".testimonial-carousel").owlCarousel({
		items: 1,
		animateOut: 'fadeOut',
		navContainer: '.block-testimonial .controls',
		dotsContainer: '#testimonial-pager',
		responsiveClass:true,
	    responsive:{
	        0:{
	            items:1,
	            nav:true
	        }
	    },
	    rtl: ( BUSINESSGRAVITY.is_rtl == '1' ) ? true : false ,
		loop : false,
		dots: true
	});	
};

/**
* Fire slider for homepage
* @link https://owlcarousel2.github.io/OwlCarousel2/docs/started-welcome.html
* @since Business Gravity 1.0.0
*/
function homeSlider(){
	var item_count = parseInt(jQuery( '.block-slider .slide-item').length);
	jQuery(".home-slider").owlCarousel({
		items: 1,
		autoHeight: false,
		autoHeightClass: 'name',
		animateOut: 'fadeOut',
    	navContainer: '.block-slider .controls',
    	dotsContainer: '#kt-slide-pager',
    	autoplay : BUSINESSGRAVITY.home_slider.autoplay,
    	autoplayTimeout : parseInt( BUSINESSGRAVITY.home_slider.timeout ),
    	loop : ( item_count > 1 ) ? true : false,
    	rtl: ( BUSINESSGRAVITY.is_rtl == '1' ) ? true : false,
	});
};

/**
* Fire highlight slider for homepage
* @link https://owlcarousel2.github.io/OwlCarousel2/docs/started-welcome.html
* @since Business Gravity 1.0.0
*/
function highlightSlider(){
	var item_count = parseInt(jQuery( '.block-highlight .slide-item').length);
	jQuery(".highlight-slider").owlCarousel({
		items: 1,
		autoHeight: false,
		autoHeightClass: 'name',
		animateOut: 'fadeOut',
    	navContainer: '.block-highlight .controls',
    	margin: 30,
    	autoplay : BUSINESSGRAVITY.highlight.autoplay,
    	loop : ( item_count > 1 ) ? true : false,
    	rtl: ( BUSINESSGRAVITY.is_rtl == '1' ) ? true : false,
    	responsive:{
    	    768:{
    	        items: 3,
    	        nav: true,
    	    }
    	},
	});
};
/**
* Animate contact form fields when they are focused
* @since Business Gravity 1.0.0
*/
jQuery( '.kt-contact-form-area input, .kt-contact-form-area textarea' ).on( 'focus',function(){
	var target = jQuery( this ).attr( 'id' );
	jQuery('label[for="'+target+'"]').addClass( 'move' );
});

jQuery( '.kt-contact-form-area input, .kt-contact-form-area textarea' ).on( 'blur',function(){
	var target = jQuery( this ).attr( 'id' );
	jQuery('label[for="'+target+'"]').removeClass( 'move' );
});

jQuery( document ).ready( function(){
	
	primaryHeader();
	homeSlider();
	headerFourstyle();
	testimonialSlider();
	highlightSlider();

	$( '.scroll-to' ).scrollTo();

	/**
	* Initializing scroll top js
	*/
	new scrollToTop({
		markup   : '<a href="#page" class="scroll-to '+ ( BUSINESSGRAVITY.enable_scroll_top_in_mobile == 0 ? "hidden-xs" : "" )+'" id="go-top"><span class="kfi kfi-arrow-up"></span></a>',
		selector : '#go-top'
	}).init();

	wpMenuAccordion( '#offcanvas-menu' );
	
	$( document ).on( 'click', '.alt-menu-icon .offcanvas-menu-toggler, .close-offcanvas-menu a, .kt-offcanvas-overlay', function( e ){
		e.preventDefault();
		$( 'body' ).toggleClass( 'offcanvas-menu-open' );
	});
	jQuery( 'body' ).append( '<div class="kt-offcanvas-overlay"></div>' );

	/**
	* Make sure if the masonry wrapper exists
	*/
	if( jQuery( '.masonry-wrapper' ).length > 0 ){
		$grid = jQuery( '.masonry-wrapper' ).masonry({
			itemSelector: '.masonry-grid',
			percentPosition: true,
		});	
	}

	/**
	* Make support for Jetpack's infinite scroll on masonry layout
	*/
	infinite_count = 0;
    $( document.body ).on( 'post-load', function () {

		infinite_count = infinite_count + 1;
		var container = '#infinite-view-' + infinite_count;
		$( container ).hide();

		$( $( container + ' .masonry-grid' ) ).each( function(){
			$items = $( this );
		  	$grid.append( $items ).masonry( 'appended', $items );
		});

		setTimeout( function(){
			$grid.masonry('layout');
		},500);
    });

    /**
    * Modify default search placeholder
    */
    $( '#masthead #s' ).attr( 'placeholder', BUSINESSGRAVITY.search_placeholder );
    $( '#searchform #s' ).attr( 'placeholder', BUSINESSGRAVITY.search_default_placeholder );
});

jQuery( window ).load( function(){
	if( 'undefined' !== typeof $grid ){
		$grid.masonry('reloadItems');
		$grid.masonry('layout');
	}
});

jQuery( window ).load( function(){
	jQuery( '#site-loader' ).fadeOut( 500 );
});


jQuery( window ).resize(function(){
	headerFourstyle();
});

// Mobile Nav on focus out event
	jQuery( document ).ready( function() {
		body = jQuery( document.body );
		jQuery( window )
			.on( 'load.BUSINESSGRAVITY resize.BUSINESSGRAVITY', function() {
			if ( window.innerWidth < 1200 ) {
				jQuery('.offcanvas-menu-inner, close-offcanvas-menu a').on('focusout', function () {
					var $elem = jQuery(this);

					// let the browser set focus on the newly clicked elem before check
					setTimeout(function () {
						if ( ! $elem.find(':focus').length ) {
							jQuery( '.offcanvas-menu-toggler' ).trigger('click');
						}
					}, 0);
				});
			}
		} );
	});

})( jQuery );