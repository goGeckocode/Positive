(function ($) {
    $.each(['slideDown'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
        	this.trigger(ev);
        	return el.apply(this, arguments);
        };
    });
})(jQuery);


jQuery(document).ready(function($){
    $('body').on('slideDown','.widget-inside', function(){
        $(this).setupforms();
    })
})