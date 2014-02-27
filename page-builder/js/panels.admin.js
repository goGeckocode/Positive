/**
 * Initial setup for the panels interface
 *
 * @copyright Greg Priday 2013
 * @license GPL 2.0 http://www.gnu.org/licenses/gpl-2.0.html
 */

jQuery( function ( $ ) {
	// populate cloned forms
	$('#grid-edit-dialog').prepend( $('#grid-add-dialog').html() );
	$('#section-change-dialog').prepend( $('#section-add-dialog').html() );

	// Create a sortable for the SECTIONS
	$( '#panels-container' ).sortable({
		items:    '.section-container',
		handle:   '.section-handle',
		tolerance:'pointer',
		stop:     function () {
			position = $(this).index();
			$(this).find('input[name$="[section]"]').val(position);

			$('#panels-container .panels-container').trigger('refreshcells');
		}
	});

	var overlay = $('<div class="positive-panels ui-widget-overlay ui-front"></div>').css('z-index', 80001);

	// **************************
	// Add SECTION dialog
	// **************************
	var sectionAddDialogButtons = {};
	sectionAddDialogButtons[panels.i10n.buttons.add] = function () {
		var sectionClass = $('#section-add-dialog').find('select').val();
		var newsection = window.panels.createSection(sectionClass,true);

		newsection.show();
		$( '#section-add-dialog' ).dialog( 'close' );
	};
	// Create the dialog that we use to add a section
	$( '#section-add-dialog' )
		.show()
		.dialog( {
			dialogClass: 'panels-admin-dialog',
			autoOpen: false,
			modal: false, // Disable modal so we don't mess with media editor. We'll create our own overlay.
			title: $('#section-add-dialog').attr('data-title'),
			open: function () {
				$(this).data('overlay', overlay).closest('.ui-dialog').before(overlay);
			},
			close : function(){
				$(this).data('overlay').remove();
			},
			buttons: sectionAddDialogButtons
		})
		.on('keydown', function(e) {
			if (e.keyCode === $.ui.keyCode.ESCAPE) {
				$('#section-add-dialog').dialog('close');
			}
		});
	;

	// **************************
	// Change SECTION STYLE dialog
	// **************************
	$( '#section-change-dialog' )
		.show()
		.dialog( {
			dialogClass: 'panels-admin-dialog',
			autoOpen: false,
			modal: false, // Disable modal so we don't mess with media editor. We'll create our own overlay.
			title: $('#section-change-dialog').attr('data-title'),
			open: function () {
				if( $(this).attr('data-class') ){
					var sectionClass = $(this).attr('data-class');
					$(this).find('select').val(sectionClass);
				}
				$(this).data('overlay', overlay).closest('.ui-dialog').before(overlay);
			},
			close : function(){ 
				$(this).data('overlay').remove();
			},
			buttons: {
				'Edit': function(){
					newSectionClass = $('#section-change-dialog').find('select').val();

					if( $(this).attr('data-class') && $(this).attr('data-class') != newSectionClass ){
						// section TITLE to show in admin
						if('white-box'==newSectionClass) sectionTitle = 'White section';
						else if('gray-box'==newSectionClass) sectionTitle = 'Gray section';
						else sectionTitle = 'Color section';

						section = $(this).attr('data-section');
						section = $('.section-container').eq( Number(section) );

						// remove previous class
						var classes = section.attr('class').split(' ');
					    for (var i = 0; i < classes.length; i++) {
					        if (classes[i].indexOf("box") >= 0) {
					            section.removeClass(classes[i]);
					        }
					    }
						section.addClass(newSectionClass)
							.find('.controls p').text(sectionTitle);
						section.find('input[name$="[class]"]').not('[name*="[info]"]').val(newSectionClass);
					}

					$(this).dialog('close');
				}
			}
		})
		.on('keydown', function(e) {
			if (e.keyCode === $.ui.keyCode.ESCAPE) {
				$('#section-change-dialog').dialog('close');
			}
		});

	// **************************
	// Add GRID dialog
	// **************************
	var gridAddDialogButtons = {};
	gridAddDialogButtons[panels.i10n.buttons.add] = function () {
		var columns = $('#grid-add-dialog').find('input[name="column_count"]:checked').val();
		var gridContainer = window.panels.createGrid(null, columns);

		gridContainer.show();

		$( '#grid-add-dialog' ).dialog( 'close' );
	};

	// Create the dialog that we use to add new grids
	$( '#grid-add-dialog' )
		.show()
		.dialog( {
			dialogClass: 'panels-admin-dialog',
			autoOpen: false,
			modal: false, // Disable modal so we don't mess with media editor. We'll create our own overlay.
			title:   $( '#grid-add-dialog' ).attr( 'data-title' ),
			open:    function () {
				$(this).data('overlay', overlay).closest('.ui-dialog').before(overlay);
			},
			close : function(){
				$(this).data('overlay').remove();
			},
			buttons: gridAddDialogButtons
		})
		.on('keydown', function(e) {
			if (e.keyCode == $.ui.keyCode.ENTER) {
				// This is the same as clicking the add button
				gridAddDialogButtons[panels.i10n.buttons.add]();
				setTimeout(function(){$( '#grid-add-dialog' ).dialog( 'close' );}, 1)
			}
			else if (e.keyCode === $.ui.keyCode.ESCAPE) {
				$( '#grid-add-dialog' ).dialog( 'close' );
			}
		});

	// **************************
	// Edit GRID COLUMNS number dialog
	// **************************
	$('#grid-edit-dialog')
		.show()
		.dialog( {
			dialogClass: 'panels-admin-dialog',
			autoOpen: false,
			modal: false, // Disable modal so we don't mess with media editor. We'll create our own overlay.
			title: $('#grid-edit-dialog').attr('data-title'),
			open: function () {
				if( $(this).attr('data-columns') ){
					var columnsNb = $(this).attr('data-columns');
					$(this).find('input[value="'+columnsNb+'"]').attr('checked','checked');
				}
				$(this).data('overlay', overlay).closest('.ui-dialog').before(overlay);
			},
			close : function(){ 
				$(this).data('overlay').remove();
			},
			buttons: {
				'Edit': function(){
					newColumnsNb = $(this).find('input:checked').val();

					if( $(this).attr('data-columns') && $(this).attr('data-columns') != newColumnsNb ){
						sectionIndex = $(this).attr('data-section');
						grid = $(this).attr('data-grid');
						oldGrid = $('.section-container').eq(sectionIndex).find('.grid-container').eq(grid);

						var newWeights = panels.columnsWeights(newColumnsNb);

						// Create an array that represents this grid
						var oldContainerData = [];
						oldGrid.find('.cell').each(function(i, el){
							oldContainerData[i] = {
								'cellClass': $(this).find('input[name$="weight"]').val(),
								'widgets': []
							};
							$(this).find('.panel').each(function(j, el){
								oldContainerData[i]['widgets'][j] = {
									type : $(this ).attr('data-type'),
									data : $(this ).panelsGetPanelData()
								}
							})
						});

						// Register this with the undo manager
						/*window.panels.undoManager.register(
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
										window.panels.addPanel(panel, registeredGrid.find('.panels-container').eq(i));
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
							[section, oldContainerData, grid],
							'Columns number'
						);

						// Create the undo notification
						$('#panels-undo-message' ).remove();
						$('<div id="panels-undo-message" class="updated"><p>' + panels.i10n.messages.editColumns + ' - <a href="#" class="undo">' + panels.i10n.buttons.undo + '</a></p></div>' )
							.appendTo('body')
							.hide()
							.fadeIn()
							.find('a.undo')
							.click(function(){
								window.panels.undoManager.undo();
								$('#panels-undo-message' ).fadeOut(function(){ $( this ).remove() });
								return false;
							});*/

						newGrid = window.panels.createGrid(sectionIndex, newColumnsNb);
						// Now, start adding the widgets

						// loop por las celdas antiguas
						var realI = 0; // realI define el numero de celdas actuales
						// para emplazar los widgets de las celdas eliminadas
						// en la ultima celda actual.
						for(var i = 0; i < oldContainerData.length; i++){
							for(var j = 0; j < oldContainerData[i]['widgets'].length; j++){
								// Readd the panel
								var theWidget = oldContainerData[i]['widgets'][j];
								var panel = $('#panels-dialog').panelsCreatePanel(theWidget.type, theWidget.data);
								window.panels.addPanel(panel, newGrid.find('.panels-container').eq(realI));
							}
							if(realI< (newWeights.length-1) ) realI++;
						}

						newGrid.insertBefore(oldGrid);
						oldGrid.remove();
						$('#panels-container').find('.grid-container').each(function(){
							gridIndex = $(this).index();
							$(this).find('input[name$="[grid]"]').val(gridIndex);
						});

						$('#panels-container .panels-container').trigger('refreshcells');
					}

					$('#grid-edit-dialog').dialog('close');
				}
			}
		})
		.on('keydown', function(e) {
			if (e.keyCode === $.ui.keyCode.ESCAPE) {
				$('#grid-edit-dialog').dialog('close');
			}
		});

	// **************************
	// WIDGETS LIST dialog
	// **************************
	$( '#panels-dialog').show()
		.dialog( {
			dialogClass: 'panels-admin-dialog',
			autoOpen:    false,
			resizable:   false,
			draggable:   false,
			modal:       false,
			title:       $( '#panels-dialog' ).attr( 'data-title' ),
			minWidth:    960,
			maxHeight:   Math.round($(window).height() * 0.8),
			open :       function () {
				$(this).data('overlay', overlay).closest('.ui-dialog').before(overlay);
			},
			close:       function () {
				$(this).data('overlay').remove();
				$( '#panels-container .panel.new-panel' ).show().removeClass( 'new-panel' );
			}
		} )
		.on('keydown', function(e) {
			if (e.keyCode === $.ui.keyCode.ESCAPE) {
				$(this ).dialog('close');
			}
		});

	// The button for adding a panel
	$( '#panels .panels-add')
		.button( {
			icons: {primary: 'ui-icon-add'},
			text:  false
		} )
		.click( function () {
			$('#panels-text-filter-input' ).val('').keyup();
			$( '#panels-dialog' ).dialog( 'open' );
			return false;
		} );

	// The button for adding a grid
	$( '#panels .grid-add' )
		.button( {
			icons: { primary: 'ui-icon-columns' },
			text:  false
		} )
		.click( function () {
			$( '#grid-add-dialog' ).dialog( 'open' );
			return false;
		} );

	// The button adding a section
	$('#panels .section-add')
		.button( {
			icons: {primary:'ui-icon-section'},
			text:  false
		})
		.click( function () {
			$('#section-add-dialog').dialog('open');
			return false;
		});

	// Handle filtering in the panels dialog
	$( '#panels-text-filter-input' )
		.keyup( function (e) {
			if( e.keyCode == 13 ) {
				// If we pressed enter and there's only one widget, click it
				var p = $( '#panels-dialog .panel-type-list .panel-type:visible' );
				if( p.length == 1 ) p.click();
				return;
			}

			var value = $( this ).val().toLowerCase();

			// Filter the panels
			$( '#panels-dialog .panel-type-list .panel-type' )
				.show()
				.each( function () {
					if ( value == '' ) return;

					if ( $( this ).find( 'h3' ).html().toLowerCase().indexOf( value ) == -1 ) {
						$( this ).hide();
					}
				} )
		} )
		.click( function () {
			$( this ).keyup()
		} );

	// Handle adding a new panel
	$('#panels-dialog .panel-type').click(function(){
		var panel = $('#panels-dialog').panelsCreatePanel( $(this).attr('data-class') );
		panels.addPanel(panel, null, null, true);

		// Close the add panel dialog
		$( '#panels-dialog' ).dialog( 'close' );
	} );

	

	// Either load layout from the panels data or setup an initial section
	if (typeof panelsData != 'undefined') panels.loadPanels(panelsData);
	else panels.createSection('white-box',true);

	$(window).resize(function(){
		// When the window is resized, we want to center any panels-admin-dialog dialogs
		$('.panels-admin-dialog').filter(':data(dialog)').dialog('option', 'position', 'center');
	} );

	// Handle switching between the page builder and other tabs
	$('#wp-content-editor-tools')
		.find('.wp-switch-editor')
		.click(function(){
			var $$ = $(this);

			$('#wp-content-editor-container, #post-status-info').show();
			$('#so-panels-panels').hide();
			$('#wp-content-wrap').removeClass('panels-active');

			$('#content-resize-handle' ).show();
		} ).end()
		.prepend(
			$('<a id="content-panels" class="hide-if-no-js wp-switch-editor switch-panels">' + $('#so-panels-panels h3.hndle span').html() + '</a>')
				.click(function(){
					var $$ = $(this);
					// This is so the inactive tabs don't show as active
					$('#wp-content-wrap').removeClass('tmce-active html-active');
					// Hide all the standard content editor stuff
					$('#wp-content-editor-container, #post-status-info, #wp-content-media-buttons').hide();
					// Show panels and the inside div
					$('#so-panels-panels').show().find('> .inside').show();
					$('#wp-content-wrap').addClass('panels-active');

					// Triggers full refresh
					$('#content-resize-handle').hide();

					return false;
				})
		);

	$('#wp-content-editor-tools .wp-switch-editor').click(function(){
		// This fixes an occasional tab switching glitch
		var $$ = $(this);
		var p = $$.attr('id' ).split('-');
		$( '#wp-content-wrap' ).addClass(p[1] + '-active');
		if(!$(this).is('#content-panels'))$('#wp-content-media-buttons').show();
	});

	// Move the panels box into a tab of the content editor
	$('#so-panels-panels')
		.insertAfter('#wp-content-editor-container')
		.addClass('wp-editor-container')
		.hide()
		.find('.handlediv').remove()
		.end()
		.find('.hndle').html('' ).append(
			$('#add-to-panels')
		);

	// If there's panel data already open the panels tab
	if(typeof panelsData != 'undefined') $('#content-panels').click();
	// Click again after the panels have been set up
	setTimeout(function(){
		if(typeof panelsData != 'undefined') $('#content-panels').click();
		$('#so-panels-panels .hndle').unbind('click');
		$('#so-panels-panels .cell').eq(0).click();
	}, 150);

	// Add a hidden field to show that the JS is complete. If this doesn't run we assume that JS is broken and the interface hasn't loaded properly
	$('#panels').append('<input name="panels_js_complete" type="hidden" value="1" />');
} );