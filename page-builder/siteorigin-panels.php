<?php
/*
Page Builder by GeckoCode
Description: A drag and drop page builder that simplifies building your website. Inpired in Page Builder by Site Origin (http://siteorigin.com/page-builder/)
Version: 1.0
Author: GeckoCode
Author URI: http://geckocode.es
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/

define('POSITIVE_PANELS_VERSION', '1.0');
define('POSITIVE_PANELS_DEV',true);

include 'widgets/basic.php';

include 'inc/options.php';
include 'inc/revisions.php';
include 'inc/copy.php';
if( defined('POSITIVE_PANELS_DEV') && POSITIVE_PANELS_DEV ) include 'inc/debug.php';

/**
 * Initialize the Page Builder.
 */
function siteorigin_panels_init(){
	$display_settings = get_option('siteorigin_panels_display', array());
	if( isset($display_settings['bundled-widgets'] ) && !$display_settings['bundled-widgets'] ) return;

	include 'widgets/widgets.php';
}
add_action('plugins_loaded', 'siteorigin_panels_init');

/**
 * Initialize the language files
 */
function siteorigin_panels_init_lang(){
	load_textdomain('siteorigin-panels', 'lang/so-panels.mo');
}
add_action('admin_init', 'siteorigin_panels_init_lang');

/**
 * Callback to register the Panels Metaboxes
 */
function siteorigin_panels_metaboxes() {
	foreach( siteorigin_panels_setting( 'post-types' ) as $type ){
		add_meta_box( 'so-panels-panels', __( 'Page Builder', 'siteorigin-panels' ), 'siteorigin_panels_metabox_render', $type, 'advanced', 'high' );
	}
}
add_action( 'add_meta_boxes', 'siteorigin_panels_metaboxes' );

/**
 * Check if we're currently viewing a panel.
 *
 * @param bool $can_edit Also check if the user can edit this page
 * @return bool
 */
function siteorigin_panels_is_panel($can_edit = false){
	// Check if this is a panel
	$is_panel = ( is_singular() && get_post_meta(get_the_ID(), 'panels_data', false) != '' );
	return $is_panel && (!$can_edit || ( (is_singular() && current_user_can('edit_post', get_the_ID())) || ( siteorigin_panels_is_home() && current_user_can('edit_theme_options') ) ));
}

/**
 * Render a panel metabox.
 *
 * @param $post
 */
function siteorigin_panels_metabox_render( $post ) {
	include 'tpl/metabox-panels.php';
}


/**
 * Enqueue the panels admin scripts
 *
 * @action admin_print_scripts-post-new.php
 * @action admin_print_scripts-post.php
 * @action admin_print_scripts-appearance_page_so_panels_home_page
 */
function siteorigin_panels_admin_enqueue_scripts($prefix) {
	$screen = get_current_screen();

	if ( $screen->base == 'post' && in_array( $screen->id, siteorigin_panels_setting('post-types') ) ) {
		wp_enqueue_script( 'jquery-ui-resizable' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-button' );

		wp_enqueue_script( 'so-undomanager', get_template_directory_uri().'/page-builder/js/undomanager.min.js', array( ), POSITIVE_PANELS_VERSION);
		wp_enqueue_script( 'so-panels-chosen', get_template_directory_uri().'/page-builder/js/chosen/chosen.jquery.min.min.js', array( 'jquery' ), POSITIVE_PANELS_VERSION);

		wp_enqueue_script( 'so-panels-admin', get_template_directory_uri().'/page-builder/js/panels.admin.js', array( 'jquery' ), POSITIVE_PANELS_VERSION);
		wp_enqueue_script( 'so-panels-admin-panels', get_template_directory_uri().'/page-builder/js/panels.admin.panels.js', array( 'jquery' ), POSITIVE_PANELS_VERSION);
		wp_enqueue_script( 'so-panels-admin-grid', get_template_directory_uri().'/page-builder/js/panels.admin.grid.js', array( 'jquery' ), POSITIVE_PANELS_VERSION);
		wp_enqueue_script( 'so-panels-admin-prebuilt', get_template_directory_uri().'/page-builder/js/panels.admin.prebuilt.min.js', array( 'jquery' ), POSITIVE_PANELS_VERSION);
		wp_enqueue_script( 'so-panels-admin-tooltip', get_template_directory_uri().'/page-builder/js/panels.admin.tooltip.min.js', array( 'jquery' ), POSITIVE_PANELS_VERSION);
		wp_enqueue_script( 'so-panels-admin-media', get_template_directory_uri().'/page-builder/js/upload-image.js', array( 'jquery' ), POSITIVE_PANELS_VERSION);
		wp_enqueue_script( 'so-panels-admin-media', get_template_directory_uri().'/page-builder/js/panels.admin.media.min.js', array( 'jquery' ), POSITIVE_PANELS_VERSION);

		wp_localize_script( 'so-panels-admin', 'panels', array(
			'previewUrl' => wp_nonce_url(add_query_arg('siteorigin_panels_preview', 'true', get_home_url()), 'siteorigin-panels-preview'),
			'i10n' => array(
				'buttons' => array(
					'insert' => __( 'Insert', 'siteorigin-panels' ),
					'cancel' => __( 'cancel', 'siteorigin-panels' ),
					'delete' => __( 'Delete', 'siteorigin-panels' ),
					'duplicate' => __( 'Duplicate', 'siteorigin-panels' ),
					'edit' => __( 'Edit', 'siteorigin-panels' ),
					'done' => __( 'Done', 'siteorigin-panels' ),
					'undo' => __( 'Undo', 'siteorigin-panels' ),
					'add' => __( 'Add', 'siteorigin-panels' ),
				),
				'messages' => array(
					'deleteColumns' => __( 'Columns deleted', 'siteorigin-panels' ),
					'editColumns' => __( 'Columns edited', 'siteorigin-panels' ),
					'deleteWidget' => __( 'Widget deleted', 'siteorigin-panels' ),
					'confirmLayout' => __( 'Are you sure you want to load this layout? It will overwrite your current page.', 'siteorigin-panels' ),
					'editWidget' => __('Edit %s Widget', 'siteorigin-panels')
				),
			),
		) );

		$panels_data = siteorigin_panels_get_current_admin_panels_data();

		// Remove any widgets with classes thast don't exist
		if ( !empty( $panels_data['panels'] ) ) {
			foreach ( $panels_data['panels'] as $i => $panel ) {
				if ( !class_exists( $panel['info']['class'] ) ) unset( $panels_data['panels'][$i] );
			}
		}

		// Add in the forms
		if( !empty( $panels_data['widgets'] ) ) {
			wp_localize_script( 'so-panels-admin', 'panelsData', $panels_data );
		}

		// Render all the widget forms. A lot of widgets use this as a chance to enqueue their scripts
		$original_post = isset($GLOBALS['post']) ? $GLOBALS['post'] : null; // Make sure widgets don't change the global post.
		foreach($GLOBALS['wp_widget_factory']->widgets as $class => $widget_obj){
			ob_start();
			$widget_obj->form( array() );
			ob_clean();
		}
		$GLOBALS['post'] = $original_post;

		// This gives panels a chance to enqueue scripts too, without having to check the screen ID.
		do_action( 'siteorigin_panel_enqueue_admin_scripts' );
	}
}
add_action( 'admin_print_scripts-post-new.php', 'siteorigin_panels_admin_enqueue_scripts' );
add_action( 'admin_print_scripts-post.php', 'siteorigin_panels_admin_enqueue_scripts' );
add_action( 'admin_print_scripts-appearance_page_so_panels_home_page', 'siteorigin_panels_admin_enqueue_scripts' );


/**
 * Enqueue the admin panel styles
 *
 * @action admin_print_styles-post-new.php
 * @action admin_print_styles-post.php
 */
function siteorigin_panels_admin_enqueue_styles() {
	$screen = get_current_screen();
	if ( in_array( $screen->id, siteorigin_panels_setting('post-types') ) || $screen->base == 'appearance_page_so_panels_home_page') {
		wp_enqueue_style( 'so-panels-admin', get_template_directory_uri().'/page-builder/css/admin.css' );
		wp_enqueue_style( 'so-panels-chosen', get_template_directory_uri().'/page-builder/js/chosen/chosen.css' );
		do_action( 'siteorigin_panel_enqueue_admin_styles' );
	}
}
add_action( 'admin_print_styles-post-new.php', 'siteorigin_panels_admin_enqueue_styles' );
add_action( 'admin_print_styles-post.php', 'siteorigin_panels_admin_enqueue_styles' );
add_action( 'admin_print_styles-appearance_page_so_panels_home_page', 'siteorigin_panels_admin_enqueue_styles' );

/**
 * Add a help tab to pages with panels.
 */
function siteorigin_panels_add_help_tab($prefix) {
	$screen = get_current_screen();
	if(
		( $screen->base == 'post' && ( in_array( $screen->id, siteorigin_panels_setting( 'post-types' ) ) || $screen->id == '') )
		|| ($screen->id == 'appearance_page_so_panels_home_page')
	) {
		$screen->add_help_tab( array(
			'id' => 'panels-help-tab', //unique id for the tab
			'title' => __( 'Page Builder', 'siteorigin-panels' ), //unique visible title for the tab
			'callback' => 'siteorigin_panels_add_help_tab_content'
		) );
	}
}
add_action('load-page.php', 'siteorigin_panels_add_help_tab');
add_action('load-post-new.php', 'siteorigin_panels_add_help_tab');
add_action('load-appearance_page_so_panels_home_page', 'siteorigin_panels_add_help_tab');

/**
 * Display the content for the help tab.
 */
function siteorigin_panels_add_help_tab_content(){
	include 'tpl/help.php';
}

/**
 * Save the panels data
 *
 * @param $post_id
 * @param $post
 *
 * @action save_post
 */
function siteorigin_panels_save_post( $post_id, $post ) {
	if ( empty( $_POST['_sopanels_nonce'] ) || !wp_verify_nonce( $_POST['_sopanels_nonce'], 'save' ) ) return;
	if ( empty($_POST['panels_js_complete']) ) return;
	if ( !current_user_can( 'edit_post', $post_id ) ) return;

	$panels_data = siteorigin_panels_get_panels_data_from_post( $_POST );
	if( function_exists('wp_slash') ) $panels_data = wp_slash($panels_data);
	update_post_meta( $post_id, 'panels_data', $panels_data );
}
add_action( 'save_post', 'siteorigin_panels_save_post', 10, 2 );

/**
 * Get the Page Builder data for the current admin page.
 *
 * @return array
 */
function siteorigin_panels_get_current_admin_panels_data(){
	$screen = get_current_screen();

	global $post;
	$panels_data = get_post_meta( $post->ID, 'panels_data', true );
	$panels_data = apply_filters( 'siteorigin_panels_data', $panels_data, $post->ID );

	if ( empty( $panels_data ) ) $panels_data = array();

	return $panels_data;
}

/**
 * Echo the CSS for the current panel
 *
 * @action init
 */
function siteorigin_panels_css() {
	if(!isset($_GET['post']) || !isset($_GET['ver'])) return;

	else $panels_data = get_post_meta( $_GET['post'], 'panels_data', true );
	$post_id = $_GET['post'];

	header("Content-type: text/css");
	echo siteorigin_panels_generate_css($_GET['post'], $panels_data);
	exit();
}
add_action( 'wp_ajax_siteorigin_panels_post_css', 'siteorigin_panels_css' );
add_action( 'wp_ajax_nopriv_siteorigin_panels_post_css', 'siteorigin_panels_css' );


/**
 * Prepare the panels data early so widgets can enqueue their scripts and styles for the header.
 */
function siteorigin_panels_prepare_single_post_content(){
	if( is_singular() ) {
		global $siteorigin_panels_cache;
		if( empty($siteorigin_panels_cache[ get_the_ID() ] ) ) {
			$siteorigin_panels_cache[ get_the_ID() ] = siteorigin_panels_render( get_the_ID() );
		}
	}
}
add_action('wp_enqueue_scripts', 'siteorigin_panels_prepare_single_post_content');

/**
 * Filter the content of the panel, adding all the widgets.
 *
 * @param $content
 * @return string
 *
 * @filter the_content
 */
function siteorigin_panels_filter_content( $content ) {
	global $post;

	if ( empty( $post ) ) return $content;
	if ( in_array( $post->post_type, siteorigin_panels_setting('post-types') ) ) {
		$panel_content = siteorigin_panels_render( $post->ID );

		if ( !empty( $panel_content ) ) $content = $panel_content;
	}

	return $content;
}
add_filter( 'the_content', 'siteorigin_panels_filter_content' );

/**
 * Render the panels (frontend)
 *
 * @param int|string|bool $post_id The Post ID or 'home'.
 * @param array|bool $panels_data Existing panels data. By default load from settings or post meta.
 * @return string
 */
function siteorigin_panels_render( $post_id = false, $panels_data = false ) {

	if( empty($post_id) ) $post_id = get_the_ID();

	global $siteorigin_panels_current_post;
	$old_current_post = $siteorigin_panels_current_post;
	$siteorigin_panels_current_post = $post_id;

	// Try get the cached panel from in memory cache.
	global $siteorigin_panels_cache;
	if(!empty($siteorigin_panels_cache) && !empty($siteorigin_panels_cache[$post_id]))
		return $siteorigin_panels_cache[$post_id];

	if(empty($panels_data)){
		if(post_password_required($post_id)) return false;
		$panels_data = get_post_meta($post_id, 'panels_data', true);
	}

	$panels_data = apply_filters( 'siteorigin_panels_data', $panels_data, $post_id );
	if( empty( $panels_data ) || empty( $panels_data['grids'] ) ) return '';

	// Create the skeleton of the page
	$layout = array();
	if( !empty( $panels_data['section'] ) && is_array( $panels_data['section'] ) ) {
		foreach ($panels_data['section'] as $si => $sect ) {
			$layout[intval($si)] = array();
		}
	}

	if( !empty( $panels_data['grids'] ) && is_array( $panels_data['grids'] ) ) {
		foreach ( $panels_data['grids'] as $grid ) {
			$layout[intval($grid['section'])][] = array();
		}
	}

	if( !empty( $panels_data['grid_cells'] ) && is_array( $panels_data['grid_cells'] ) ) {
		foreach ( $panels_data['grid_cells'] as $cell ) {
			$layout[intval($cell['section'])][intval($cell['grid'])][] = array(
				'weight' => $cell['weight'],
				'widgets' => array()
			);
		}
	}

	if( !empty($panels_data['widgets']) && is_array($panels_data['widgets']) ){
		foreach ( $panels_data['widgets'] as $widget ) {
			$layout[intval( $widget['info']['section'] )][intval( $widget['info']['grid'] )][intval( $widget['info']['cell'] )]['widgets'][] = $widget;
		}
	}

	ob_start();

	foreach ( $layout as $si => $section ) {
		echo '<div class="section '.$panels_data['section'][$si]['class'].' section-'.($si+1).'">';

		foreach ( $layout[$si] as $gi => $grid ) {
			echo '<div class="grid grid-'.($gi+1).'">';

			foreach ( $layout[$si][$gi] as $ci => $cell ) {
				echo '<div class="column '.$cell['weight'].' column-'.($ci+1).'">';

				foreach ( $layout[$si][$gi][$ci]['widgets'] as $pi => $widget ) {
					$data = $widget;
					unset( $data['info'] );

					siteorigin_panels_the_widget( 
						$widget['info']['class'], //clase del widget (tipo)
						$data,	// info instance
						$si,	// section
						$gi,	// gridd
						$ci,	// cell
						$pi,	// panel nb
						$pi == count( $widgets ) - 1, // true si es el ultimo
						$post_id 
					);
				}
				echo '</div>'; // close cell
			}

			echo '</div>'; // close grid
		} // end foreach grids
		echo '</div>'; // close section
	} // end foreach section

	$html = ob_get_clean();

	// Reset the current post
	$siteorigin_panels_current_post = $old_current_post;

	return apply_filters( 'siteorigin_panels_render', $html, $post_id, !empty($post) ? $post : null );
}

/**
 * Render the widget (frontend)
 *
 * @param string $widget The widget class name.
 * @param array $instance The widget instance
 * @param int $section The section number.
 * @param int $grid The grid number.
 * @param int $cell The cell number.
 * @param int $panel the panel number.
 * @param bool $is_last Is this the last widget in the cell.
 */
function siteorigin_panels_the_widget( $widget, $instance, $section, $grid, $cell, $panel, $is_last, $post_id = false ) {
	if ( !class_exists( $widget ) ) return;
	if( empty($post_id) ) $post_id = get_the_ID();

	$the_widget = new $widget;

	$classes = array( 'panel' );
	if ( !empty( $the_widget->id_base ) ) $classes[] = $the_widget->id_base;
	if ( $is_last ) $classes[] = 'panel-last';
	$classes[] = 'panel-'.($panel+1);

	$the_widget->widget( array(
		'before_widget' => '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	), $instance );
}

/**
 * Handles creating the preview.
 */
function siteorigin_panels_preview(){
	if(isset($_GET['siteorigin_panels_preview']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'siteorigin-panels-preview')){
		global $siteorigin_panels_is_preview;
		$siteorigin_panels_is_preview = true;
		exit();
	}
}
add_action('template_redirect', 'siteorigin_panels_preview');

/**
 * Is this a preview.
 *
 * @return bool
 */
function siteorigin_panels_is_preview(){
	global $siteorigin_panels_is_preview;
	return (bool) $siteorigin_panels_is_preview;
}

/**
 * Hide the admin bar for panels previews.
 *
 * @param $show
 * @return bool
 */
function siteorigin_panels_preview_adminbar($show){
	if(!$show) return false;
	return !(isset($_GET['siteorigin_panels_preview']) && wp_verify_nonce($_GET['_wpnonce'], 'siteorigin-panels-preview'));
}
add_filter('show_admin_bar', 'siteorigin_panels_preview_adminbar');

/**
 * This is a way to show previews of panels, especially for the home page.
 *
 * @param $val
 * @return array
 */
function siteorigin_panels_preview_load_data($val){
	if(isset($_GET['siteorigin_panels_preview'])){
		$val = siteorigin_panels_get_panels_data_from_post( $_POST );
	}

	return $val;
}

/**
 * Add all the necessary body classes.
 *
 * @param $classes
 * @return array
 */
function siteorigin_panels_body_class($classes){
	if(siteorigin_panels_is_panel()) $classes[] = 'siteorigin-panels';
	if(siteorigin_panels_is_home()) $classes[] = 'siteorigin-panels-home';

	if(isset($_GET['siteorigin_panels_preview']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'siteorigin-panels-preview')) {
		// This is a home page preview
		$classes[] = 'siteorigin-panels';
		$classes[] = 'siteorigin-panels-home';
	}

	return $classes;
}
add_filter('body_class', 'siteorigin_panels_body_class');

/**
 * Add current pages as cloneable pages
 *
 * @param $layouts
 * @return mixed
 */
function siteorigin_panels_cloned_page_layouts($layouts){
	$pages = get_posts( array(
		'post_type' => 'page',
		'post_status' => array('publish', 'draft'),
		'numberposts' => 200,
	) );

	foreach($pages as $page){
		$panels_data = get_post_meta( $page->ID, 'panels_data', true );
		$panels_data = apply_filters( 'siteorigin_panels_data', $panels_data, $page->ID );

		if(empty($panels_data)) continue;

		$name =  empty($page->post_title) ? __('Untitled', 'siteorigin-panels') : $page->post_title;
		if($page->post_status != 'publish') $name .= ' ( ' . __('Unpublished', 'siteorigin-panels') . ' )';

		if(current_user_can('edit_post', $page->ID)) {
			$layouts['post-'.$page->ID] = wp_parse_args(
				array(
					'name' => sprintf(__('Clone Page: %s', 'siteorigin-panels'), $name )
				),
				$panels_data
			);
		}
	}

	return $layouts;
}
add_filter('siteorigin_panels_prebuilt_layouts', 'siteorigin_panels_cloned_page_layouts', 20);

/**
 * Add a filter to import panels_data meta key. This fixes serialized PHP.
 */
function siteorigin_panels_wp_import_post_meta($post_meta){
	foreach($post_meta as $i => $meta) {
		if($meta['key'] == 'panels_data') {
			$value = $meta['value'];
			$value = preg_replace("/[\r\n]/", "<<<br>>>", $value);
			$value = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $value);
			$value = unserialize($value);
			$value = array_map('siteorigin_panels_wp_import_post_meta_map', $value);

			$post_meta[$i]['value'] = $value;
		}
	}

	return $post_meta;
}
add_filter('wp_import_post_meta', 'siteorigin_panels_wp_import_post_meta');

/**
 * A callback that replaces temporary break tag with actual line breaks.
 *
 * @param $val
 * @return array|mixed
 */
function siteorigin_panels_wp_import_post_meta_map($val) {
	if(is_string($val)) return str_replace('<<<br>>>', "\n", $val);
	else return array_map('siteorigin_panels_wp_import_post_meta_map', $val);
}

/**
 * Admin ajax handler for loading a prebuilt layout.
 */
function siteorigin_panels_ajax_action_prebuilt(){
	// Get any layouts that the current user could edit.
	$layouts = apply_filters('siteorigin_panels_prebuilt_layouts', array());

	if(empty($_GET['layout'])) exit();
	if(empty($layouts[$_GET['layout']])) exit();

	header('content-type: application/json');

	$layout = !empty($layouts[$_GET['layout']]) ? $layouts[$_GET['layout']] : array();
	$layout = apply_filters('siteorigin_panels_prebuilt_layout', $layout);

	echo json_encode($layout);
	exit();
}
add_action('wp_ajax_so_panels_prebuilt', 'siteorigin_panels_ajax_action_prebuilt');

/**
 * Display a widget form with the provided data
 */
function siteorigin_panels_ajax_widget_form(){
	$request = array_map('stripslashes_deep', $_REQUEST);
	if( empty( $request['widget'] ) ) exit();

	echo siteorigin_panels_render_form( $request['widget'], !empty($request['instance']) ? json_decode( $request['instance'], true ) : array(), $_REQUEST['raw'] );
	exit();
}
add_action('wp_ajax_so_panels_widget_form', 'siteorigin_panels_ajax_widget_form');

/**
 * Render a form with all the Page Builder specific fields
 *
 * @param string $widget The class of the widget
 * @param array $instance Widget values
 * @param bool $raw
 * @return mixed|string The form
 */
function siteorigin_panels_render_form($widget, $instance = array(), $raw = false){
	global $wp_widget_factory;
	if(empty($wp_widget_factory->widgets[$widget])) return '';

	$widget_obj = $wp_widget_factory->widgets[$widget];
	if ( !is_a($widget_obj, 'WP_Widget') )
		return;

	if( $raw && method_exists($widget_obj, 'update') ) $instance = $widget_obj->update($instance, $instance);

	$widget_obj->id = 'temp';
	$widget_obj->number = '{$id}';

	ob_start();
	$widget_obj->form($instance);
	$form = ob_get_clean();

	// Convert the widget field naming into ones that panels uses
	$exp = preg_quote( $widget_obj->get_field_name('____') );
	$exp = str_replace('____', '(.*?)', $exp);
	$form = preg_replace( '/'.$exp.'/', 'widgets[{$id}][$1]', $form );

	// Add all the information fields
	return $form;
}