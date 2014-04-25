var windowW = 0,
	was_mobile = false,	// variable to store if is_mobile was active or not
	mobile_size = 700;	// maximum size defined for mobile layout

function is_mobile(){
	mobile_check = ($(window).width() < mobile_size ? true : false);
	return mobile_check;
}
 
function positive_responsive(){
	// enter mobile mode
	if(!was_mobile && is_mobile() ){
		//console.log('Enter mobile mode');

		/*
		 * MAIN NAV
		 */
		mobile_nav = $('#mobile-nav');
		mobile_menu = mobile_nav.children('ul');
		// open / close menu
		mobile_nav.children('.toggle').click(function(){
			if(! $(this).hasClass('open')){
				mobile_menu.animate({left:0},500);
				$(this).addClass('open');
			} else {
				mobile_menu.animate({left:'100%'},500,'swing',function(){
					mobile_menu.children('.sub-menu').hide();
				});
				$(this).removeClass('open');
			}
			
		})
		// anime submenus
		mobile_menu.find('.menu-item-has-children > a').click(function(){
			$(this).next('ul').show();
			mobile_menu.animate({left:'-=100%'},500);
			return false;
		})
		if(!mobile_menu.find('li.go-back').length ){
			mobile_menu.find('.sub-menu').each(function(){
				current_submenu = $(this);
				$(this).prepend(
					$('<li class="submenu-title"></li>').text( $(this).prev('a').text())
				);
				$(this).prepend( 
					$('<li class="go-back">Atrás</li>').click(function(){
						mobile_menu.animate({left:'+=100%'},500, function(){
							current_submenu.hide();
						});
					})
				);
			})
		}

		was_mobile = true;

	// leave mobile mode
	} else if (was_mobile && !is_mobile() ) {
		//console.log('Leave mobile mode');

		/*
		 * RESET MOBILE STATES
		 */
		$('#mobile-nav').children('.toggle').removeClass('open');
		$('#mobile-nav').children('ul').css('left','100%').find('.sub-menu').hide();

		was_mobile = false;
	}
	
}



$(document).ready(function(){
	windowW = $(window).width();
	$(window).resize(positive_responsive);

	positive_responsive();
})



