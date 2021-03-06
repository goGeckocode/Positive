<?php
global $wp_widget_factory;
$layouts = apply_filters('siteorigin_panels_prebuilt_layouts', array());
?>

<div id="panels" data-animations="<?php echo siteorigin_panels_setting('animations') ? 'true' : 'false' ?>">

	<?php do_action('siteorigin_panels_before_interface') ?>

	<div id="panels-container">
	</div>
	
	<div id="add-to-panels">
		<span><?php _e('Layout', 'positive-panels') ?>:</span>
		<button class="section-add" data-tooltip="<?php esc_attr_e('Add New Section','positive-panels') ?>"><?php _e('Add New Section', 'positive-panels') ?></button>
		<button class="grid-add" data-tooltip="<?php esc_attr_e('Add Row','positive-panels') ?>"><?php _e('Add Row', 'positive-panels') ?></button>
		<span><?php _e('Elements', 'positive-panels') ?>:</span>
		<button class="panels-add" data-tooltip="<?php esc_attr_e('Add Widget','positive-panels') ?>"><?php _e('Add Widget', 'positive-panels') ?></button>
		<?php if(!empty($layouts)) : ?>
			<button class="prebuilt-set ui-button" data-tooltip="<?php esc_attr_e('Prebuilt Layouts','positive-panels') ?>"><?php _e('Prebuilt Layouts', 'positive-panels') ?></button>
		<?php endif; ?>
	</div>
	
	<?php // The add new widget dialog ?>
	<div id="panels-dialog" data-title="<?php esc_attr_e('Add New Widget','positive-panels') ?>" class="panels-admin-dialog">
		<div id="panels-dialog-inner">
			<div class="panels-text-filter">
				<input type="search" class="widefat" placeholder="Filter" id="panels-text-filter-input" />
			</div>

			<ul class="panel-type-list">

				<?php foreach($wp_widget_factory->widgets as $class => $widget_obj) : ?>
					<li class="panel-type"
						data-class="<?php echo esc_attr($class) ?>"
						data-title="<?php echo esc_attr($widget_obj->name) ?>"
						>
						<div class="panel-type-wrapper">
							<h3><?php echo esc_html($widget_obj->name) ?></h3>
							<?php if(!empty($widget_obj->widget_options['description'])) : ?>
								<small class="description"><?php echo esc_html($widget_obj->widget_options['description']) ?></small>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>

				<div class="clear"></div>
			</ul>
		</div>
		
	</div>

	<?php // The add section dialog ?>
	<div id="section-add-dialog" data-title="<?php esc_attr_e('New Section','positive-panels') ?>" class="panels-admin-dialog">
		<p><label><strong><?php _e('Section Style', 'positive-panels') ?></strong></label></p>
		<select name="section-style-class" id="section-style-class">
			<option value="white-box" <?php selected(true) ?>><?php _e( 'White', 'positive-panels' ) ?></option>
			<option value="gray-box"><?php _e( 'Gray', 'positive-panels' ) ?></option>
			<option value="orange-box"><?php _e( 'Orange', 'positive-panels' ) ?></option>
			<option value="blue-box"><?php _e( 'Blue', 'positive-panels' ) ?></option>
		</select>
		<?php // Añadir imagen de backgroud ?>
	</div>

	<?php // The change section style dialog ?>
	<div id="section-change-dialog" data-title="<?php esc_attr_e('Edit Section Style','positive-panels') ?>" class="panels-admin-dialog">
		<?php // we clone the content of #section-add-dialog by js ?>
	</div>

	<?php // The add row dialog ?>
	<div id="grid-add-dialog" data-title="<?php esc_attr_e('Add Row','positive-panels') ?>" class="panels-admin-dialog">
		<p><label><strong><?php _e('Columns', 'positive-panels') ?></strong></label></p>
		<p><label><input type="radio" name="column_count" value="1x"> <img src="<?php echo get_template_directory_uri() ?>/page-builder/css/images/columns-1col.png" alt="<?php _e('1 column','positive-panels') ?>"></label></p>
		<p><label><input type="radio" name="column_count" value="1x2x"> <img src="<?php echo get_template_directory_uri() ?>/page-builder/css/images/columns-1x2x.png" alt="<?php _e('2 columns (thin + wide)','positive-panels') ?>"></label></p>
		<p><label><input type="radio" name="column_count" value="2x"> <img src="<?php echo get_template_directory_uri() ?>/page-builder/css/images/columns-2col.png" alt="<?php _e('2 columns','positive-panels') ?>"></label></p>
		<p><label><input type="radio" name="column_count" value="2x1x"> <img src="<?php echo get_template_directory_uri() ?>/page-builder/css/images/columns-2x1x.png" alt="<?php _e('2 columns (wide + thin)','positive-panels') ?>"></label></p>
		<p><label><input type="radio" name="column_count" value="3x"> <img src="<?php echo get_template_directory_uri() ?>/page-builder/css/images/columns-3col.png" alt="<?php _e('3 columns','positive-panels') ?>"></label></p>
	</div>

	<?php // The edit row dialog ?>
	<div id="grid-edit-dialog" data-title="<?php esc_attr_e('Columns number','positive-panels') ?>" class="panels-admin-dialog">
		<?php // we clone the content of #grid-add-dialog by js ?>
	</div>

	<?php // The layouts dialog ?>
	<?php if(!empty($layouts)) : ?>
		<div id="grid-prebuilt-dialog" data-title="<?php esc_attr_e('Insert Prebuilt Page Layout','positive-panels') ?>" class="panels-admin-dialog">
			<p><label><strong><?php _e('Page Layout', 'positive-panels') ?></strong></label></p>
			<p>
				<select type="text" id="grid-prebuilt-input" name="prebuilt_layout" style="width:580px;" placeholder="<?php esc_attr_e('Select Layout', 'positive-panels') ?>" >
					<option class="empty" <?php selected(true) ?> value=""></option>
					<?php foreach($layouts as $id => $data) : ?>
						<option id="panel-prebuilt-<?php echo esc_attr($id) ?>" data-layout-id="<?php echo esc_attr($id) ?>" class="prebuilt-layout">
							<?php echo isset($data['name']) ? $data['name'] : __('Untitled Layout', 'positive-panels') ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
		</div>
	<?php endif; ?>

	<?php wp_nonce_field('save', '_sopanels_nonce') ?>
	<?php do_action('siteorigin_panels_metabox_end'); ?>
</div>