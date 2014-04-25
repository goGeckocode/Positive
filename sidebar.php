<?php global $theme_data, $post; ?>

<aside class="column column-1 span-2 blue-box">
 	<?php
	if( $theme_data['ps_page_events'] && $post->ID == $theme_data['ps_page_events'] || is_event() ){
		echo '<p class="panel"><strong>'.positive_events_title().'</strong> &gt;</p>';
		if ( is_active_sidebar( 'actividades-sidebar' ) ) dynamic_sidebar( 'actividades-sidebar' );
	} else {
	 	echo '<p class="panel"><strong>'.positive_blog_title().'</strong> &gt;</p>';
		if ( is_active_sidebar( 'blog-sidebar' ) ) dynamic_sidebar( 'blog-sidebar' );
	} ?>
</aside>
