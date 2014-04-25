(function($){

	$.fn.setupforms = function() {
		return this.each(function(){
			var form = $(this);

			// **************************
			// Upload images with WP uploader
			// **************************
			var file_frame;
		 	
		 	form.on('click', '.positive-panels-uploadimage', function(e){
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
					$(image_fields).find('input.positive-image-alt').val(attachment['title']);
					$(image_fields).find('input.positive-image-width').val(attachment['width']);
					$(image_fields).find('input.positive-image-height').val(attachment['height']);
					$(image_fields).find('.thumbnail').html('<img src="'+ attachment['url'] +'">');
					if(image_fields.closest('.fields').length) image_fields.closest('.fields').find('.toggle-collapse .thumbnail').html('<img src="'+ attachment['url'] +'">');
				});

				file_frame.open();
			});
			form.on('click','.positive-panels-removeimage', function(e){
				e.preventDefault();
				$(this).siblings('span.thumbnail').html('');
				$(this).siblings('input.positive-image-src').val('');
			})


			// **************************
			// Color Picker (farbtastic)
			// **************************
			function setupcolorpicker(){
				if(form.find('.color-selector').length){
					$('.color-selector').each(function(){
						$(this).farbtastic( $(this).prev('input') );
					}).hide();

					form.find('.color-fields input').focus(function(){
						if( $(this).val() == '') $(this).attr('value','#FFFFFF')
						$(this).next('.color-selector').fadeIn();
					}).blur(function(){
						if( $(this).val() == '') $(this).attr('style','');
						$(this).next('.color-selector').fadeOut();
					})
				}
			}
			setupcolorpicker();


			// **************************
			// Collapsible
			// **************************
			function setupcollapsible(){
				if(form.find('.collapsible').length){
					// reset, close all
					$('.collapsible').hide();
					form.find('.toggle-collapse.open').removeClass('open').children().slideDown();

					form.find('.toggle-collapse').click(function(){
						var handler = $(this),
							content = handler.next('.collapsible');

						if(! $(this).hasClass('open') ){
							content.slideDown(300);
							handler.children(100).slideUp(function(){
								handler.addClass('open');
							});

						} else {
							content.slideUp(300);
							handler.children().slideDown(function(){
								handler.removeClass('open');
							});
						}
						
					});
					// si hay un solo grupo de campos lo abrimos
					if(form.find('.fields').length == 1) $('.toggle-collapse').trigger('click');

					form.find('input[name$="[title]"]').blur(function(){
						value = $(this).val();
						if(value) $(this).closest('.fields').find('h4 strong').text(value);
					})
				}
			}
			setupcollapsible();


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
								.attr('style','')
								.val('');
						})
						newFields.find('.thumbnail').html('');
						setupcolorpicker();
						setupcollapsible();
						newFields.find('.toggle-collapse').trigger('click').find('strong').text('Slide '+newFields.index());

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


			});// cloneable


		});
	};
}(jQuery));