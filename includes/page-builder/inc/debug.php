<?php

/**
 * If we're in debug mode, display the panels data.
 */
function positive_panels_dump(){
	echo "<!--\n\n";
	echo "// Panels Data dump\n\n";

	global $post;
	var_export( get_post_meta($post->ID, 'panels_data', true));
	echo "\n\n-->";
}
add_action('positive_panels_metabox_end', 'positive_panels_dump');