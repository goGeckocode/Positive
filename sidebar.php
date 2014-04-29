<?php global $theme_data, $post; ?>

 	<?php
	if( $theme_data['ps_page_events'] && $post->ID == $theme_data['ps_page_events'] || is_event() ){
		echo '<aside class="column column-1 span-2 orange-box">';
		echo '<p class="panel"><strong>'.positive_events_title().'</strong></p>';
		if ( is_active_sidebar( 'actividades-sidebar' ) ) dynamic_sidebar( 'actividades-sidebar' );
	} elseif ( $theme_data['ps_page_comunicacion'] && $post->ID == $theme_data['ps_page_comunicacion'] || is_comunicacion() ){
		echo '<aside class="column column-1 span-2 blue-box">';
		echo '<p class="panel"><strong>'.positive_comunicacion_title().'</strong></p>';
		if ( is_active_sidebar( 'comunicacion-sidebar' ) ) dynamic_sidebar( 'comunicacion-sidebar' );
	} else {
		echo '<aside class="column column-1 span-2 blue-box">';
	 	echo '<p class="panel"><strong>'.positive_blog_title().'</strong></p>';
		if ( is_active_sidebar( 'blog-sidebar' ) ) dynamic_sidebar( 'blog-sidebar' );
	} ?>
</aside>
