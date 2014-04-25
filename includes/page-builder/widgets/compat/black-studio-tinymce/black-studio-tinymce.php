<?php
/**
 *  This file adds compatibility with Black Studio TinyMCE widget.
 */

/**
 * Add all the required actions for the TinyMCE widget.
 */
function positive_panels_black_studio_tinymce_admin_init() {
	global $pagenow;

	if (in_array($pagenow, array('post-new.php', 'post.php')) ||
		($pagenow == 'themes.php' && isset($_GET['page']) )
	)  {
		add_action( 'admin_head', 'black_studio_tinymce_load_tiny_mce' );
		add_filter( 'tiny_mce_before_init', 'black_studio_tinymce_init_editor', 20 );
		add_action( 'admin_print_scripts', 'black_studio_tinymce_scripts' );
		add_action( 'admin_print_styles', 'black_studio_tinymce_styles' );
		add_action( 'admin_print_footer_scripts', 'black_studio_tinymce_footer_scripts' );
	}

}
add_action('admin_init', 'positive_panels_black_studio_tinymce_admin_init');

/**
 * Enqueue all the admin scripts for Black Studio TinyMCE compatibility with Page Builder.
 *
 * @param $page
 */
function positive_panels_black_studio_tinymce_admin_enqueue($page) {
	$screen = get_current_screen();
	if ( $screen->base == 'post' && in_array( $screen->id, positive_panels_setting('post-types') ) ) {
		wp_enqueue_script('black-studio-tinymce-widget-positive-panels', POSITIVE_PANELS_URL.'widgets/compat/black-studio-tinymce/black-studio-tinymce-widget-positive-panels.min.js', array('jquery'), POSITIVE_PANELS_VERSION);
		wp_enqueue_style('black-studio-tinymce-widget-positive-panels', POSITIVE_PANELS_URL.'widgets/compat/black-studio-tinymce/black-studio-tinymce-widget-positive-panels.css', array(), POSITIVE_PANELS_VERSION);
	}
}
add_action('admin_enqueue_scripts', 'positive_panels_black_studio_tinymce_admin_enqueue', 15);

