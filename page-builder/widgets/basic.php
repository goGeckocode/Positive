<?php
/**
 * Basic widgets included in Positive Page builder
 *
 */

/* **********************
 * HEADING
 */
class Positive_Panels_Widget_Heading extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-heading',
			__( 'Heading (Positive)', 'siteorigin-panels' ),
			array(
				'description' => __( 'Create a custom Heading.', 'siteorigin-panels' ),
			)
		);
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo '<'.$instance['heading'].' class="align-'.$instance['align'].'">'.$instance['title'].'</'.$instance['heading'].'>';
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'title' => '',
			'heading' => '',
			'align' => ''
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'title' => '',
			'heading' => '',
			'align' => ''
		));

		?>
		<?php // Title ?>
		<p><input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr($instance['title']) ?>" /></p>
		<?php // Heading ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'heading' ) ?>"><?php _e( 'Heading Level', 'siteorigin-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'heading' ) ?>" id="<?php echo $this->get_field_id( 'heading' ) ?>">
				<option value="h1" <?php selected(empty($instance['heading'])) ?>><?php esc_html_e( 'H1', 'siteorigin-panels' ) ?></option>
				<option value="h2" <?php selected('h2', $instance['heading']) ?>><?php esc_html_e( 'H2', 'siteorigin-panels' ) ?></option>
				<option value="h3" <?php selected('h3', $instance['heading']) ?>><?php esc_html_e( 'H3', 'siteorigin-panels' ) ?></option>
			</select>
		</p>
		<?php // Align ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'align' ) ?>"><?php _e( 'Heading Align', 'siteorigin-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'align' ) ?>" id="<?php echo $this->get_field_id( 'align' ) ?>">
				<option value="left" <?php selected(empty($instance['align'])) ?>><?php esc_html_e( 'left', 'siteorigin-panels' ) ?></option>
				<option value="right" <?php selected('right', $instance['align']) ?>><?php esc_html_e( 'right', 'siteorigin-panels' ) ?></option>
				<option value="center" <?php selected('center', $instance['align']) ?>><?php esc_html_e( 'center', 'siteorigin-panels' ) ?></option>
			</select>
		</p>
	<?php
	}
}

/* **********************
 * BUTTON
 */
class Positive_Panels_Widget_Button extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-button',
			__( 'Button (Positive)', 'siteorigin-panels' ),
			array(
				'description' => __( 'A simple button.', 'siteorigin-panels' ),
			)
		);
	}

	function widget( $args, $instance ) {
		$tag = ( $instance['link'] == '' ? 'span' : 'a');
		echo '<p class="panel btn-container align-'.$instance['align'].'">';
		echo '<'.$tag;
		if($instance['link'] != ''){
			echo ' href="'.$instance['link'].'"';
			if($instance['open'] != '') echo ' target="_blank"';
		} 
		echo ' class="btn">'.$instance['text'].'</'.$tag.'>';
		echo '</p>';
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'text' => '',
			'link' => '',
			'open' => '',
			'align'=> ''
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'text' => '',
			'link' => '',
			'open' => '',
			'align'=> ''
		));

		?>
		<!-- Text -->
		<p>
			<label><?php _e( 'Button label', 'siteorigin-panels' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'text' ) ?>" name="<?php echo $this->get_field_name( 'text' ) ?>" value="<?php echo esc_attr($instance['text']) ?>" /></p>
		<!-- link -->
		<p>
			<label><?php _e( 'Button Link?', 'siteorigin-panels' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link' ) ?>" name="<?php echo $this->get_field_name( 'link' ) ?>" value="<?php echo esc_attr($instance['link']) ?>" /></p>
		<!-- open -->
		<p>
			<label for="<?php echo $this->get_field_id( 'open' ) ?>"><?php _e( 'Open Link in new Window?', 'siteorigin-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'open' ) ?>" id="<?php echo $this->get_field_id( 'open' ) ?>">
				<option value="" <?php selected(empty($instance['open'])) ?>><?php esc_html_e( 'No, in the same window', 'siteorigin-panels' ) ?></option>
				<option value="_blank" <?php selected('Yes, in new window', $instance['open']) ?>><?php esc_html_e( 'Yes, in new window', 'siteorigin-panels' ) ?></option>
			</select>
		</p>
		<!-- Align -->
		<p>
			<label for="<?php echo $this->get_field_id( 'align' ) ?>"><?php _e( 'Button Align', 'siteorigin-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'align' ) ?>" id="<?php echo $this->get_field_id( 'align' ) ?>">
				<option value="left" <?php selected(empty($instance['align'])) ?>><?php esc_html_e( 'left', 'siteorigin-panels' ) ?></option>
				<option value="right" <?php selected('right', $instance['align']) ?>><?php esc_html_e( 'right', 'siteorigin-panels' ) ?></option>
				<option value="center" <?php selected('center', $instance['align']) ?>><?php esc_html_e( 'center', 'siteorigin-panels' ) ?></option>
			</select>
		</p>
	<?php
	}
}

/* **********************
 * IMAGE
 */
class Positive_Panels_Widget_Image extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-image',
			__( 'Image (Positive)', 'siteorigin-panels' ),
			array(
				'description' => __( 'Displays a simple image.', 'siteorigin-panels' ),
			)
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		// css image (background)
		if($instance['size'] == 'background'){
			echo '<div class="positive-panels-css-image" style="background-image:url('.$instance['src'].')"></div>';

		// html image
		} else {
			echo $args['before_widget'];
			if(!empty($instance['href'])) echo '<a href="' . $instance['href'] . '">';
			echo wp_get_attachment_image( $instance['id'], $instance['size'] );
			if(!empty($instance['href'])) echo '</a>';
			echo $args['after_widget'];
		}
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'src' => '',
			'size' => '',
			'id'=>0,
			'href' => ''
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'src' => '',
			'size' => '',
			'id'=>0,
			'href' => ''
		));

		?>
		<p class="image-fields">
			<label><?php _e( 'Image', 'siteorigin-panels' ) ?></label>
			<div class="thumbnail">
				<?php if($instance['id'] !='') echo wp_get_attachment_image( $instance['id']); ?>
			</div>
			<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','siteorigin-panels');?>">
			<input type="hidden" class="positive-image-src" id="<?php echo $this->get_field_id( 'src' ) ?>" name="<?php echo $this->get_field_name( 'src' ) ?>" value="<?php echo esc_attr($instance['src']) ?>">
			<input type="hidden" class="positive-image-id" id="<?php echo $this->get_field_id( 'id' ) ?>" name="<?php echo $this->get_field_name( 'id' ) ?>" value="<?php echo esc_attr($instance['id']) ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ) ?>"><?php _e( 'Image Size', 'siteorigin-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'size' ) ?>" id="<?php echo $this->get_field_id( 'size' ) ?>">
				<option value="full" <?php selected('full', $instance['size']) ?>><?php esc_html_e( 'Full', 'siteorigin-panels' ) ?></option>
				<option value="large" <?php selected('large', $instance['size']) ?>><?php esc_html_e( 'Large', 'siteorigin-panels' ) ?></option>
				<option value="medium" <?php selected('medium', $instance['size']) ?>><?php esc_html_e( 'Medium', 'siteorigin-panels' ) ?></option>
				<option value="thumbnail" <?php selected('thumbnail', $instance['size']) ?>><?php esc_html_e( 'Thumbnail', 'siteorigin-panels' ) ?></option>
				<option value="background" <?php selected('background', $instance['size']) ?>><?php esc_html_e( 'Background', 'siteorigin-panels' ) ?></option>
			</select>
			<p><small><?php _e('In the "background" choice the image will resize to fit all the area, some parts of the image wouldn\'t show','siteorigin-panels'); ?></small></p>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'href' ) ?>"><?php _e( 'Destination URL', 'siteorigin-panels' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'href' ) ?>" name="<?php echo $this->get_field_name( 'href' ) ?>" value="<?php echo esc_attr($instance['href']) ?>" />
		</p>
	<?php
	}
}

/* **********************
 * SLIDER
 */
class Positive_Panels_Widget_Slider extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-slider',
			__( 'Slider (Positive)', 'siteorigin-panels' ),
			array(
				'description' => __( 'Inserts a content or image slider.', 'siteorigin-panels' ),
			)
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		echo $args['before_widget'];
		foreach ($instance['slides'] as $slide) {
			echo '<div>';
			if ($slide['image'] != '') {
				echo '<img src="'.$slide['image'].'">';
			}
			if ($slide['title'] != '' || $slide['text'] != '') {
				echo '<div class="span-6">';
				if ($slide['title'] != '') echo '<h2>'.$slide['title'].'</h2>';
				if ($slide['text'] != '') echo '<p>'.$slide['text'].'</p>';
				echo '</div>';
			}
			echo '</div>';
		}
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'effect' => '',
			'slides' => array()
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'effect' => '',
			'slides' => array(0 => array())
		));

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'effect' ) ?>"><?php _e( 'Transition effect', 'siteorigin-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'effect' ) ?>" id="<?php echo $this->get_field_id( 'effect' ) ?>">
				<option value="fade" <?php selected('fade', $instance['effect']) ?>><?php esc_html_e( 'Fade', 'siteorigin-panels' ) ?></option>
				<option value="horizontal" <?php selected('horizontal', $instance['effect']) ?>><?php esc_html_e( 'Horizontal slide', 'siteorigin-panels' ) ?></option>
			</select>
		</p>

		<?php // cloneable fields for each slide ?>
		<h3><?php _e('Slides','siteorigin-panels'); ?></h3>
		<div class="cloneable-fields" data-name="<?php echo $this->get_field_name( 'slides' ); ?>" data-id="<?php echo $this->get_field_id( 'slides' ); ?>">
			<?php foreach($instance['slides'] as $i => $slide){ ?>
				<div class="fields slide-fields">
					<h4 class="slide-fields-header toggle-collapse">
						<strong>
							<?php if($slide['title'] != '') echo $slide['title'];
							else echo __('Slide').' '.($i+1); ?>
						</strong>
						<span class="thumbnail">
							<?php if($slide['image'] != '') echo '<img src="'.$slide['image'].'">'; ?>
						</span>
					</h4>
					<div class="collapsible">
						<p class="image-fields">
							<label><?php _e( 'Image', 'siteorigin-panels' ) ?></label>
							<span class="thumbnail">
								<?php if($slide['image'] !='') echo '<img src="'.$slide['image'].'">' ?>
							</span>
							<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','siteorigin-panels');?>">
							<?php // en el caso del slider no necesitamos ID 
								// porque pintamos la imagen a tamaño completo ?>
							<input type="hidden" data-key="image" class="positive-image-src" 
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][image]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][image]' ?>" value="<?php echo $slide['image'] ?>">
						</p>
						<p class="color-fields"><label><?php _e( 'Background color', 'siteorigin-panels' ) ?></label>
							<span><input type="text" data-key="bgcolor"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][bgcolor]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][bgcolor]' ?>" value="<?php echo $slide['bgcolor'] ?>">
								<span class="color-selector"></span>
							</span>

							<label><?php _e( 'Text color', 'siteorigin-panels' ) ?></label>
							<span><input type="text" data-key="textcolor"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][textcolor]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][textcolor]' ?>" value="<?php echo $slide['textcolor'] ?>">
								<span class="color-selector"></span>
							</span>
							<small><?php _e('Leave blank for transparent background color or default color text.','siteorigin-panels') ?></small>
						</p>
						<p>
							<label><?php _e( 'Title', 'siteorigin-panels' ) ?></label>
							<input type="text" data-key="title" class="widefat"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][title]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][title]' ?>" value="<?php echo $slide['title'] ?>">
						</p>
						<p>
							<label><?php _e( 'Text', 'siteorigin-panels' ) ?></label>
							<textarea data-key="text" class="widefat"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][text]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][text]' ?>"><?php echo $slide['text'] ?></textarea>
						</p>
					</div>
				</div>
			<?php } ?>

		</div>
	<?php
	}
}

/* **********************
 * POST CONTENT
 */
class Positive_Panels_Widget_PostContent extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-post-content',
			__( 'Post Content (PB)', 'siteorigin-panels' ),
			array(
				'description' => __( 'Displays some form of post content form the current post.', 'siteorigin-panels' ),
			)
		);
	}

	function widget( $args, $instance ) {
		if( is_admin() ) return;

		echo $args['before_widget'];
		$content = apply_filters('siteorigin_panels_widget_post_content', $this->default_content($instance['type']));
		echo $content;
		echo $args['after_widget'];
	}

	/**
	 * The default content for post types
	 * @param $type
	 * @return string
	 */
	function default_content($type){
		global $post;
		if(empty($post)) return;

		switch($type) {
			case 'title' :
				return '<h1 class="entry-title">' . $post->post_title . '</h1>';
			case 'content' :
				return '<div class="entry-content">' . wpautop($post->post_content) . '</div>';
			case 'featured' :
				if(!has_post_thumbnail()) return '';
				return '<div class="featured-image">' . get_the_post_thumbnail($post->ID) . '</div>';
			default :
				return '';
		}
	}

	function update($new, $old){
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'type' => 'content',
		));

		$types = apply_filters('siteorigin_panels_widget_post_content_types', array(
			'' => __('None', 'siteorigin-panels'),
			'title' => __('Title', 'siteorigin-panels'),
			'featured' => __('Featured Image', 'siteorigin-panels'),
		));

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ) ?>"><?php _e( 'Display Content', 'siteorigin-panels' ) ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ) ?>" name="<?php echo $this->get_field_name( 'type' ) ?>">
				<?php foreach ($types as $type_id => $title) : ?>
					<option value="<?php echo esc_attr($type_id) ?>" <?php selected($type_id, $instance['type']) ?>><?php echo esc_html($title) ?></option>
				<?php endforeach ?>
			</select>
		</p>
	<?php
	}
}


/* **********************
 * LOOP POSTS
 */
class SiteOrigin_Panels_Widgets_PostLoop extends WP_Widget{
	function __construct() {
		parent::__construct(
			'siteorigin-panels-postloop',
			__( 'Post Loop (PB)', 'siteorigin-panels' ),
			array(
				'description' => __( 'Displays a post loop.', 'siteorigin-panels' ),
			)
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		if( empty( $instance['template'] ) ) return;
		if( is_admin() ) return;

		$template = $instance['template'];
		$query_args = $instance;
		unset($query_args['template']);
		unset($query_args['additional']);
		unset($query_args['sticky']);
		unset($query_args['title']);

		$query_args = wp_parse_args($instance['additional'], $query_args);

		global $wp_rewrite;

		if( $wp_rewrite->using_permalinks() ) {

			if( get_query_var('paged') ) {
				// When the widget appears on a sub page.
				$query_args['paged'] = get_query_var('paged');
			}
			elseif( strpos( $_SERVER['REQUEST_URI'], '/page/' ) !== false ) {
				// When the widget appears on the home page.
				preg_match('/\/page\/([0-9]+)\//', $_SERVER['REQUEST_URI'], $matches);
				if(!empty($matches[1])) $query_args['paged'] = intval($matches[1]);
				else $query_args['paged'] = 1;
			}
			else $query_args['paged'] = 1;
		}
		else {
			// Get current page number when we're not using permalinks
			$query_args['paged'] = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
		}

		switch($instance['sticky']){
			case 'ignore' :
				$query_args['ignore_sticky_posts'] = 1;
				break;
			case 'only' :
				$query_args['post__in'] = get_option( 'sticky_posts' );
				break;
			case 'exclude' :
				$query_args['post__not_in'] = get_option( 'sticky_posts' );
				break;
		}

		// Exclude the current post to prevent possible infinite loop

		global $siteorigin_panels_current_post;

		if( !empty($siteorigin_panels_current_post) ){

			if(!empty($query_args['post__not_in'])){
				$query_args['post__not_in'][] = $siteorigin_panels_current_post;
			}
			else {
				$query_args['post__not_in'] = array( $siteorigin_panels_current_post );
			}

		}

		// Create the query
		query_posts($query_args);
		echo $args['before_widget'];

		// Filter the title
		$instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}

		if(strpos('/'.$instance['template'], '/content') !== false) {
			while(have_posts()) {
				the_post();
				locate_template($instance['template'], true, false);
			}
		}
		else {
			locate_template($instance['template'], true, false);
		}

		echo $args['after_widget'];

		// Reset everything
		wp_reset_query();
	}

	/**
	 * Update the widget
	 *
	 * @param array $new
	 * @param array $old
	 * @return array
	 */
	function update($new, $old){
		return $new;
	}

	/**
	 * Get all the existing files
	 *
	 * @return array
	 */
	function get_loop_templates(){
		$templates = array();

		$template_files = array(
			'loop*.php',
			'*/loop*.php',
			'content*.php',
			'*/content*.php',
		);

		$template_dirs = array(get_template_directory(), get_stylesheet_directory());
		$template_dirs = array_unique($template_dirs);
		foreach($template_dirs  as $dir ){
			foreach($template_files as $template_file) {
				foreach((array) glob($dir.'/'.$template_file) as $file) {
					if( file_exists( $file ) ) $templates[] = str_replace($dir.'/', '', $file);
				}
			}
		}

		$templates = array_unique($templates);
		sort($templates);

		return $templates;
	}

	/**
	 * Display the form for the post loop.
	 *
	 * @param array $instance
	 * @return string|void
	 */
	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'title' => '',
			'template' => 'loop.php',

			// Query args
			'post_type' => 'post',
			'posts_per_page' => '',

			'order' => 'DESC',
			'orderby' => 'date',

			'sticky' => '',

			'additional' => '',
		));

		$templates = $this->get_loop_templates();
		if( empty($templates) ) {
			?><p><?php _e("Your theme doesn't have any post loops.", 'siteorigin-panels') ?></p><?php
			return;
		}

		// Get all the loop template files
		$post_types = get_post_types(array('public' => true));
		$post_types = array_values($post_types);
		$post_types = array_diff($post_types, array('attachment', 'revision', 'nav_menu_item'));

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title', 'siteorigin-panels' ) ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $instance['title'] ) ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('template') ?>"><?php _e('Template', 'siteorigin-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'template' ) ?>" name="<?php echo $this->get_field_name( 'template' ) ?>">
				<?php foreach($templates as $template) : ?>
					<option value="<?php echo esc_attr($template) ?>" <?php selected($instance['template'], $template) ?>>
						<?php
						$headers = get_file_data( locate_template($template), array(
							'loop_name' => 'Loop Name',
						) );
						echo esc_html(!empty($headers['loop_name']) ? $headers['loop_name'] : $template);
						?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post_type') ?>"><?php _e('Post Type', 'siteorigin-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'post_type' ) ?>" name="<?php echo $this->get_field_name( 'post_type' ) ?>" value="<?php echo esc_attr($instance['post_type']) ?>">
				<?php foreach($post_types as $type) : ?>
					<option value="<?php echo esc_attr($type) ?>" <?php selected($instance['post_type'], $type) ?>><?php echo esc_html($type) ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts_per_page') ?>"><?php _e('Posts Per Page', 'siteorigin-panels') ?></label>
			<input type="text" class="small-text" id="<?php echo $this->get_field_id( 'posts_per_page' ) ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" value="<?php echo esc_attr($instance['posts_per_page']) ?>" />
		</p>

		<p>
			<label <?php echo $this->get_field_id('orderby') ?>><?php _e('Order By', 'siteorigin-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'orderby' ) ?>" name="<?php echo $this->get_field_name( 'orderby' ) ?>" value="<?php echo esc_attr($instance['orderby']) ?>">
				<option value="none" <?php selected($instance['orderby'], 'none') ?>><?php esc_html_e('None', 'siteorigin-panels') ?></option>
				<option value="ID" <?php selected($instance['orderby'], 'ID') ?>><?php esc_html_e('Post ID', 'siteorigin-panels') ?></option>
				<option value="author" <?php selected($instance['orderby'], 'author') ?>><?php esc_html_e('Author', 'siteorigin-panels') ?></option>
				<option value="name" <?php selected($instance['orderby'], 'name') ?>><?php esc_html_e('Name', 'siteorigin-panels') ?></option>
				<option value="name" <?php selected($instance['orderby'], 'name') ?>><?php esc_html_e('Name', 'siteorigin-panels') ?></option>
				<option value="date" <?php selected($instance['orderby'], 'date') ?>><?php esc_html_e('Date', 'siteorigin-panels') ?></option>
				<option value="modified" <?php selected($instance['orderby'], 'modified') ?>><?php esc_html_e('Modified', 'siteorigin-panels') ?></option>
				<option value="parent" <?php selected($instance['orderby'], 'parent') ?>><?php esc_html_e('Parent', 'siteorigin-panels') ?></option>
				<option value="rand" <?php selected($instance['orderby'], 'rand') ?>><?php esc_html_e('Random', 'siteorigin-panels') ?></option>
				<option value="comment_count" <?php selected($instance['orderby'], 'comment_count') ?>><?php esc_html_e('Comment Count', 'siteorigin-panels') ?></option>
				<option value="menu_order" <?php selected($instance['orderby'], 'menu_order') ?>><?php esc_html_e('Menu Order', 'siteorigin-panels') ?></option>
				<option value="menu_order" <?php selected($instance['orderby'], 'menu_order') ?>><?php esc_html_e('Menu Order', 'siteorigin-panels') ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('order') ?>"><?php _e('Order', 'siteorigin-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'order' ) ?>" name="<?php echo $this->get_field_name( 'order' ) ?>" value="<?php echo esc_attr($instance['order']) ?>">
				<option value="DESC" <?php selected($instance['order'], 'DESC') ?>><?php esc_html_e('Descending', 'siteorigin-panels') ?></option>
				<option value="ASC" <?php selected($instance['order'], 'ASC') ?>><?php esc_html_e('Ascending', 'siteorigin-panels') ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('sticky') ?>"><?php _e('Sticky Posts', 'siteorigin-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'sticky' ) ?>" name="<?php echo $this->get_field_name( 'sticky' ) ?>" value="<?php echo esc_attr($instance['sticky']) ?>">
				<option value="" <?php selected($instance['sticky'], '') ?>><?php esc_html_e('Default', 'siteorigin-panels') ?></option>
				<option value="ignore" <?php selected($instance['sticky'], 'ignore') ?>><?php esc_html_e('Ignore Sticky', 'siteorigin-panels') ?></option>
				<option value="exclude" <?php selected($instance['sticky'], 'exclude') ?>><?php esc_html_e('Exclude Sticky', 'siteorigin-panels') ?></option>
				<option value="only" <?php selected($instance['sticky'], 'only') ?>><?php esc_html_e('Only Sticky', 'siteorigin-panels') ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('additional') ?>"><?php _e('Additional ', 'siteorigin-panels') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'additional' ) ?>" name="<?php echo $this->get_field_name( 'additional' ) ?>" value="<?php echo esc_attr($instance['additional']) ?>" />
			<small><?php printf(__('Additional query arguments. See <a href="%s" target="_blank">query_posts</a>.', 'siteorigin-panels'), 'http://codex.wordpress.org/Function_Reference/query_posts') ?></small>
		</p>
	<?php
	}
}

/* **********************
 * VIDEO (embeded)
 */
class Positive_Panels_Widget_Video extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-video',
			__( 'Video (Positive)', 'siteorigin-panels' ),
			array(
				'description' => __( 'Embeds a video.', 'siteorigin-panels' ),
			)
		);
	}

	/**
	 * Display the video using
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		$embed = new WP_Embed();

		if(!wp_script_is('fitvids'))
			wp_enqueue_script('fitvids', POSITIVE_PANELS_URL.'widgets/js/jquery.fitvids.min.js', array('jquery'), POSITIVE_PANELS_VERSION);

		if(!wp_script_is('siteorigin-panels-embedded-video'))
			wp_enqueue_script('siteorigin-panels-embedded-video', POSITIVE_PANELS_URL.'widgets/js/embedded-video.min.js', array('jquery', 'fitvids'), POSITIVE_PANELS_VERSION);

		echo $args['before_widget'];
		?><div class="siteorigin-fitvids"><?php echo $embed->run_shortcode( '[embed]' . $instance['video'] . '[/embed]' ) ?></div><?php
		echo $args['after_widget'];
	}

	/**
	 * Display the embedded video form.
	 *
	 * @param array $instance
	 * @return string|void
	 */
	function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'video' => '',
		) )

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'video' ) ?>"><?php _e( 'Video', 'siteorigin-panels' ) ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'video' ) ?>" id="<?php echo $this->get_field_id( 'video' ) ?>" value="<?php echo esc_attr( $instance['video'] ) ?>" />
		</p>
		<?php // Pensar si metemos una imagen tambien, asi se podria parecer al diseño ?>
	<?php
	}

	function update( $new, $old ) {
		$new['video'] = str_replace( 'https://', 'http://', $new['video'] );
		return $new;
	}
}

/* **********************
 * VIDEO HTML5 (self hosted)
 */
class Positive_Panels_Widget_VideoHtml5 extends WP_Widget {
	function __construct() {
		parent::__construct(
			'siteorigin-panels-video',
			__( 'Self Hosted Video (PB)', 'siteorigin-panels' ),
			array(
				'description' => __( 'A self hosted video player.', 'siteorigin-panels' ),
			)
		);
	}

	function widget( $args, $instance ) {
		if (empty($instance['url'])) return;
		static $video_widget_id = 1;

		$instance = wp_parse_args($instance, array(
			'url' => '',
			'poster' => '',
			'skin' => 'siteorigin',
			'ratio' => 1.777,
			'autoplay' => false,
		));

		// Enqueue jPlayer scripts and intializer
		wp_enqueue_script( 'siteorigin-panels-video-jplayer', POSITIVE_PANELS_URL.'video/jplayer/jquery.jplayer.min.min.js', array('jquery'), POSITIVE_PANELS_VERSION, true);
		wp_enqueue_script( 'siteorigin-panels-video', POSITIVE_PANELS_URL.'video/panels.video.jquery.min.js', array('jquery'), POSITIVE_PANELS_VERSION, true);

		// Enqueue the SiteOrigin jPlayer skin
		$skin = sanitize_file_name($instance['skin']);
		wp_enqueue_style('siteorigin-panels-video-jplayer-skin', POSITIVE_PANELS_URL.'video/jplayer/skins/'.$skin.'/jplayer.'.$skin.'.css', array(), POSITIVE_PANELS_VERSION);

		$file = $instance['url'];
		$poster = !empty($instance['poster']) ? $instance['poster'] :  POSITIVE_PANELS_URL.'video/poster.jpg';
		$instance['ratio'] = floatval($instance['ratio']);
		if(empty($instance['ratio'])) $instance['ratio'] = 1.777;

		echo $args['before_widget'];

		?>
		<div class="jp-video" id="jp_container_<?php echo $video_widget_id ?>">
			<div class="jp-type-single" id="jp_interface_<?php echo $video_widget_id ?>">
				<div id="jquery_jplayer_<?php echo $video_widget_id ?>" class="jp-jplayer"
				     data-video="<?php echo esc_url($file) ?>"
				     data-poster="<?php echo esc_url($poster) ?>"
				     data-ratio="<?php echo floatval($instance['ratio']) ?>"
				     data-autoplay="<?php echo esc_attr($instance['autoplay']) ?>"
				     data-swfpath="<?php echo POSITIVE_PANELS_URL.'video/jplayer/' ?>"
				     data-mobile="<?php echo wp_is_mobile() ? 'true' : 'false' ?>"></div>

				<?php $this->display_gui($instance['skin']) ?>
			</div>
		</div>
		<?php

		$video_widget_id++;
		echo $args['after_widget'];
	}

	function display_gui($skin){
		$file = POSITIVE_PANELS_URL.'video/jplayer/skins/'.$skin.'/gui.php';
		if(file_exists($file)) include '../video/jplayer/skins/'.$skin.'/gui.php';
	}

	function update( $new, $old ) {
		$new['skin'] = sanitize_file_name($new['skin']);
		$new['ratio'] = floatval($new['ratio']);
		$new['autoplay'] = !empty($new['autoplay']) ? 1 : 0;
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'url' => '',
			'poster' => '',
			'skin' => 'siteorigin',
			'ratio' => 1.777,
			'autoplay' => false,
		));

		?>
		<p>
			<label for="<?php echo $this->get_field_id('url') ?>"><?php _e('Video URL', 'siteorigin-panels') ?></label>
			<input id="<?php echo $this->get_field_id('url') ?>" name="<?php echo $this->get_field_name('url') ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['url']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('poster') ?>"><?php _e('Poster URL', 'siteorigin-panels') ?></label>
			<input id="<?php echo $this->get_field_id('poster') ?>" name="<?php echo $this->get_field_name('poster') ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['poster']) ?>" />
			<small class="description"><?php _e('An image that displays before the video starts playing.', 'siteorigin-panels') ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('skin') ?>"><?php _e('Skin', 'siteorigin-panels') ?></label>
			<select id="<?php echo $this->get_field_id('skin') ?>" name="<?php echo $this->get_field_name('skin') ?>">
				<option value="siteorigin" <?php selected($instance['skin'], 'siteorigin') ?>><?php esc_html_e('SiteOrigin', 'siteorigin-panels') ?></option>
				<option value="premium" <?php selected($instance['skin'], 'premium') ?>><?php esc_html_e('Premium Pixels', 'siteorigin-panels') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('ratio') ?>"><?php _e('Aspect Ratio', 'siteorigin-panels') ?></label>
			<input id="<?php echo $this->get_field_id('ratio') ?>" name="<?php echo $this->get_field_name('ratio') ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['ratio']) ?>" />
			<small class="description"><?php _e('1.777 is HD standard.', 'siteorigin-panels') ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('autoplay') ?>">
				<input id="<?php echo $this->get_field_id('autoplay') ?>" name="<?php echo $this->get_field_name('autoplay') ?>" type="checkbox" value="1" />
				<?php _e('Auto Play Video', 'siteorigin-panels') ?>
			</label>
		</p>
		<?php
	}
}

/**
 * A shortcode for self hosted video.
 *
 * @param array $atts
 * @return string
 */
function siteorigin_panels_video_shortcode($atts){
	/**
	 * @var string $url
	 * @var string $poster
	 * @var string $skin
	 */
	$instance = shortcode_atts( array(
		'url' => '',
		'src' => '',
		'poster' => POSITIVE_PANELS_URL.'video/poster.jpg',
		'skin' => 'siteorigin',
		'ratio' => 1.777,
		'autoplay' => 0,
	), $atts );

	if(!empty($instance['src'])) $instance['url'] = $instance['src'];
	if(empty($instance['url'])) return;

	ob_start();
	the_widget('SiteOrigin_Panels_Widgets_Video', $instance);
	return ob_get_clean();

}
add_shortcode('self_video', 'siteorigin_panels_video_shortcode');


/**
 * Register the widgets.
 */
function positive_panels_basic_widgets(){
	register_widget('Positive_Panels_Widget_Heading');
	register_widget('Positive_Panels_Widget_Button');
	register_widget('Positive_Panels_Widget_Image');
	register_widget('Positive_Panels_Widget_Slider');
	register_widget('Positive_Panels_Widget_PostContent');
	//register_widget('SiteOrigin_Panels_Widgets_PostLoop');
	register_widget('Positive_Panels_Widget_Video');
	//register_widget('Positive_Panels_Widget_VideoHtml5');
	
}
add_action('widgets_init', 'positive_panels_basic_widgets');

/**
 * Enqueue widget compatibility files.
 */
function siteorigin_panels_comatibility_init(){
	if(is_plugin_active('black-studio-tinymce-widget/black-studio-tinymce-widget.php')){
		include 'compat/black-studio-tinymce/black-studio-tinymce.php';
	}
}
add_action('admin_init', 'siteorigin_panels_comatibility_init', 5);