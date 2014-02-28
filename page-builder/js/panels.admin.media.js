jQuery(function($){

    // upload images with WordPress uploader
	var file_frame;
 
    $('body').on('click', '.positive-panels-uploadimage', function(e){
    	e.preventDefault();
    	image_fields = $(this).parent();

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
            $(image_fields).find('input.positive-image-src').val(attachment['url']);
            $(image_fields).find('input.positive-image-id').val(attachment['id']);
            $(image_fields).find('.thumbnail').html('<img src="'+ attachment['url'] +'">');
        });

        file_frame.open();
    });

    $('body').on('click', '.positive-clone-fields', function(e){
        group = $(this).parent(); // the 'repeater-fields' layer
        // almacenamos la base de los name & id de los input
        // para hacer facilmente el incremento
        groupName = group.attr('data-name');
        groupID = group.attr('data-id');
        
        newFields = group.find('.fields:last').clone().appendTo(group).hide().slideDown();
        fieldsIndex = newFields.index()-1;
        newFields.find(':input[name]').each(function(){
            key = '['+fieldsIndex+']['+ $(this).attr('data-key') +']';
            $(this).attr('id',groupID+key)
                .attr('name',groupName+key)
                .val('');
        })
        newFields.find('.thumbnail').html('');
    })
    $('body').on('click', '.positive-delete-fields', function(e){
        group = $(this).closest('.repeater-fields');
        groupName = group.attr('data-name');
        groupID = group.attr('data-id');

        $(this).parent().remove();

        // reindexamos todos los inputs
        group.find('.fields').each(function(i){
            $(this).find(':input[name]').each(function(){
                key = '['+i+']['+ $(this).attr('data-key') +']';
                $(this).attr('id',groupID+key)
                    .attr('name',groupName+key);
            })
        })
    })

});