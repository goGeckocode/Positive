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
			__( 'Heading (Positive)', 'positive-panels' ),
			array(
				'description' => __( 'Create a custom Heading.', 'positive-panels' ),
			)
		);
	}

	function widget( $args, $instance ) {
		// align attribute is used on before_widget
		echo $args['before_widget'];
		if($instance['heading']=='h2'){ echo '<div class="heading-content">';}
		echo '<'.$instance['heading'].'>'.$instance['title'].'</'.$instance['heading'].'>';
		if($instance['subheading']){
			echo '<p class="subheading"><em>'.$instance['subheading'].'</em></p>';
		}
		if($instance['heading']=='h2'){echo '</div>';}
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'title' => '',
			'heading' => '',
			'align' => '',
			'subHeading' => ''
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'title' => '',
			'heading' => '',
			'align' => '',
			'subheading' => ''
		));

		?>
		<?php // Title ?>
		<p><input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr($instance['title']) ?>" /></p>
		<?php // Heading ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'heading' ) ?>"><?php _e( 'Heading level', 'positive-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'heading' ) ?>" id="<?php echo $this->get_field_id( 'heading' ) ?>">
				<?php /*<option value="h1" <?php selected(empty($instance['heading'])) ?>>H1</option>*/ ?>
				<option value="h2" <?php selected(empty($instance['heading'])) ?>>H2</option>
				<option value="h3" <?php selected('h3', $instance['heading']) ?>>H3</option>
			</select>
		</p>
		<?php // Align ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'align' ) ?>"><?php _e( 'Heading Align', 'positive-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'align' ) ?>" id="<?php echo $this->get_field_id( 'align' ) ?>">
				<option value="align-left" <?php selected(empty($instance['align'])) ?>><?php _e( 'Left', 'positive-panels' ) ?></option>
				<option value="align-right" <?php selected('align-right', $instance['align']) ?>><?php _e( 'Right', 'positive-panels' ) ?></option>
				<option value="align-center" <?php selected('align-center', $instance['align']) ?>><?php _e( 'Center', 'positive-panels' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'subheading' ) ?>"><?php _e( 'Sub Heading', 'positive-panels' ) ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('subheading') ?>" name="<?php echo $this->get_field_name( 'subheading' ) ?>"><?php echo esc_attr($instance['subheading']) ?></textarea>
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
			__( 'Button (Positive)', 'positive-panels' ),
			array(
				'description' => __( 'A simple button.', 'positive-panels' ),
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
			<label><?php _e( 'Button text', 'positive-panels' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'text' ) ?>" name="<?php echo $this->get_field_name( 'text' ) ?>" value="<?php echo esc_attr($instance['text']) ?>" /></p>
		<!-- link -->
		<p>
			<label><?php _e( 'Button url', 'positive-panels' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link' ) ?>" name="<?php echo $this->get_field_name( 'link' ) ?>" value="<?php echo esc_attr($instance['link']) ?>" /></p>
		<!-- open -->
		<p>
			<label for="<?php echo $this->get_field_id( 'open' ) ?>"><?php _e( 'Open Link in new Window?', 'positive-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'open' ) ?>" id="<?php echo $this->get_field_id( 'open' ) ?>">
				<option value="" <?php selected(empty($instance['open'])) ?>><?php esc_html_e( 'No, in the same window', 'positive-panels' ) ?></option>
				<option value="_blank" <?php selected('Yes, in new window', $instance['open']) ?>><?php esc_html_e( 'Yes, in new window', 'positive-panels' ) ?></option>
			</select>
		</p>
		<!-- Align -->
		<p>
			<label for="<?php echo $this->get_field_id( 'align' ) ?>"><?php _e( 'Button Align', 'positive-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'align' ) ?>" id="<?php echo $this->get_field_id( 'align' ) ?>">
				<option value="left" <?php selected(empty($instance['align'])) ?>><?php esc_html_e( 'Left', 'positive-panels' ) ?></option>
				<option value="right" <?php selected('right', $instance['align']) ?>><?php esc_html_e( 'Right', 'positive-panels' ) ?></option>
				<option value="center" <?php selected('center', $instance['align']) ?>><?php esc_html_e( 'Center', 'positive-panels' ) ?></option>
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
			__( 'Image (Positive)', 'positive-panels' ),
			array(
				'description' => __( 'Displays a simple image.', 'positive-panels' ),
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
			<label><?php _e( 'Image', 'positive-panels' ) ?></label>
			<span class="thumbnail">
				<?php if($instance['id'] !='') echo wp_get_attachment_image( $instance['id']); ?>
			</span>
			<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','positive-panels');?>">
			<input type="hidden" class="positive-image-src" id="<?php echo $this->get_field_id( 'src' ) ?>" name="<?php echo $this->get_field_name( 'src' ) ?>" value="<?php echo esc_attr($instance['src']) ?>">
			<input type="hidden" class="positive-image-id" id="<?php echo $this->get_field_id( 'id' ) ?>" name="<?php echo $this->get_field_name( 'id' ) ?>" value="<?php echo esc_attr($instance['id']) ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ) ?>"><?php _e( 'Image Size', 'positive-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'size' ) ?>" id="<?php echo $this->get_field_id( 'size' ) ?>">
				<option value="full" <?php selected('full', $instance['size']) ?>><?php esc_html_e( 'Full', 'positive-panels' ) ?></option>
				<option value="large" <?php selected('large', $instance['size']) ?>><?php esc_html_e( 'Large', 'positive-panels' ) ?></option>
				<option value="medium" <?php selected('medium', $instance['size']) ?>><?php esc_html_e( 'Medium', 'positive-panels' ) ?></option>
				<option value="thumbnail" <?php selected('thumbnail', $instance['size']) ?>><?php esc_html_e( 'Thumbnail', 'positive-panels' ) ?></option>
				<option value="background" <?php selected('background', $instance['size']) ?>><?php esc_html_e( 'Background', 'positive-panels' ) ?></option>
			</select>
			<p><small><?php _e('In the "background" choice the image will resize to fit all the area, some parts of the image wouldn\'t show','positive-panels'); ?></small></p>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'href' ) ?>"><?php _e( 'Destination URL', 'positive-panels' ) ?></label>
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
			__( 'Slider (Positive)', 'positive-panels' ),
			array(
				'description' => __( 'Inserts a content or image slider.', 'positive-panels' ),
			)
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		if(!wp_script_is('cycle2'))
			wp_enqueue_script('cycle2', POSITIVE_PANELS_URL.'widgets/js/jquery.cycle2.min.js', array('jquery'), '2.1.2');

		$autoplay = ($instance['autoplay'] == 1 ? 0 : 6000);

		echo $args['before_widget'];
		echo '<div class="cycle-slideshow"
				data-cycle-loader="wait"
				data-cycle-swipe=true
				data-cycle-prev="#prev" 
				data-cycle-next="#next" 
				data-cycle-fx="'.$instance['effect'].'"
				data-cycle-timeout="'.$autoplay.'"
				data-cycle-slides="> div"
				data-pager="#slider-pager"
				data-pager-template="<span></span>"
			>';
		foreach ($instance['slides'] as $slide) {
			$layerstyle = '';
			if (!empty($slide['bgcolor']) || !empty($slide['textcolor']) ) {
				$layerstyle = ' style="';
				$layerstyle .= (empty($slide['bgcolor']) ? '' : 'background-color:'.$slide['bgcolor'].';' );
				$layerstyle .= (empty($slide['textcolor']) ? '' : 'color:'.$slide['textcolor'] );
				$layerstyle .= '"';
			}

			echo '<div'.$layerstyle.'>';
			if(! empty($slide['image']) ){
				echo '<img src="'.$slide['image'].'">';
			}
			// slide content
			if(!empty($slide['title']) || !empty($slide['text']) || !empty($slide['buttontext']) ) {
				echo '<div class="panel '.$slide['align'].'">';
				if( !empty($slide['title']) ) echo '<h2>'.$slide['title'].'</h2>';
				if( !empty($slide['text']) ) echo '<p>'.$slide['text'].'</p>'; // apply_filters falla
				if( !empty($slide['buttontext']) ) echo '<a href="'.$slide['buttonurl'].'" class="btn">'.$slide['buttontext'].'</a>';
				echo '</div>';
			}
			echo '</div>';
		}
		echo '</div><!-- cycle-slideshow -->';
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'effect' => '',
			'autoplay' => '',
			'slides' => array()
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'effect' => '',
			'autoplay' => '',
			'slides' => array(0 => array())
		));

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'effect' ) ?>"><?php _e( 'Transition effect', 'positive-panels' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'effect' ) ?>" id="<?php echo $this->get_field_id( 'effect' ) ?>">
				<option value="fade" <?php selected('fade', $instance['effect']) ?>><?php esc_html_e( 'Fade', 'positive-panels' ) ?></option>
				<option value="scrollHorz" <?php selected('horizontal', $instance['effect']) ?>><?php esc_html_e( 'Horizontal slide', 'positive-panels' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('autoplay') ?>">
				<input type="checkbox" 
					id="<?php echo $this->get_field_id('autoplay'); ?>" 
					name="<?php echo $this->get_field_name( 'autoplay' ); ?>" 
					value="1">
				<?php _e( 'Check for auto play slider', 'positive-panels' ) ?></label>
		</p>

		<?php // cloneable fields for each slide ?>
		<h3><?php _e('Slides','positive-panels'); ?></h3>
		<div class="cloneable-fields" data-name="<?php echo $this->get_field_name( 'slides' ); ?>" data-id="<?php echo $this->get_field_id( 'slides' ); ?>">
			<?php foreach($instance['slides'] as $i => $slide){ ?>
				<div class="fields slide-fields">
					<h4 class="slide-fields-header toggle-collapse">
						<span class="thumbnail">
							<?php if($slide['image'] != '') echo '<img src="'.$slide['image'].'">'; ?>
						</span>
						<strong>
							<?php if($slide['title'] != '') echo $slide['title'];
							else echo __('Slide').' '.($i+1); ?>
						</strong>
					</h4>
					<div class="collapsible">
						<?php // IMAGE ?>
						<p class="image-fields">
							<label><?php _e( 'Image', 'positive-panels' ) ?></label>
							<span class="thumbnail">
								<?php if($slide['image'] !='') echo '<img src="'.$slide['image'].'">' ?>
							</span>
							<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','positive-panels');?>">
							<?php // en el caso del slider no necesitamos ID 
								// porque pintamos la imagen a tamaño completo ?>
							<input type="hidden" data-key="image" class="positive-image-src" 
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][image]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][image]' ?>" value="<?php echo $slide['image'] ?>">
							<input type="button" class="positive-panels-removeimage" value="<?php _e('Remove image','positive-panels');?>">
						</p>
						<?php // COLOR ?>
						<p class="color-fields"><label><?php _e( 'Background color', 'positive-panels' ) ?></label>
							<span><input type="text" data-key="bgcolor"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][bgcolor]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][bgcolor]' ?>" value="<?php echo $slide['bgcolor'] ?>">
								<span class="color-selector"></span>
							</span>

							<label><?php _e( 'Text color', 'positive-panels' ) ?></label>
							<span><input type="text" data-key="textcolor"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][textcolor]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][textcolor]' ?>" value="<?php echo $slide['textcolor'] ?>">
								<span class="color-selector"></span>
							</span>
							<br><small><?php _e('Leave blank for transparent background color or default color text.','positive-panels') ?></small>
						</p>
						<?php // CONTENT ?>
						<p><strong><?php _e('Slide content','positive-panels') ?></strong> <small><?php _e('Leave blank if you just want an image slider','positive-panels') ?></small></p>
						<p>
							<label><?php _e( 'Title', 'positive-panels' ) ?></label>
							<input type="text" data-key="title" class="widefat"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][title]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][title]' ?>" value="<?php echo $slide['title'] ?>">
						</p>
						<p>
							<label><?php _e( 'Text', 'positive-panels' ) ?></label>
							<textarea data-key="text" class="widefat"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][text]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][text]' ?>"><?php echo $slide['text'] ?></textarea>
						</p>
						<?php /*<p>
							<label><?php _e( 'Text align', 'positive-panels' ) ?></label>
							<select name="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][align]' ?>" id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][align]' ?>">
								<option value="align-center" <?php selected(empty($instance['slides'][$i]['align'])) ?>><?php esc_html_e( 'Center', 'positive-panels' ) ?></option>
								<option value="align-left" <?php selected('align-left', $instance['slides'][$i]['align']) ?>><?php esc_html_e( 'Left', 'positive-panels' ) ?></option>
								<option value="align-right" <?php selected('align-right', $instance['slides'][$i]['align']) ?>><?php esc_html_e( 'Right', 'positive-panels' ) ?></option>
							</select>
						</p>*/ ?>
						<?php // BUTTON ?>
						<p><strong><?php _e('Do you want to include a button?','positive-panels') ?></strong></p>
						<p><label><?php _e( 'Button text', 'positive-panels' ) ?></label>
							<input type="text" class="widefat" 
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][buttontext]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][buttontext]' ?>" value="<?php echo $slide['buttontext'] ?>" />
						</p>
						<p><label><?php _e( 'Button url', 'positive-panels' ) ?></label>
							<input type="text" class="widefat" 
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][buttonurl]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][buttonurl]' ?>" value="<?php echo $slide['buttonurl'] ?>" />
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
			__( 'Post Content (PB)', 'positive-panels' ),
			array(
				'description' => __( 'Displays some form of post content form the current post.', 'positive-panels' ),
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
			'' => __('None', 'positive-panels'),
			'title' => __('Title', 'positive-panels'),
			'featured' => __('Featured Image', 'positive-panels'),
		));

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ) ?>"><?php _e( 'Display Content', 'positive-panels' ) ?></label>
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
			__( 'Post Loop (PB)', 'positive-panels' ),
			array(
				'description' => __( 'Displays a post loop.', 'positive-panels' ),
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
			?><p><?php _e("Your theme doesn't have any post loops.", 'positive-panels') ?></p><?php
			return;
		}

		// Get all the loop template files
		$post_types = get_post_types(array('public' => true));
		$post_types = array_values($post_types);
		$post_types = array_diff($post_types, array('attachment', 'revision', 'nav_menu_item'));

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title', 'positive-panels' ) ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $instance['title'] ) ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('template') ?>"><?php _e('Template', 'positive-panels') ?></label>
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
			<label for="<?php echo $this->get_field_id('post_type') ?>"><?php _e('Post Type', 'positive-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'post_type' ) ?>" name="<?php echo $this->get_field_name( 'post_type' ) ?>" value="<?php echo esc_attr($instance['post_type']) ?>">
				<?php foreach($post_types as $type) : ?>
					<option value="<?php echo esc_attr($type) ?>" <?php selected($instance['post_type'], $type) ?>><?php echo esc_html($type) ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts_per_page') ?>"><?php _e('Posts Per Page', 'positive-panels') ?></label>
			<input type="text" class="small-text" id="<?php echo $this->get_field_id( 'posts_per_page' ) ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" value="<?php echo esc_attr($instance['posts_per_page']) ?>" />
		</p>

		<p>
			<label <?php echo $this->get_field_id('orderby') ?>><?php _e('Order By', 'positive-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'orderby' ) ?>" name="<?php echo $this->get_field_name( 'orderby' ) ?>" value="<?php echo esc_attr($instance['orderby']) ?>">
				<option value="none" <?php selected($instance['orderby'], 'none') ?>><?php esc_html_e('None', 'positive-panels') ?></option>
				<option value="ID" <?php selected($instance['orderby'], 'ID') ?>><?php esc_html_e('Post ID', 'positive-panels') ?></option>
				<option value="author" <?php selected($instance['orderby'], 'author') ?>><?php esc_html_e('Author', 'positive-panels') ?></option>
				<option value="name" <?php selected($instance['orderby'], 'name') ?>><?php esc_html_e('Name', 'positive-panels') ?></option>
				<option value="name" <?php selected($instance['orderby'], 'name') ?>><?php esc_html_e('Name', 'positive-panels') ?></option>
				<option value="date" <?php selected($instance['orderby'], 'date') ?>><?php esc_html_e('Date', 'positive-panels') ?></option>
				<option value="modified" <?php selected($instance['orderby'], 'modified') ?>><?php esc_html_e('Modified', 'positive-panels') ?></option>
				<option value="parent" <?php selected($instance['orderby'], 'parent') ?>><?php esc_html_e('Parent', 'positive-panels') ?></option>
				<option value="rand" <?php selected($instance['orderby'], 'rand') ?>><?php esc_html_e('Random', 'positive-panels') ?></option>
				<option value="comment_count" <?php selected($instance['orderby'], 'comment_count') ?>><?php esc_html_e('Comment Count', 'positive-panels') ?></option>
				<option value="menu_order" <?php selected($instance['orderby'], 'menu_order') ?>><?php esc_html_e('Menu Order', 'positive-panels') ?></option>
				<option value="menu_order" <?php selected($instance['orderby'], 'menu_order') ?>><?php esc_html_e('Menu Order', 'positive-panels') ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('order') ?>"><?php _e('Order', 'positive-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'order' ) ?>" name="<?php echo $this->get_field_name( 'order' ) ?>" value="<?php echo esc_attr($instance['order']) ?>">
				<option value="DESC" <?php selected($instance['order'], 'DESC') ?>><?php esc_html_e('Descending', 'positive-panels') ?></option>
				<option value="ASC" <?php selected($instance['order'], 'ASC') ?>><?php esc_html_e('Ascending', 'positive-panels') ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('sticky') ?>"><?php _e('Sticky Posts', 'positive-panels') ?></label>
			<select id="<?php echo $this->get_field_id( 'sticky' ) ?>" name="<?php echo $this->get_field_name( 'sticky' ) ?>" value="<?php echo esc_attr($instance['sticky']) ?>">
				<option value="" <?php selected($instance['sticky'], '') ?>><?php esc_html_e('Default', 'positive-panels') ?></option>
				<option value="ignore" <?php selected($instance['sticky'], 'ignore') ?>><?php esc_html_e('Ignore Sticky', 'positive-panels') ?></option>
				<option value="exclude" <?php selected($instance['sticky'], 'exclude') ?>><?php esc_html_e('Exclude Sticky', 'positive-panels') ?></option>
				<option value="only" <?php selected($instance['sticky'], 'only') ?>><?php esc_html_e('Only Sticky', 'positive-panels') ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('additional') ?>"><?php _e('Additional ', 'positive-panels') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'additional' ) ?>" name="<?php echo $this->get_field_name( 'additional' ) ?>" value="<?php echo esc_attr($instance['additional']) ?>" />
			<small><?php printf(__('Additional query arguments. See <a href="%s" target="_blank">query_posts</a>.', 'positive-panels'), 'http://codex.wordpress.org/Function_Reference/query_posts') ?></small>
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
			__( 'Video (Positive)', 'positive-panels' ),
			array(
				'description' => __( 'Embeds a video.', 'positive-panels' ),
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

		//$poster = ( empty($instance['poster']) ? '': ' video-poster" style="background-image:url('.$instance['poster'].')');
		$poster = ( empty($instance['poster']) ? '': ' video-poster');

		echo $args['before_widget'];
		echo '<div class="positive-fitvids'.$poster.'" data-playing="false">';
		echo $embed->run_shortcode( '[embed]' . $instance['video'] . '[/embed]' );
		if(!empty($instance['poster'])) echo '<img src="'.$instance['poster'].'">';
		//<span class="positive-play">Play video</span>';
		echo '</div>';
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
			'poster' => ''
		) )

		?>
		<?php // IMAGE ?>
		<p class="image-fields"><label for="<?php echo $this->get_field_id( 'poster' ) ?>"><?php _e('Image', 'positive-panels' ) ?></label>
			<span class="thumbnail">
				<?php if($instance['poster'] !='') echo '<img src="'.$instance['poster'].'">' ?>
			</span>
			<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','positive-panels');?>">
			<input type="hidden" class="positive-image-src" id="<?php echo $this->get_field_id( 'poster' ) ?>" name="<?php echo $this->get_field_name( 'poster' ) ?>" value="<?php echo $instance['poster'] ?>">
			<input type="button" class="positive-panels-removeimage" value="<?php _e('Remove image','positive-panels');?>">
			<br><small><?php _e('If especified, the image will be displayed while the video is not playing') ?></small>
		</p>
		<p><label for="<?php echo $this->get_field_id( 'video' ) ?>"><?php _e('Video', 'positive-panels' ) ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'video' ) ?>" id="<?php echo $this->get_field_id( 'video' ) ?>" value="<?php echo esc_attr( $instance['video'] ) ?>" />
		</p>

	<?php
	}

	function update( $new, $old ) {
		/*$new['video'] = str_replace( 'https://', 'http://', $new['video'] );
		return $new;*/
		$new = wp_parse_args($new, array(
			'video' => str_replace( 'https://', 'http://', $new['video'] ),
			'poster' => ''
		));
		return $new;
	}
}


/**
 * Register the widgets.
 */
function positive_panels_basic_widgets(){
	register_widget('Positive_Panels_Widget_Heading');
	register_widget('Positive_Panels_Widget_Button');
	register_widget('Positive_Panels_Widget_Image');
	register_widget('Positive_Panels_Widget_Slider');
	register_widget('Positive_Panels_Widget_PostContent');
	register_widget('Positive_Panels_Widget_Video');
	//register_widget('SiteOrigin_Panels_Widgets_PostLoop');
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