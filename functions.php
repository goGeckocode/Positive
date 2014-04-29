<?php
include_once 'includes/positive-functions.php';

// WIDGETS PROPIOS DE AMEC
include_once 'includes/page-builder/widgets/widgets/amec-widgets.php';

/* ==================
	 theme scripts
   ================= */
function positive_scripts() {
	$template = get_template_directory_uri();

	wp_deregister_script( 'jquery' ); // Unregister WordPress jQuery
    wp_register_script( 'jquery', $template.'/js/vendor/jquery-1.9.1.min.js', 'jquery', '1.9.1');
	wp_enqueue_script('jquery');

	wp_enqueue_script('modernizr', $template.'/js/vendor/modernizr.js', '', '2.7.1');
	wp_enqueue_script('simplemodal', $template.'/js/vendor/jquery.simplemodal.1.4.4.min.js', '', '1.4');
	wp_enqueue_script('positive-panels-front', $template.'/js/positive-panels-main.js', 'jquery, modernizr', '1.0.0');
	wp_enqueue_script('jqtransform', $template.'/js/vendor/jquery.jqtransform.js', '', '1.3');
	wp_enqueue_script('positive-main', $template.'/js/custom.js', 'jquery, modernizr', '1.0.0');
	wp_enqueue_script('positive-responsive', $template.'/js/responsive.js', 'jquery', '1.0.0');
}
add_action('wp_enqueue_scripts', 'positive_scripts');


/* =============================================================================
	 Register Sidebars
	 ========================================================================== */
function positive_sidebars() {
    register_sidebar(array(
		'name'=>__('News sidebar','positive-backend'),
     	'id' => 'blog-sidebar',
     	'description' => __('Sidebar to display in News section', 'positive-backend'),
     	'before_widget' => '<section id="%1$s" class="panel %2$s">',
     	'after_widget' => '</section>'
    ));
    register_sidebar(array(
		'name'=>'Actividades sidebar',
     	'id' => 'actividades-sidebar',
     	'description' => 'Este Sidebar se mostrara en Actividades',
     	'before_widget' => '<section id="%1$s" class="panel %2$s">',
     	'after_widget' => '</section>'
    ));
    register_sidebar(array(
		'name'=>'Comunicacion sidebar',
     	'id' => 'comunicacion-sidebar',
     	'description' => 'Este Sidebar se mostrara en Comunicacion',
     	'before_widget' => '<section id="%1$s" class="panel %2$s">',
     	'after_widget' => '</section>'
    ));
    register_sidebars(3, array(
		'name'=>'Footer %d',
     	'id' => "footer$i",
     	'description' => __('Footer widgets area', 'positive-backend'),
     	'before_widget' => '<div id="%1$s" class="panel %2$s">',
     	'after_widget' => '</div>'
    ));
    register_sidebar(array(
		'name'=>'directorio',
     	'id' => 'directorio-sidebar',
     	'description' => 'Este Sidebar se mostrara en directorio',
     	'before_widget' => '<section id="%1$s" class="panel blue-box %2$s">',
     	'after_widget' => '</section>'
    ));
}
add_action('init', 'positive_sidebars');


/* ==================
	 Register Menu
   ================= */
function positive_menus() {
	register_nav_menus(
		array('header-menu' => __('Header Menu', 'positive'),
			'mobile-menu' => __('Mobile Menu', 'positive') 
		)
	);
}
add_action('init', 'positive_menus');


/* ==================
	 images
   ================= */
add_theme_support( 'post-thumbnails' );
add_action('init','remove_thumbnail_support');
function remove_thumbnail_support(){
	remove_post_type_support('page','thumbnail');
}


/* ==================
	 excerpt
   ================= */
function positive_excerpt_length( $length ) {
       return 35;
}
add_filter( 'excerpt_length', 'positive_excerpt_length', 999 );


/* ==================
	 Custom Post Types
   ================= */
function positive_post_types() {
	register_post_type( 'actividades',
		array(
			'labels' => array(
				'name' => 'Actividades',
				'singular_name' => 'Actividad',
				'add_new' => 'Crear nueva' ,
				'add_new_item' => 'Crear nueva',
				'edit' => __('Edit'),
				'edit_item' => 'Crear nueva',
				'new_item' => 'Nueva Actividad',
				'view' => __('View'),
				'view_item' => __('View'),
				'search_items' => __('Search')
			),
			'public' => true,
			'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
			'has_archive' => false,
			'supports' => array('title', 'editor'),
			'can_export' => true,
			'show_in_nav_menus' => false,
			'menu_position' => 5,
			'rewrite' => array( 'slug' => 'evento' ),
		)
	);
	register_post_type( 'comunicacion',
		array(
			'labels' => array(
				'name' => 'comunicacion',
				'singular_name' => 'comunicacion',
				'add_new' => 'Crear nuevo' ,
				'add_new_item' => 'Crear nuevo',
				'edit' => __('Edit'),
				'edit_item' => 'Editar comunicacion',
				'new_item' => 'Nuevo comunicacion',
				'view' => __('View'),
				'view_item' => __('View'),
				'search_items' => __('Search')
			),
			'public' => true,
			'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
			'has_archive' => false,
			'supports' => array('title', 'editor'),
			'can_export' => true,
			'show_in_nav_menus' => false,
			'menu_position' => 5,
			'rewrite' => array( 'slug' => 'comunicaciones' )
		)
	);
	register_post_type( 'sectores',
		array(
			'labels' => array(
				'name' => 'Sectores',
				'singular_name' => 'Sector',
				'add_new' => 'Crear nuevo' ,
				'add_new_item' => 'Crear nuevo',
				'edit' => __('Edit'),
				'edit_item' => 'Editar sector',
				'new_item' => 'Nuevo Sector',
				'view' => __('View'),
				'view_item' => __('View'),
				'search_items' => __('Search')
			),
			'public' => true,
			'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
			'has_archive' => false,
			'supports' => array('title', 'editor'),
			'can_export' => true,
			'show_in_nav_menus' => false,
			'menu_position' => 5
		)
	);
	register_post_type( 'miembros',
		array(
			'labels' => array(
				'name' => 'Miembros',
				'singular_name' => 'Miembro',
				'add_new' => 'Crear nuevo' ,
				'add_new_item' => 'Crear nuevo',
				'edit' => __('Edit'),
				'edit_item' => 'Editar miembro',
				'new_item' => 'Nuevo Miembro',
				'view' => __('View'),
				'view_item' => __('View'),
				'search_items' => __('Search')
			),
			'public' => true,
			'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
			'has_archive' => false,
			'supports' => array('title', 'editor' ),
			'can_export' => true,
			'show_in_nav_menus' => false,
			'menu_position' => 5
		)
	);
}
add_action( 'init', 'positive_post_types' );


/* =============================================================================
	 Custom Taxonomies
	 ========================================================================== */
function custom_taxonomies() {	

	register_taxonomy('tipo_actividades',array('actividades'), array(
		'labels' => array(
			'name' => __( 'Tipos de actividades', 'taxonomy general name' ),
			'singular_name' => __( 'Tipo de actividad', 'taxonomy singular name' ),
			'search_items' =>  'Buscar Tipo de actividad',
			'all_items' => 'Todos los Tipos de actividades',
			'parent_item' => 'Tipo de actividad superior',
			'parent_item_colon' => 'Tipo de actividad superior:',
			'new_item_name' => 'Nuevo Tipo de actividad',
			'menu_name' => 'Tipos de actividades',
		),
		'hierarchical' => true,
		//'rewrite' => array( 'slug' => '' )
	));
	register_taxonomy('tipo_comunicacion',array('comunicacion'), array(
		'labels' => array(
			'name' => __( 'Categorias de comunicacion', 'taxonomy general name' ),
			'singular_name' => __( 'Categorias de comunicacion', 'taxonomy singular name' ),
			'search_items' =>  'Buscar Categorias de comunicacion',
			'all_items' => 'Todos las Categorias de comunicacion',
			'parent_item' => 'Categorias de comunicacion superior',
			'parent_item_colon' => 'Categorias decomunicacion superior:',
			'new_item_name' => 'Nuevo Categorias de comunicacion',
			'menu_name' => 'Categorias de comunicacion',
		),
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'comunicacion' )
	));
}
add_action( 'init', 'custom_taxonomies', 0 );


/* ==================
	 Events functions
   ================= */
   /* handle future posts (events) */
function events_future_post_hook($deprecated = '', $post) {
    wp_publish_post( $post->ID );
}
remove_action( 'future_actividades', '_future_post_hook', 5, 2 );
add_action( 'future_actividades', 'events_future_post_hook', 5, 2);

function events_future_post_where($where, $that) {
    global $wpdb;
    if("actividades" == $that->query_vars['post_type'] && is_archive())
        $where = str_replace( "{$wpdb->posts}.post_status = 'publish'", "{$wpdb->posts}.post_status = 'publish' OR $wpdb->posts.post_status = 'future'", $where);
    return $where;
}
add_filter('posts_where', 'events_future_post_where', 2, 10);

// set query events order from current date
function positive_pre_get_events( $query ){
	// validate
	if( is_admin() ) return $query;
 
    if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'actividades' ){
    	$today = getdate();
    	$query_date = array(
			array(
				'after' => array(
					'year'  => $today["year"],
					'month' => $today["mon"],
					'day'   => $today["mday"]-1,
				),
				'inclusive' => true,
			)
		);

    	$query->set('orderby', 'meta_value');  
    	$query->set('meta_key', 'PS_event_start');  
    	$query->set('order', 'ASC'); 
    	$query->set('date_query', $query_date);
    }   
 
	// always return
	return $query;
 
}
add_action('pre_get_posts', 'positive_pre_get_events');

// set post date from meta box for events
function positive_set_event_date($post_id) {
    if ( 'actividades' != $_POST['post_type'] ) return;

	$end_date = rwmb_meta('PS_event_end', $post_id);
	if($end_date == '') $end_date = rwmb_meta('PS_event_start', $post_id);

	if( $end_date ) {
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post', 'positive_set_event_date', 13, 2 );

		// update the post, which calls save_post again
		wp_update_post(array (
	        'ID'            => $post_id, // ID of the post to update
	        'post_date'     => $end_date,
	        'post_date_gmt' => get_gmt_from_date( $end_date )
		));

		// re-hook this function
		add_action( 'save_post', 'positive_set_event_date', 13, 2 );
	}
}
add_action( 'save_post', 'positive_set_event_date', 13, 2 );


/* ==================
	 theme functions
   ================= */
// Dinamic BLOG & EVENTS section & sidebar title
function positive_blog_title(){
	$posts_page = get_option('page_for_posts');

	$blog_title = ($posts_page ? get_the_title($posts_page) : __('News','positive'));

	if (is_front_page()){
		$blog_title = '<a class="positive-icon i-news-title select-item" href="#post-news">'.$blog_title.'</a>';
	} elseif(!is_home()){
		$blog_url = ($posts_page ? get_permalink($posts_page) : get_option('home'));
		$blog_title = '<a href="'.$blog_url.'">'.$blog_title.'</a>';
	}

	return $blog_title;
}
function positive_events_title(){
	global $theme_data, $post;
	$events_page = $theme_data['ps_page_events'];
	$events_title = ($events_page ? get_the_title($events_page) : __('Events','positive'));

	if (is_front_page()) {
		$events_title = '<a class="positive-icon i-events-title" href="#post-actividades">'.$events_title.'</a>';
	} elseif ($post->ID != $events_page){
		$events_title = '<a href="'.get_permalink($events_page).'">'.$events_title.'</a>';
	}
	

	return $events_title;
}
function positive_comunicacion_title(){
	global $theme_data, $post;
	$comunicacion_page = $theme_data['ps_page_comunicacion'];
	$comunicacion_title = ($comunicacion_page ? get_the_title($comunicacion_page) : __('comunicacion','positive'));

	if (is_front_page()) {
		$comunicacion_title = '<a class="positive-icon i-comunicacion-title" href="#post-comunicacion">'.$comunicacion_title.'</a>';
	} elseif ($post->ID != $comunicacion_page){
		$comunicacion_title = '<a href="'.get_permalink($comunicacion_page).'">'.$comunicacion_title.'</a>';
	}
	

	return $comunicacion_title;
}

// Function to know if a page has children
function has_children($post_id) {
    $children = get_pages('child_of='.$post_id);
    if( count( $children ) != 0 ) { return true; } // Has Children
    else { return false;} // No children
}

// Conditional tag for custom post type events
function is_event() {
	global $post;
	if(is_single() && $post->post_type == 'actividades' || is_archive() && get_post_type() == 'actividades') { return true; }
	else { return false; }
}
// Conditional tag for custom post type comunicacion
function is_comunicacion() {
	global $post;
	if(is_single() && $post->post_type == 'comunicacion'|| is_archive() && get_post_type() == 'comunicacion') { return true; }
	else { return false; }
}

//function for pagination
function paginate() {
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => false,
		'end_size' => 0,
		'mid_size' => 0,
		'type' => 'list'
	);
	if ( $wp_rewrite->using_permalinks() ) $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	if ( !empty($wp_query->query_vars['s']) ) $pagination['add_args'] = array( 's' => get_query_var( 's' ) );  

	$prev = (get_previous_posts_link() ? get_previous_posts_link('&lt; '.__('Anterior','positive')) : '<span class="btn">&lt; '.__('Anterior','positive').'</span>' );
	$next = (get_next_posts_link() ? get_next_posts_link(__('Siguiente','positive').' &gt;') : '<span class="btn">'.__('Siguiente','positive').' &gt;</span>');

	$links = '<span class="pg-next">'. $next.'</span><span class="pg-prev">'.$prev.'</span><span class="pagexofy">'. $current .' '.__('de','positive').' '. $wp_query->max_num_pages .' '.__('p&aacute;ginas','positive').'</span>';
	if($wp_query->max_num_pages > 1) echo $links;
}


/* =============================================================================
	 Unregister Widget
	 ========================================================================== */
 function unregister_default_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    //unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    //unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    //unregister_widget('WP_Widget_Categories');
    //unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
    //unregister_widget('WP_Nav_Menu_Widget');
 }
 add_action('widgets_init', 'unregister_default_widgets', 11);


?>