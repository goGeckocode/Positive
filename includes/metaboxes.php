<?php
// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri().'/includes/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( TEMPLATEPATH . '/includes/meta-box' ) );
require_once RWMB_DIR . 'meta-box.php';

/* =============================================================================
	POSITIVE Posts meta boxes
	========================================================================== */

// Prefix of meta keys
$prefix = 'PS_';

global $meta_boxes;

$meta_boxes = array();

$meta_boxes[] = array(
	'id' => 'logo-sector',
	'title' => 'Logo del sector',
	'pages' => array( 'sectores' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		// IMAGE UPLOAD
		array(
			'name' => 'Imagen del Logo',
			'id'   => "{$prefix}sector_image",
			'type' => 'image_advanced',
			'max_file_uploads' => 1,
		),
		array(
			'name' => 'Una segunda version del logo(para la pagina de Miembros)',
			'id'   => "{$prefix}sector_image2",
			'type' => 'image_advanced',
			'max_file_uploads' => 1,
		),
		array(
			'name' => __( 'Descripción del sector', 'rwmb' ),
			'id'   => "{$prefix}sector_desc",
			'type' => 'textarea',
			'cols' => 10,
			'rows' => 2,
			'std'  => 'Fabricantes y comercializadores de maquinaria...'
		)
	)
);
$meta_boxes[] = array(
	'id' => 'logo-miembro',
	'title' => 'Logo del miembro',
	'pages' => array( 'miembros' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		// IMAGE UPLOAD
		array(
			'name' => 'Imagen del Logo',
			'id'   => "{$prefix}member_image",
			'type' => 'image_advanced',
			'max_file_uploads' => 1,
		),
	)
);
$meta_boxes[] = array(
	'id' => 'post-sectores',
	'title' => 'Sectores',
	'pages' => array( 'miembros' ),
	'context' => 'side',
	'priority' => 'low',
	'fields' => array(
		array(
			'name'    => 'Elige el sector de este miembro',
			'id'      => "{$prefix}sectores",
			'type'    => 'post',
			'post_type' => 'sectores',
			// Field type, either 'select' or 'select_advanced' (default)
			'field_type' => 'select_advanced',
			// Query arguments (optional). No settings means get all published posts
			'query_args' => array(
				'post_status' => 'publish',
				'posts_per_page' => '-1',
			)
		),
	)
);
$meta_boxes[] = array(
	'id' => 'post-event',
	'title' => __('Detalles del evento','positive-backend'),
	'pages' => array( 'actividades' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name'	=> 'Fechas',
			'id'	=> "{$prefix}event_dates",
			'type'	=> 'text',
			'desc'	=> __('Ejemplo: "del 23 al 28 de Feb. de 2014"','positive-backend')
		),
		array(
			'name' => 'Fecha inicio',
			'id'   => "{$prefix}event_start",
			'type' => 'date',
			// jQuery date picker options. See here http://jqueryui.com/demos/datepicker
			'js_options' => array(
				'autoSize'        => true,
				'buttonText'      => __('Seleccionar fecha', 'positive-backend'),
				'dateFormat'      => 'yy-mm-dd',
				'numberOfMonths'  => 1,
				'showButtonPanel' => true
			),
		),
		array(
			'name' => 'Fecha fin',
			'id'   => "{$prefix}event_end",
			'type' => 'date',
			'js_options' => array(
				'autoSize'        => true,
				'buttonText'      => __('Seleccionar fecha', 'positive-backend'),
				'dateFormat'      => 'yy-mm-dd',
				'numberOfMonths'  => 1,
				'showButtonPanel' => true
			)
		),
		array(
			'name'	=> 'Lugar',
			'id'	=> "{$prefix}event_place",
			'type'	=> 'text'
		),
		array(
			'name'	=> 'Telefono',
			'id'	=> "{$prefix}event_phone",
			'type'	=> 'text'
		),
		array(
			'name'	=> 'Email',
			'id'	=> "{$prefix}event_mail",
			'type'	=> 'text'
		)

	)
);

function PS_register_meta_boxes(){
	global $meta_boxes;
	if ( class_exists( 'RW_Meta_Box' ) ) {
		foreach ( $meta_boxes as $meta_box ) {
			if ( isset( $meta_box['only_on'] ) && ! rw_maybe_include( $meta_box['only_on'] ) ) {
				continue;
			}
			new RW_Meta_Box( $meta_box );
		}
	}
}
add_action( 'admin_init', 'PS_register_meta_boxes' );

function rw_maybe_include( $conditions ) {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
		return false;
	}
	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}
	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	}
	elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	else {
		$post_id = false;
	}
	$post_id = (int) $post_id;
	$post    = get_post( $post_id );
	foreach ( $conditions as $cond => $v ) {
		// Catch non-arrays too
		if ( ! is_array( $v ) ) {
			$v = array( $v );
		}
		switch ( $cond ) {
			case 'id':
				if ( in_array( $post_id, $v ) ) {
					return true;
				}
			break;
			case 'parent':
				$post_parent = $post->post_parent;
				if ( in_array( $post_parent, $v ) ) {
					return true;
				}
			break;
			case 'slug':
				$post_slug = $post->post_name;
				if ( in_array( $post_slug, $v ) ) {
					return true;
				}
			break;
			case 'template':
				$template = get_post_meta( $post_id, '_wp_page_template', true );
				if ( in_array( $template, $v ) ) {
					return true;
				}
			break;
		}
	}
	// If no condition matched
	return false;
}



?>