/**
 * Grid layout for the Panel interface
 *
 * @copyright Greg Priday 2013
 * @license GPL 2.0 http://www.gnu.org/licenses/gpl-2.0.html
 */

(function($){
	
	// The initial values
	var sectionId = 0;
	var gridId = 0;
	var cellId = 0;
	

	// translate columns class to array with cells classes
	panels.columnsWeights = function(columns){
		var weights=[];
		switch (columns){
			case '2x1x':
				weights=['span-4','span-2'];
				break;
			case '1x2x':
				weights=['span-2','span-4'];
				break;
			case '3x':
				weights=['span-2','span-2','span-2'];
				break;
			case '4x':
				weights=['span-1','span-1','span-1','span-1'];
				break;
			case '2x':
				weights=['span-3','span-3'];
				break;
			default:
				weights=['span-6'];
				break;
		}

		return weights;
	}

	/**
	 * Create a new SECTION
	 *
	 * @param class
	 * @param img ??
	 *
	 * @return {*}
	 */
	panels.createSection = function (sectionClass, addGrid) {
		// section TITLE to show in admin
		if('white-box'==sectionClass) sectionTitle = 'White section';
		else if('gray-box'==sectionClass) sectionTitle = 'Gray section';
		else if('blue-box'==sectionClass) sectionTitle = 'Blue section';
		else sectionTitle = 'Orange section';

		// Create a new SECTION container
		var container = $('<div class="section-container '+sectionClass+'" data-id="'+sectionId+'" />').appendTo('#panels-container');
		// Add the hidden field to store the grid order
		container.append( $( '<input type="hidden" name="section['+sectionId+'][class]" />' ).val( sectionClass ) );

		container.append( $( '<div class="controls" />' )
			.append('<p>'+sectionTitle+'</p>')
			// Add STYLING button
			.append( $('<div class="ui-button ui-button-icon-only"><div class="ui-icon ui-icon-prebuilt"></div></div>')
				.attr( 'data-tooltip', 'Change style' )
				.click( function () {
					section = $(this).closest('.section-container');
					$(this).removeTooltip();
					$('#section-change-dialog')
						.attr('data-class', section.children('input[name$="[class]"]').val() )
						.attr('data-section', section.index() )
						.dialog('open');
					return false;
				})
			)
			// Add REMOVE button
			.append($( '<div class="ui-button ui-button-icon-only"><div class="ui-icon ui-icon-remove"></div></div>' )
				.attr( 'data-tooltip', panels.i10n.buttons['delete'] )
				.click( function () {
					var section = $(this).closest('.section-container');
					$(this).removeTooltip();

					// Create an array that represents this section
					var sectionData = {
						'class' : section.children('input[name$="[class]"]').val(),
						'grids' : []
					};
					section.find('.grid').each(function(h, el){
						sectionData['grids'][h] = {
							'weights' : $(this).attr('data-weights'),
							'cells' : []
						};
						$(this).children('.cell').each(function(i, el){
							sectionData['grids'][h]['cells'][i] = {};
							$(this).find('.panel').each(function(j, el){
								sectionData['grids'][h]['cells'][i][j] = {
									'type' : $(this).attr('data-type'),
									'data' : $(this).panelsGetPanelData()
								}
							})
						});
					});

//console.log(sectionData);

					// Register this with the undo manager
					window.panels.undoManager.register(
						this,
						function(sectionData, position){
							// Readd the SECTION
							var registeredSection = window.panels.createSection(sectionData['class'], false);
							
							// create GRIDS
							for(var h = 0; h < sectionData.grids.length; h++){
								var registeredGrid = window.panels.createGrid(registeredSection.index(), sectionData.grids[h].weights );

								// Now, start adding the widgets
								// loop by cells
								for(var i = 0; i < sectionData.grids[h]['cells'].length; i++){
									object = sectionData.grids[h]['cells'][i];
									
								    var size = 0, key;
								    for (key in object) {
								        if (object.hasOwnProperty(key)) size++;
								    }

									// loop by widgets
									for(var w = 0; w < size; w++){
										// Readd the panel
										var theWidget = sectionData.grids[h]['cells'][i][w];
										var panel = $('#panels-dialog').panelsCreatePanel(theWidget.type, theWidget.data);
										window.panels.addPanel(panel, registeredGrid.find('.panels-container').eq(i), false);
									}
								}
							}

							// Finally, reposition the section
							if(position != registeredSection.index()){
								var current = $('#panels-container .section-container' ).eq(position);
								if(current.length){
									registeredSection.insertBefore(current);
									$('#panels-container').sortable( "refresh" )
									// reindex all
									$('#panels-container .section').trigger('refreshgrids');
								}
							}

							// We don't want to animate the new widgets
							$('#panels-container .panel').removeClass('new-panel');

							registeredSection.show();

						},
						[sectionData, section.index()],
						'Remove Section'
					);

					// Create the undo notification
					$('#panels-undo-message' ).remove();
					$('<div id="panels-undo-message" class="updated"><p>' + panels.i10n.messages.deleteSection + ' - <a href="#" class="undo">' + panels.i10n.buttons.undo + '</a></p></div>' )
						.appendTo('body')
						.hide()
						.fadeIn()
						.find('a.undo')
						.click(function(){
							window.panels.undoManager.undo();
							$('#panels-undo-message').fadeOut(function(){ $( this ).remove() });
							return false;
						})
					;

					// Finally, remove the section
					section.remove();
					// Refresh everything
					$('#panels-container').sortable("refresh");
					$('#panels-container').find('.section').trigger('refreshgrids');
					
					return false;
				} )

			)
			// Add REORDER button
			.append( $('<div class="ui-button ui-button-icon-only section-handle"><div class="ui-icon ui-icon-move"></div></div>')
			)
		);

		container.append('<div class="section" data-class="'+sectionClass+'" />');
		if(addGrid){
			window.panels.createGrid(sectionId,'1x');
		}

		// Setup the grid
		panels.setupSection(container);

		sectionId++;
		return container;
	}
	/**
	 * Setup a SECTION after its been created.
	 *
	 * @param $$
	 */
	panels.setupSection = function($$) {
		// Hide the undo message
		$('#panels-undo-message' ).fadeOut(function(){ $(this).remove() });

		// sortable grids
		$$.find('.section')
			.sortable({
				placeholder:"ui-state-highlight",
				items:'.grid-container',
				handle:'.grid-handle',
				connectWith:'.section',
				tolerance:  'pointer',
				receive: function () {
					$('.section').trigger('refreshgrids');
				}
			})
			.bind('refreshgrids', function(){
				// refrescamos el orden de cada modulo
				$('#panels-container .grid-container').each(function(){
					//console.log( $(this) );
					sectionIndex = $(this).closest('.section-container').index();
					gridIndex = $(this).index();

					$(this).find('input[name$="[section]"]').val(sectionIndex);
					$(this).find('input[name$="[grid]"]').val(gridIndex);
				});
				
			});

	}

	/**
	 * Create a new grid
	 *
	 * @param section (num)
	 * @param columns (ej: 2x, 3x, 2x1x, etc) 
	 * a partir de columns creamos
	 	* weights (array)
	 *
	 * @return {*}
	 */
	panels.createGrid = function(section, columns){
		var cells=0;
		var weights = panels.columnsWeights(columns);

		// Create a new grid container
		var gridContainer = $('<div class="grid-container" />');
		// si no se especifica section, se selecciona la ultima
		if(section == null){ section = $('#panels-container .section-container:last').index(); }
		// si aun no tiene valor es que no hay sections
		if(section == -1) {
			panels.createSection('white-box',false);
			section = 0;
		}
		$('#panels-container').find('.section').eq(section).append(gridContainer);

		// Add the hidden field to store the cells number
		gridContainer.append( $('<input type="hidden" name="grids[' + gridId + '][section]" />' ).val(section))
			.append( $('<input type="hidden" name="grids[' + gridId + '][columns]" />' ).val(columns) )
			.append( $('<div class="controls" />')
				// Add COLUMNS number button
				.append( $('<div class="ui-button ui-button-icon-only"><div class="ui-icon ui-icon-columns"></div></div>')
					.attr( 'data-tooltip', 'Change columns number' )
					.click( function () {
						var grid = $(this).closest('.grid-container');
						$(this).removeTooltip();
						$('#grid-edit-dialog')
							.attr('data-columns', grid.children('input[name$="[columns]"]').val())
							.attr('data-section',grid.children('input[name$="[section]"]').val())
							.attr('data-grid', grid.index() )
							.dialog('open');
						return false;
					})
				)
				// Add the remove button
				.append( $('<div class="ui-button ui-button-icon-only"><div class="ui-icon ui-icon-remove"></div></div>')
					.attr('data-tooltip', panels.i10n.buttons['delete'])
					.click(function(){
						$(this).removeTooltip();

						// Create an array that represents this grid
						var containerData = [];
						gridContainer.find('.cell').each(function(i, el){
							containerData[i] = {
								'cellClass': $(this).find('input[name$="weight"]').val(),
								'widgets': []
							};
							$(this).find('.panel').each(function(j, el){
								containerData[i]['widgets'][j] = {
									type : $(this ).attr('data-type'),
									data : $(this ).panelsGetPanelData()
								}
							})
						});

						// Register this with the undo manager
						window.panels.undoManager.register(
							this,
							function(section, containerData, position){
								// Readd the grid
								var columns = gridContainer.find('input[name$="[columns]"]').val();

								var registeredGrid = window.panels.createGrid(section, columns);

								// Now, start adding the widgets
								for(var i = 0; i < containerData.length; i++){
									for(var j = 0; j < containerData[i].widgets.length; j++){
										// Readd the panel
										var theWidget = containerData[i].widgets[j];
										var panel = $('#panels-dialog').panelsCreatePanel(theWidget.type, theWidget.data);
										window.panels.addPanel(panel, registeredGrid.find('.panels-container').eq(i), false);
									}
								}

								// Finally, reposition the gridContainer
								if(position != registeredGrid.index()){
									var current = $('#panels-container .grid-container').eq(position);
									if(current.length){
										registeredGrid.insertBefore(current);
										$('#panels-container').sortable("refresh");
										$('#panels-container').find('.grid-container').each(function(){
											gridIndex = $(this).index();
											$(this).find('input[name$="[grid]"]').val(gridIndex);
										});

										$('#panels-container .panels-container').trigger('refreshcells');
									}
								}

								// We don't want to animate the new widgets
								$('#panels-container .panel').removeClass('new-panel');

								registeredGrid.show();

							},
							[gridContainer.closest('.section-container').index(), containerData, gridContainer.index()],
							'Remove row'
						);

						// Create the undo notification
						$('#panels-undo-message').remove();
						$('<div id="panels-undo-message" class="updated"><p>' + panels.i10n.messages.deleteColumns + ' - <a href="#" class="undo">' + panels.i10n.buttons.undo + '</a></p></div>' )
							.appendTo('body')
							.hide()
							.fadeIn()
							.find('a.undo')
							.click(function(){
								window.panels.undoManager.undo();
								$('#panels-undo-message' ).fadeOut(function(){ $(this).remove() });
								return false;
							});

						// Finally, remove the grid container
						gridContainer.remove();
						// Refresh everything
						$('#panels-container')
							.sortable("refresh")
							.find('.panels-container').trigger('refreshcells');

						return false;
					})

				)
				// Add the move/reorder button
				.append( $( '<div class="ui-button ui-button-icon-only grid-handle"><div class="ui-icon ui-icon-move"></div></div>' ) )
			);

		var grid = $('<div class="grid" />').attr('data-weights',columns).appendTo(gridContainer);

		for(var i=0; i<weights.length; i++){
			var cell = $('<div class="cell '+ weights[i] +'">' +
					'<div class="cell-wrapper panels-container"></div>' +
				'</div>'
			);
			if (i == 0){
				$('#panels-container .cell').removeClass('cell-selected');
				cell.addClass('first cell-selected');
			}
			if (i == weights.length) cell.addClass('last');
			grid.append(cell);

			// Add the cell information fields
			cell.append( $('<input type="hidden" name="grid_cells['+ cellId +'][section]" />').val(section) )
				.append( $('<input type="hidden" name="grid_cells['+ cellId +'][grid]" />').val( gridContainer.index() ) )
				.append( $('<input type="hidden" name="grid_cells['+ cellId +'][weight]" />').val(weights[i]) )
				.data( 'cellId', cellId );

			cellId++;
		}
		grid.append('<div class="clear" />');

		// Setup the grid
		panels.setupGrid(gridContainer);

		gridId++;
		return gridContainer;
	}

	/**
	 * Setup a grid container after its been created.
	 *
	 * @param $$
	 */
	panels.setupGrid = function ($$) {
		// Hide the undo message
		$('#panels-undo-message' ).fadeOut(function(){ $(this).remove() });

		$$.find('.grid .cell')
			.click(function(){
				$('.grid .cell').removeClass('cell-selected');
				$(this).addClass('cell-selected');
			})
			.find('.panels-container')
			// This sortable handles the widgets inside the cell
			.sortable( {
				placeholder:"ui-state-highlight",
				connectWith:".panels-container",
				tolerance:  'pointer',
				change: function (ui) {
					$('#panels-container .ui-state-highlight').closest('.cell').get(0).click();
				},
				helper: function(e, el){
					return el.clone().css('opacity', 1).addClass('panel-being-dragged');
				},
				receive: function () {
					$( this ).trigger( 'refreshcells' );
				}
			} )
			.bind('refreshcells', function(){
				// Set the cell for each panel
                $( '#panels-container .panel' ).each( function () {
					$(this).find('input[name$="[info][section]"]').val( $(this).closest('.section-container').index() );
					$(this).find('input[name$="[info][grid]"]').val( $(this).closest('.grid-container').index() );
					$(this).find('input[name$="[info][cell]"]').val( $(this).closest('.cell').index() );
				})
			});
	}

	/**
	 * Clears all the grids
	 */
	panels.clearSections = function(){
		$('#panels-container .section-container').remove();
	}
	
})(jQuery);