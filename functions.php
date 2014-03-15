<?php
require( 'page-builder/siteorigin-panels.php' );
require( 'includes/black-studio-tinymce-widget/black-studio-tinymce-widget.php' );

// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/includes/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( TEMPLATEPATH . '/includes/meta-box' ) );
// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';

include 'includes/metaboxes.php';
include 'includes/themeOptions.php';

/* =============================================================================
	 Unregister Widget
	 ========================================================================== */
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
/* =============================================================================
	 Register Sidebars
	 ========================================================================== */
 function positive_sidebars() {
       register_sidebars(3, array(
       			'name'=>'Footer %d',
             	'id' => "footer$i",
             	'description' => __( 'Este es el area de widgets para footer' ),
             	'before_widget' => '<div id="%1$s" class="panel %2$s">',
             	'after_widget' => '</div>'
       ));
}
add_action( 'init', 'positive_sidebars' );
/* =============================================================================
	 Register Menu
	 ========================================================================== */
function register_my_menus() {
	register_nav_menus(
		array('header-menu' => __( 'Header Menu' ) )
	);
}
add_action( 'init', 'register_my_menus' );

/* =============================================================================
	 images
	 ========================================================================== */
add_theme_support( 'post-thumbnails' );
add_image_size( 'single', 614, 270, true );

/* =============================================================================
	 theme scripts
	 ========================================================================== */
function add_scripts() {
	$template = get_template_directory_uri();

	wp_deregister_script( 'jquery' ); // Unregister WordPress jQuery
    wp_register_script( 'jquery', $template.'/js/jquery-1.9.1.min.js', 'jquery', '1.9.1');
	wp_enqueue_script('jquery');

	wp_register_script('custom', $template.'/js/custom.js', 'jquery', '1.0.0');
	wp_enqueue_script('custom');
}
add_action('wp_enqueue_scripts', 'add_scripts');

/* =============================================================================
	 excerpt
	 ========================================================================== */
function custom_excerpt_length( $length ) {
       return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/* =============================================================================
	 Remove the <div> surrounding the dynamic navigation to cleanup markup
	 ========================================================================== */
function FS_wp_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
}

/* =============================================================================
	COMENTARIOS
	========================================================================== */
if ( ! function_exists( 'posts_comment' ) ) :
	function posts_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' : ?>
				<li class="post pingback">
					<p><?php _e( 'Pingback:', 'fotografosev' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'fotografosev' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php break;

			default : ?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<p class="comment-author vcard">
							<?php 
							printf( __( '%1$s  %2$s', 'fotografosev' ),
								sprintf( '<time pubdate datetime="%2$s">%3$s</time>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									
									sprintf ( get_comment_date(), get_comment_time() )
								),
								sprintf( '<span class="fn">%s</span>', get_comment_author_link() )
							); ?>

							<?php edit_comment_link( __( 'Edit', 'fotografosev' ), '<span class="edit-link">', '</span>' ); ?>
						</p>

						<?php if ( $comment->comment_approved == '0' ) : ?>
							<p class="awaiting-moderation"><?php _e( 'Tu comentario esta pendiente de moderaci&oacute;n.', 'fotografosev' ); ?></p>
						<?php endif; ?>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '> Responder', 'fotografosev' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div>
					</article>

				<?php break;

		endswitch;
	}
endif;

/* =============================================================================
	NEXT / PREVIOUS POST LINK, SAME TAXONOMY
	==========================================================================
 * Edited by GeckoCode to navigate in a taxonomy
 * Can either be next or previous post.
 * @param bool $in_same_cat Optional. Whether post should be in a same category.
 * @param array|string $excluded_categories Optional. Array or comma-separated list of excluded category IDs.
 * @param bool $previous Optional. Whether to retrieve previous post.
 * @return mixed Post object if successful. Null if global $post is not set. Empty string if no corresponding post exists.
 */
function gecko_get_adjacent_post( $in_same_cat = true, $excluded_categories = '', $previous = true ) {
	global $post, $wpdb;

	if ( empty( $post ) )
		return null;

	$current_post_date = $post->post_date;

	$join = '';
	$posts_in_ex_cats_sql = '';
	if ( $in_same_cat || ! empty( $excluded_categories ) ) {
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

		if ( $in_same_cat ) {
			/* editado por GeckoCode */
			$pType = $post->post_type;
			$pTypeObj = get_post_type_object($pType);
			$taxonomy = $pTypeObj->taxonomies[0];

			$cat_array = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
			$join .= " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
		}

		$posts_in_ex_cats_sql = "AND tt.taxonomy = '".$taxonomy."'";
		if ( ! empty( $excluded_categories ) ) {
			if ( ! is_array( $excluded_categories ) ) {
				// back-compat, $excluded_categories used to be IDs separated by " and "
				if ( strpos( $excluded_categories, ' and ' ) !== false ) {
					_deprecated_argument( __FUNCTION__, '3.3', sprintf( __( 'Use commas instead of %s to separate excluded categories.' ), "'and'" ) );
					$excluded_categories = explode( ' and ', $excluded_categories );
				} else {
					$excluded_categories = explode( ',', $excluded_categories );
				}
			}

			$excluded_categories = array_map( 'intval', $excluded_categories );

			if ( ! empty( $cat_array ) ) {
				$excluded_categories = array_diff($excluded_categories, $cat_array);
				$posts_in_ex_cats_sql = '';
			}

			if ( !empty($excluded_categories) ) {
				$posts_in_ex_cats_sql = " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.post_date $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_post_date, $post->post_type), $in_same_cat, $excluded_categories );
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1" );

	$query = "SELECT p.* FROM $wpdb->posts AS p $join $where $sort";
	$query_key = 'adjacent_post_' . md5($query);
	$result = wp_cache_get($query_key, 'counts');
	if ( false !== $result )
		return $result;

	$result = $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $sort");
	if ( null === $result )
		$result = '';

	wp_cache_set($query_key, $result, 'counts');
	return $result;
}
/**
 * Display adjacent post link.
 *
 * Can be either next post link or previous.
 * @param string $format Link anchor format.
 * @param string $link Link permalink format.
 * @param bool $in_same_cat Optional. Whether link should be in a same category.
 * @param array|string $excluded_categories Optional. Array or comma-separated list of excluded category IDs.
 * @param bool $previous Optional, default is true. Whether to display link to previous or next post.
 */
function gecko_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '') {
	gecko_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true);
}
function gecko_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '') {
	gecko_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false);
}
function gecko_adjacent_post_link($format='%link', $link='%title', $in_same_cat = false, $excluded_categories = '', $previous = true) {
	$post = gecko_get_adjacent_post($in_same_cat, $excluded_categories, $previous);

	if ( !$post )
		return;

	$title = $post->post_title;

	if ( empty($post->post_title) )
		$title = $previous ? __('Previous Post') : __('Next Post');

	$title = apply_filters('the_title', $title, $post->ID);
	$date = mysql2date(get_option('date_format'), $post->post_date);
	$rel = $previous ? 'prev' : 'next';

	$string = '<a href="'.get_permalink($post).'" rel="'.$rel.'">';
	$link = str_replace('%title', $title, $link);
	$link = str_replace('%date', $date, $link);
	$link = $string . $link . '</a>';

	$format = str_replace('%link', $link, $format);

	$adjacent = $previous ? 'previous' : 'next';
	echo apply_filters( "{$adjacent}_post_link", $format, $link );
}

/* =============================================================================
	CMS Cleanup
	========================================================================== */

	// cambiamos el texto del footer
	add_filter( 'admin_footer_text', 'my_admin_footer_text' );
	function my_admin_footer_text( $default_text ) {
		return '<span id="footer-thankyou">Theme Positive by <a href="http://www.geckocode.es" target="_blank">Geckocode</a> & <a href="http://www.lamagacomunica.com" target="_blank">lamaga comunica</a><span> | Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';
	}


?>