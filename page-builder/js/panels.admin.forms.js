(function($){

	$.fn.setupforms = function() {
		return this.each(function(){
			var form = $(this);

			// **************************
			// Cloneable fields
			// **************************
			form.find('.cloneable-fields').each(function(){
				var container = $(this); // the '.cloneable-fields' layer
				// almacenamos la base de los name & id de los input
				// para hacer facilmente el incremento
				var groupName = container.attr('data-name'),
					groupID = container.attr('data-id'),
					fields = container.children();

				// delete button
				fields.each(function(){
					$(this).prepend( $('<div/>').addClass('reorder-handle') );
					$(this).append( $('<span>Delete fields group</span>').addClass('positive-delete-fields') );
				})

				// CLONING FIELDS
				container.append(
					$('<span>Add fields group</span>').addClass('positive-clone-fields').click(function(){
						newFields = fields.eq(0).clone().appendTo(container).hide().slideDown();
						newFields.find(':input[name]').each(function(){
							key = '['+ (newFields.index()-1) +']['+ $(this).attr('data-key') +']';
							$(this).attr('id',groupID+key)
								.attr('name',groupName+key)
								.val('');
						})
						newFields.find('.thumbnail').html('');
					})
				);

				function reindexfields(){
					container.find('.fields').each(function(i){
						$(this).find(':input[name]').each(function(){
							key = '['+i+']['+ $(this).attr('data-key') +']';
							$(this).attr('id',groupID+key)
								.attr('name',groupName+key);
						})
					})
				}

				// DELETING FIELDS
				container.on('click', '.positive-delete-fields', function(){
					$(this).parent().remove();
					// reindex all inputs IDs and Names
					reindexfields();
				})

				// Create a sortable for the SECTIONS
				container.sortable({
					items:'.fields',
					handle:'.reorder-handle',
					tolerance:'pointer',
					stop: reindexfields
				});


			}); // cloneable fields


			// **************************
			// Upload images with WP uploader
			// **************************
			var file_frame;
		 
			form.find('.positive-panels-uploadimage').click(function(e){
				e.preventDefault();
				image_fields = $(this).parent();

				if(file_frame){
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

		});
	};
}(jQuery));