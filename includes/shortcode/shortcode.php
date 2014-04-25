<?php 
/* =============================
	SHORTCODE COLUMNAS
   =========================== */

// creamos el shortcode.
function positive_css_columns( $atts, $content = null ) {
    return '<div class="positive-css-columns">'.$content.'</div>';
}
// el primer elemento es el shortcode en si, es decor [1ºelemento], el 2º es el nombre de la funcion
add_shortcode("columns", "positive_css_columns");

// se añade el boton al Tinymce
add_action('init', 'add_button');
function add_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin');
     add_filter('mce_buttons', 'register_button');
   }
}
// se registra el boton, EL ID debera ser igual al "ed.addButton".
function register_button($buttons) {
   array_push($buttons, "columnID");
   return $buttons;
}
// se añade el plugin, el id debera ser igual en "tinymce.PluginManager.add"
function add_plugin($plugin_array) {
   $plugin_array['pluginID'] = get_bloginfo('template_url').'/includes/shortcode/shortcode.js';
   return $plugin_array;
}
?>