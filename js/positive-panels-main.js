jQuery(function($){

/* 
 * Custom flexbox support test
 * Flexbox & Flexboxtweener (IE, new in Modernizr 3.0) Methods Merged
 * Return a class for browsers whithout support for any of them
 * Require Modernizr
 */
	if(!Modernizr.testAllProps('flexBasis','1px',true) && !Modernizr.testAllProps('flexAlign','end',true) ){
		$('html').addClass('no-flexbox-no-tweener');
		
		/* 
		 * Images
		 * Fixes background-image widget if there's no flexbox support
		 */
		$('.positive-panels-css-image').filter(':only-child').each(function() {
			$el = $(this);
			var newDiv = $("<div />", {
				"class": "innerWrapper",
				"css"  : {
					"height"  : $el.parent().height(),
					"width"   : "100%",
					"position": "relative"
				}
			});
			$el.wrap(newDiv);    
		})
	}


/* 
 * VIDEOS
 * Require plugin fitVids
 */
	if ($.fn.fitVids) {
		// delete video thumbnail and print video iframe with autoplay
		$('.positive-fitvids').fitVids();
		$('.positive-fitvids').find('iframe').remove();
		$('.positive-panels-video a').click(function(){
			iframe_src = $(this).attr('href');
			attr_link = (iframe_src.indexOf("?") == -1 ? '?' : '&');
			attr_link += (iframe_src.indexOf("youtu") == -1 ? '' : '&rel=0');
			$(this).parent().prepend('<iframe width="400" height="250" src="'+ iframe_src + attr_link +'autoplay=1" frameborder="0" allowfullscreen></iframe>');
			$(this).parent().children('.fluid-width-video-wrapper').remove();
			$(this).remove();
			$('.positive-fitvids').fitVids();
			return false;
		})
	}

/* 
 * CAROUSEL
 * Require plugin simplyScroll
 */
	if ($.fn.simplyScroll) {
		$(".carousel ul").simplyScroll({
			auto: false,
			speed: 5,
			frameRate:30
		});
	}



/*
 * RESIZE WINDOW
 */
/*function positive_resize(){
	// slider images size
	$('.cycle-slideshow').each(function(){
		// container aspect ratio
		refRatio = $(this).width()/$(this).height();

		$(this).find('img').each(function(){
			if (refRatio < ( $(this).width()/$(this).height() ) ) { 
				$(this).removeClass().addClass('portrait');
			} else {
				$(this).removeClass().addClass('landscape');
			}
		})
	})
}

// we also need this function to run on document ready
positive_resize(); 

// wait until resize is stopped, then call onResize function
var timer;
$(window).bind('resize', function(){
	timer && clearTimeout(timer);
	timer = setTimeout(positive_resize, 100);
});*/

  
});