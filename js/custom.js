$(document).ready(function(){
	$('#menu-main > ul > li').mouseenter(function(){
		$(this).find('.sub-menu').stop(true,true).fadeIn(400);
	}).mouseleave(function(){
		$(this).find('.sub-menu').stop(true,true).fadeOut(400);
	})
})