<?php
include_once 'page-builder/positive-panels.php';
include_once 'metaboxes.php';
include_once 'theme-options.php';
include_once 'shortcode/shortcode.php';

function positive_languages(){
	if (!is_admin() && $pagenow == 'index.php') {
		load_theme_textdomain('positive');
        load_theme_textdomain('positive', get_template_directory().'/lang');
    } else {
    	load_theme_textdomain('positive-backend');
        load_theme_textdomain('positive-backend', get_stylesheet_directory().'/includes/lang');
    } 
}
add_action('admin_init', 'positive_languages');
add_action('after_setup_theme', 'positive_languages');


/* ==============================
	 Theme Configuration
   ============================ */
$theme_data = get_option('theme_options');

// Set Front page
if (!empty($theme_data['ps_page_home'])){
	update_option('show_on_front', 'page');
	update_option('page_on_front', $theme_data['ps_page_home'] );

	// Set blog page
	if (!empty($theme_data['ps_page_blog']) && $theme_data['ps_page_blog'] != $theme_data['ps_page_home'] ){
		update_option( 'page_for_posts', $theme_data['ps_page_blog'] );
	}
	else update_option( 'page_for_posts', 0 );

} 
else {
	update_option( 'show_on_front', 'posts' );
	update_option( 'page_for_posts', 0 );
}

// Use chosen favicon also in backend
function positive_favicon() {
	global $theme_data;
	if($theme_data['ps_favicon'])
    	echo '<link rel="icon" type="image/png" href="'.$theme_data['ps_favicon']['src'].'">';
} 
add_action('login_head', 'positive_favicon');
add_action('admin_head', 'positive_favicon');
add_action('wp_head', 'positive_favicon');

// Social Networks buttons
function positive_social_buttons(){
	global $theme_data;
	if($theme_data['ps_network']) { ?>
        <ul class="social-network">
        <?php foreach ($theme_data['ps_network'] as $red) {
        	$attr = ( $red['ps_social_network_name'] == 'rss' ? 
        		'href="'.get_bloginfo('rss2_url').'"' : 
        		'target="_blank" href="'.$red['ps_social_network_url'].'"'
        	);
            echo '<li class="'.$red['ps_social_network_name'].'"><a '.$attr.' title="'.$red['ps_social_network_name'].'">'.$red['ps_social_network_name'].'</a></li>';
        }?>
        </ul>
    <?php }
}


/* =============================
	LAYOUT BUILDER OPTIONS
   =========================== */
function positive_panels_setting($key = ''){
	//static $settings;
	$settings = array(
		'post-types' => array('page'),	// Post types that can be edited using panels.
		'bundled-widgets' => false,		// Include bundled widgets
		'copy-content' => true			// Should we copy across content
	);
	if( !empty( $key ) ) return isset( $settings[$key] ) ? $settings[$key] : null;
	return $settings;
}


/* =============================
	POSITIVE ADMIN FOOTER
   =========================== */
// admin footer text
function my_admin_footer_text( $default_text ) {
	return '<span id="footer-thankyou">Theme Positive by <a href="http://www.geckocode.es" target="_blank">Geckocode</a> & <a href="http://www.lamagacomunica.com" target="_blank">lamaga comunica</a><span> | Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';
}
add_filter( 'admin_footer_text', 'my_admin_footer_text' );
	
	
?>