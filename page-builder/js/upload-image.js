jQuery(function($){
	var file_frame;
 
    $('body').on('click', '.positive-panels-uploadimage', function(e){
    	e.preventDefault();
    	button = $(this);

        if ( file_frame ) {
        	file_frame.open();
        	return;
        }

        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
			button: {text: 'Choose Image'},
			multiple: false,
            library: {type: 'image'}
        });

        file_frame.on('select', function() {
            attachment = file_frame.state().get('selection').first().toJSON();
            $(button).prev().val(attachment['url']);
            $(button).next().val(attachment['id']);
            $('#thumbnail').html('<img src="'+ attachment['url'] +'">');
        });

        file_frame.open();
 
    });

});