/*
 * Toggle functions on click event
 * Source: https://github.com/fkling/jQuery-Function-Toggle-Plugin
 */
(function($) {
    $.fn.clickToggle = function(func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function() {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));

/*
 * POSITIVE MAIN JS
 */
$(document).ready(function(){
	/*------- Dropdown menu ------- */
	$('#menu-main > ul > li').mouseenter(function(){
		$(this).children('.sub-menu').stop(true,true).show()
			.animate({opacity:1, 'margin-left':'-168px'},400,'swing');
	}).mouseleave(function(){
		$(this).children('.sub-menu').stop(true,true)
			.animate({opacity:0, 'margin-left':'-188px'},400,'swing',
				function(){ $(this).hide().css('margin-left','-148px') }
			);
	})

	/*------- Dropdown languages ------- */
	$('.languages').mouseenter(function(){
		$(this).children('ul').stop(true,true).show()
			.animate({opacity:1, 'margin-top':0},500);
	}).mouseleave(function(){
		$(this).children('ul').stop(true,true)
			.animate({opacity:0, 'margin-top':'-10px'},500, 
				function(){ $(this).hide() }
			);
	})

	// jqtransform
	$(".ninja-forms-form .list-dropdown-wrap").jqTransform();

	/*------- Widget News-Actividades ------- */
	$('.positive-panels-listposts ul li h2 a').click(function(){
		if(!$(this).is('.select-item')){
	    	$('.positive-panels-listposts ul li h2 a').removeClass('select-item');
	    	$(this).addClass('select-item');
	    	href = $(this).attr('href');
	    	$('.list-posts').not(href).hide(0,function(){
	    		$(href).fadeIn(500);
	    	});
	    }
	    return false;
	})

	/*------- Widget MEMBER  ------- */
	heightMember = $('.list-sect > li.active .members').outerHeight();
	$('.list-sect').css('padding-bottom',heightMember+'px');
	$('.list-sect > li:first-child .members').css({'opacity':1,'margin-left':0 });
	$('.list-sect > li > a').click(function(){
		element = $(this).next;
		heightMember = element.outerHeight();
		$('.list-sect > li.active .members').animate({opacity:0, 'margin-left':'-150px'},400,'swing');
		$('.list-sect > li').removeClass('active');
		$(this).parent().addClass('active');
		$('.list-sect').animate({'padding-bottom':(heightMember)+'px'},500,function(){		
			element.animate({opacity:1, 'margin-left':0},600,'swing',
				function(){ $('.list-sect > li:not(.active) .members').css('margin-left','150px')}
			);
		});
		return false;
	})

	/*------- Widget Post Type Sectores ------- */
	cacheMargin = $('.positive-panels-post-type li').eq(0).css('margin-bottom'); // guardamos el valor de margin-bottom inicial
	$('.positive-panels-post-type .pt-content').append(
		$('<span class="close"></span>').click(function(){
			container = $(this).closest('li');
			container.children('.pt-content').fadeOut(1000, function(){
				$('.positive-panels-post-type li').removeClass('inactive');
				container.animate({'margin-bottom':cacheMargin}).removeClass('active');
			})
		})
	);
	$('.positive-panels-post-type a.show-info').click(function(){
		current_li = $(this).parent();
		if(!current_li.hasClass('active')){
			last_active = $('.positive-panels-post-type li.active');
			last_active.children('.pt-content').fadeOut();

			content = $(this).next('.pt-content');
			contentHeight = content.outerHeight();
			current_li.animate({'margin-bottom':(contentHeight+60)+'px'},1000,function(){
				last_active.animate({'margin-bottom':cacheMargin}).removeClass('active');
			});
			content.delay(500).fadeIn(1000);

			current_li.removeClass('inactive').addClass('active');
			$('.positive-panels-post-type > ul > li').not(current_li).addClass('inactive');
			
		}
		return false;
	})
	
	// REMOVE SPECIAL PADDING FROM ".span-6 .black-studio-tinymce" FOR "positive-css-columns"
	$('.span-6 .black-studio-tinymce .positive-css-columns').closest('.black-studio-tinymce').css('padding','0 8%');
	
	// Eliminar las <p> vacias o con "&nbsp;" del wysig
	$('.black-studio-tinymce p').each(function() {
	    var $this = $(this);
	    if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
	        $this.remove();
	});

	// PLACEHOLDER SUPPORT
	/*if(!Modernizr.input.placeholder){
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
		}).blur(function(){
			var input = $(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
		}).blur();
		$('[placeholder]').closest('form').submit(function() {
			$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
				}
			})
		});
	}*/

	// DIALOG JQUERY UI PARA INTERNACIONALIZACION
	$('.page-template-page-internacionalizacion-php .section .span-2 .black-studio-tinymce h3').click(function(){
		//if ($(this).next().is('.ninja_forms_widget')){
		//	$(this).next('.ninja_forms_widget').modal();
		if ($(this).closest('.column.span-2').find('.ninja_forms_widget').is('.ninja_forms_widget')){
			$(this).closest('.column.span-2').find('.ninja_forms_widget').modal();
		}
		return false;
	})

})