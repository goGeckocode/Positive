<?php
require( 'page-builder/siteorigin-panels.php' );
// unregister widgets
 function unregister_default_widgets() {
    //unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    //unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    //unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
    //unregister_widget('WP_Nav_Menu_Widget');
    //unregister_widget('Twenty_Eleven_Ephemera_Widget');
 }
 add_action('widgets_init', 'unregister_default_widgets', 11);

function positive_sidebars() {
	register_sidebar(array(
		'name' => __( 'Sidebar' ),
  		'id' => 'sidebar',
  		'description' => __( 'This is the sidebar of your site.' ),
  		'before_title' => '<h2>',
  		'after_title' => '</h2>'
	));
}
add_action( 'init', 'positive_sidebars' );

function register_my_menus() {
	register_nav_menus(
		array('header-menu' => __( 'Header Menu' ) )
	);
}
add_action( 'init', 'register_my_menus' );

add_theme_support( 'post-thumbnails' );
add_image_size( 'single', 614, 270, true );

function add_scripts() {
    wp_enqueue_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'add_scripts');





// ****************************************
//  		theme configuration
// ****************************************
/*$themename = "Destacados";
$shortname = "nt";
$options = array (
	array( "name" => "Introduce en cada campo el ID de la entrada que quieras destacar",
		"type" => "title"), 
	array( "name" => "Entradas destacadas",
		"type" => "section"), 
	array( "type" => "open"), 
	array( "name" => "destacado-1",
		"desc" => "ID de la entrada",
		"id" => $shortname."_destacado-1",
		"type" => "text",
		"std" => ""), 
	array( "name" => "destacado-2",
		"id" => $shortname."_destacado-2",
		"type" => "text",
		"std" => ""),
	array( "type" => "close")
);

function mytheme_add_admin() {
	global $themename, $shortname, $options;
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
			}
			foreach ($options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } 
			}
			header("Location: admin.php?page=functions.php&saved=true");
			die;
		} else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				delete_option( $value['id'] ); 
			}
			header("Location: admin.php?page=functions.php&reset=true");
			die;
		}
	}
	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mytheme_admin');
}
function mytheme_add_init() {
	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
	wp_enqueue_script("rm_script", $file_dir."/functions/rm_script.js", false, "1.0");
}
function mytheme_admin() {
	global $themename, $shortname, $options;
	$i=0;

	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' configuraci&oacute;n salvada.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' configraci&oacute;n reseteada.</strong></p></div>'; ?>
	
	<div class="wrap rm_wrap">
		<h2>Entradas destacadas</h2>
		<div class="rm_opts">
			<form method="post">
				<?php foreach ($options as $value) {
					switch ( $value['type'] ) {
						case "open": 
							break;
						
						case "section": 
							$i++; ?>
							<div class="rm_section <?php echo $value['name']; ?>">
								<div class="rm_title">
									<h3><img src="<?php bloginfo('template_directory')?>/functions/images/trans.gif" class="inactive" alt=""><?php echo $value['name']; ?></h3>
									<span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Salvar cambios" /></span>
									<div class="clearfix"></div>
								</div>
								<div class="rm_options <?php echo $value['name']; ?>">
							<?php break;
						case "title": ?>
							<p><?php echo $value['name']; ?></p>
							<?php break;
						
						case 'text': ?>
							<div class="rm_input rm_text">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
								<small><?php echo $value['desc']; ?></small>
								<div class="clearfix"></div>
							</div>
							<?php break;

						case "close": ?>
							</div></div><br />
							<?php break;

						
					}
				} ?>

				<input type="hidden" name="action" value="save" />
			</form>
			<form method="post">
				<p class="submit">
					<input name="reset" type="submit" value="Reset" />
					<input type="hidden" name="action" value="reset" />
				</p>
			</form>
		</div> 
 

<?php
}
add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');*/

	
?>