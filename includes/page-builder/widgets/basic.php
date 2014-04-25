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
			__( 'Heading (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Create a custom Heading.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		// align attribute is used on before_widget
		echo $args['before_widget'];
		if($instance['subheading']) echo '<div class="heading-in">';
			echo '<'.$instance['heading'].'>'.$instance['title'].'</'.$instance['heading'].'>';
			if($instance['subheading']) echo '<p class="subheading">'.$instance['subheading'].'</p>';
		if($instance['subheading']) echo '</div>';
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'title' => '',
			'heading' => '',
			'align' => '',
			'subheading' => ''
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
			<label for="<?php echo $this->get_field_id( 'heading' ) ?>"><?php _e( 'Heading level', 'positive-backend' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'heading' ) ?>" id="<?php echo $this->get_field_id( 'heading' ) ?>">
				<option value="h2" <?php selected('h2',($instance['heading'])) ?>>H2</option>
				<option value="h3" <?php selected('h3', $instance['heading']) ?>>H3</option>
				<option value="h1" <?php selected('h1', $instance['heading']) ?>><?php _e('H1: Only for main page title') ?></option> ?>
			</select>
		</p>
		<?php // Align ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'align' ) ?>"><?php _e( 'Heading Align', 'positive-backend' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'align' ) ?>" id="<?php echo $this->get_field_id( 'align' ) ?>">
				<option value="align-center" <?php selected(empty($instance['align'])) ?>><?php _e( 'Center', 'positive-backend' ) ?></option>
				<option value="align-right" <?php selected('align-right',$instance['align']) ?>><?php _e( 'Right', 'positive-backend' ) ?></option>
				<option value="align-left" <?php selected('align-left',$instance['align']) ?>><?php _e( 'Left', 'positive-backend' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'subheading' ) ?>"><?php _e( 'Sub Heading', 'positive-backend' ) ?></label>
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
			__( 'Button (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'A simple button.', 'positive-backend' ),
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
			<label><?php _e( 'Button text', 'positive-backend' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'text' ) ?>" name="<?php echo $this->get_field_name( 'text' ) ?>" value="<?php echo esc_attr($instance['text']) ?>" /></p>
		<!-- link -->
		<p>
			<label><?php _e( 'Button url', 'positive-backend' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link' ) ?>" name="<?php echo $this->get_field_name( 'link' ) ?>" value="<?php echo esc_attr($instance['link']) ?>" /></p>
		<!-- open -->
		<p>
			<label for="<?php echo $this->get_field_id( 'open' ) ?>"><?php _e( 'Open Link in new Window?', 'positive-backend' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'open' ) ?>" id="<?php echo $this->get_field_id( 'open' ) ?>">
				<option value="" <?php selected(empty($instance['open'])) ?>><?php esc_html_e( 'No, in the same window', 'positive-backend' ) ?></option>
				<option value="_blank" <?php selected('Yes, in new window', $instance['open']) ?>><?php esc_html_e( 'Yes, in new window', 'positive-backend' ) ?></option>
			</select>
		</p>
		<!-- Align -->
		<p>
			<label for="<?php echo $this->get_field_id( 'align' ) ?>"><?php _e( 'Button Align', 'positive-backend' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'align' ) ?>" id="<?php echo $this->get_field_id( 'align' ) ?>">
				<option value="left" <?php selected(empty($instance['align'])) ?>><?php esc_html_e( 'Left', 'positive-backend' ) ?></option>
				<option value="right" <?php selected('right', $instance['align']) ?>><?php esc_html_e( 'Right', 'positive-backend' ) ?></option>
				<option value="center" <?php selected('center', $instance['align']) ?>><?php esc_html_e( 'Center', 'positive-backend' ) ?></option>
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
			__( 'Image (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Displays a simple image.', 'positive-backend' ),
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
			<label><?php _e( 'Image', 'positive-backend' ) ?></label>
			<span class="thumbnail">
				<?php if($instance['id'] !='') echo wp_get_attachment_image( $instance['id']); ?>
			</span>
			<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','positive-backend');?>">
			<input type="hidden" class="positive-image-src" id="<?php echo $this->get_field_id( 'src' ) ?>" name="<?php echo $this->get_field_name( 'src' ) ?>" value="<?php echo esc_attr($instance['src']) ?>">
			<input type="hidden" class="positive-image-id" id="<?php echo $this->get_field_id( 'id' ) ?>" name="<?php echo $this->get_field_name( 'id' ) ?>" value="<?php echo esc_attr($instance['id']) ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ) ?>"><?php _e( 'Image Size', 'positive-backend' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'size' ) ?>" id="<?php echo $this->get_field_id( 'size' ) ?>">
				<option value="full" <?php selected('full', $instance['size']) ?>><?php esc_html_e( 'Full', 'positive-backend' ) ?></option>
				<option value="large" <?php selected('large', $instance['size']) ?>><?php esc_html_e( 'Large', 'positive-backend' ) ?></option>
				<option value="medium" <?php selected('medium', $instance['size']) ?>><?php esc_html_e( 'Medium', 'positive-backend' ) ?></option>
				<option value="thumbnail" <?php selected('thumbnail', $instance['size']) ?>><?php esc_html_e( 'Thumbnail', 'positive-backend' ) ?></option>
				<option value="background" <?php selected('background', $instance['size']) ?>><?php esc_html_e( 'Background', 'positive-backend' ) ?></option>
			</select>
			<p><small><?php _e('In the "background" choice the image will resize to fit all the area, some parts of the image wouldn\'t show','positive-backend'); ?></small></p>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'href' ) ?>"><?php _e( 'Destination URL', 'positive-backend' ) ?></label>
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
			__( 'Slider (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Inserts a content or image slider.', 'positive-backend' ),
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

		echo '<div class="cycle-slideshow '.$instance['height'].'"
				data-cycle-swipe=true
				data-cycle-prev="#prev" 
				data-cycle-next="#next" 
				data-cycle-fx="'.$instance['effect'].'"
				data-cycle-timeout="'.$autoplay.'"
				data-cycle-slides="> div"
				data-pager="#slider-pager"
				data-pager-template="<span></span>">';
		foreach ($instance['slides'] as $slide) {
			$layerstyle = '';
			if (!empty($slide['bgcolor']) || !empty($slide['textcolor']) || !empty($slide['image']) ) {
				$layerstyle = ' style="';
				if(!empty($slide['image'])) $layerstyle .= 'background-image:url('.$slide['image'].');';
				if(!empty($slide['bgcolor'])) $layerstyle .= 'background-color:'.$slide['bgcolor'].';';
				if(!empty($slide['textcolor'])) $layerstyle .= 'color:'.$slide['textcolor'];
				$layerstyle .= '"';
			}

			echo '<div'.$layerstyle.'>';
			/*if(! empty($slide['image']) ){
				echo '<img src="'.$slide['image'].'">';
			}*/
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
			'height' =>'',
			'slides' => array()
		));
		return $new;
	}

	/**
	 * Array slides
	 *	- image (src)
	 *  - bgcolor (color)
	 *  - textcolor (color)
	 *  - title
	 *  - text
	 *  - buttontext
	 *  - buttonurl (url)
	 */
	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'effect' => '',
			'autoplay' => '',
			'height' =>'',
			'slides' => array(0 => array())
		));

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'effect' ) ?>"><?php _e( 'Transition effect', 'positive-backend' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'effect' ) ?>" id="<?php echo $this->get_field_id( 'effect' ) ?>">
				<option value="fade" <?php selected('fade', $instance['effect']) ?>><?php esc_html_e( 'Fade', 'positive-backend' ) ?></option>
				<option value="scrollHorz" <?php selected('horizontal', $instance['effect']) ?>><?php esc_html_e( 'Horizontal slide', 'positive-backend' ) ?></option>
			</select>
		</p>
		<p><label for="<?php echo $this->get_field_id( 'height' ) ?>"><?php _e( 'choose height for slider', 'positive-backend' ) ?></label>
			<select name="<?php echo $this->get_field_name( 'height' ) ?>" id="<?php echo $this->get_field_id( 'height' ) ?>">
				<option value="big" <?php selected('big', $instance['height']) ?>><?php esc_html_e( 'Big', 'positive-backend' ) ?></option>
				<option value="small" <?php selected('small', $instance['height']) ?>><?php esc_html_e( 'small', 'positive-backend' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('autoplay') ?>">
				<input type="checkbox" 
					id="<?php echo $this->get_field_id('autoplay'); ?>" 
					name="<?php echo $this->get_field_name( 'autoplay' ); ?>" 
					value="1">
				<?php _e( 'Check for auto play slider', 'positive-backend' ) ?></label>
		</p>

		<?php // cloneable fields for each slide ?>
		<h3><?php _e('Slides','positive-backend'); ?></h3>
		<div class="cloneable-fields" data-name="<?php echo $this->get_field_name( 'slides' ); ?>" data-id="<?php echo $this->get_field_id( 'slides' ); ?>">
			<?php foreach($instance['slides'] as $i => $slide){ ?>
				<div class="fields slide-fields">
					<h4 class="slide-fields-header toggle-collapse">
						<span class="thumbnail">
							<?php if($slide['image'] != '') echo '<img src="'.$slide['image'].'">'; ?>
						</span>
						<strong>
							<?php if($slide['title'] != '') echo $slide['title'];
							else echo 'Slide '.($i+1); ?>
						</strong>
					</h4>
					<div class="collapsible">
						<?php // IMAGE ?>
						<p class="image-fields">
							<label><?php _e( 'Image', 'positive-backend' ) ?></label>
							<span class="thumbnail">
								<?php if($slide['image'] !='') echo '<img src="'.$slide['image'].'">' ?>
							</span>
							<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','positive-backend');?>">
							<?php // en el caso del slider no necesitamos ID 
								// porque pintamos la imagen a tamaño completo ?>
							<input type="hidden" data-key="image" class="positive-image-src" 
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][image]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][image]' ?>" value="<?php echo $slide['image'] ?>">
							<input type="button" class="positive-panels-removeimage" value="<?php _e('Remove image','positive-backend');?>">
						</p>
						<?php // COLOR ?>
						<p class="color-fields"><label><?php _e( 'Background color', 'positive-backend' ) ?></label>
							<span><input type="text" data-key="bgcolor"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][bgcolor]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][bgcolor]' ?>" value="<?php echo $slide['bgcolor'] ?>">
								<span class="color-selector"></span>
							</span>

							<label><?php _e( 'Text color', 'positive-backend' ) ?></label>
							<span><input type="text" data-key="textcolor"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][textcolor]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][textcolor]' ?>" value="<?php echo $slide['textcolor'] ?>">
								<span class="color-selector"></span>
							</span>
							<br><small><?php _e('Leave blank for transparent background color or default color text.','positive-backend') ?></small>
						</p>
						<?php // CONTENT ?>
						<p><strong><?php _e('Slide content','positive-backend') ?></strong> <small><?php _e('Leave blank if you just want an image slider','positive-backend') ?></small></p>
						<p>
							<label><?php _e( 'Title', 'positive-backend' ) ?></label>
							<input type="text" data-key="title" class="widefat"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][title]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][title]' ?>" value="<?php echo $slide['title'] ?>">
						</p>
						<p>
							<label><?php _e( 'Text', 'positive-backend' ) ?></label>
							<textarea data-key="text" class="widefat"
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][text]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][text]' ?>"><?php echo $slide['text'] ?></textarea>
						</p>
						<?php /*<p>
							<label><?php _e( 'Text align', 'positive-backend' ) ?></label>
							<select name="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][align]' ?>" id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][align]' ?>">
								<option value="align-center" <?php selected(empty($instance['slides'][$i]['align'])) ?>><?php esc_html_e( 'Center', 'positive-backend' ) ?></option>
								<option value="align-left" <?php selected('align-left', $instance['slides'][$i]['align']) ?>><?php esc_html_e( 'Left', 'positive-backend' ) ?></option>
								<option value="align-right" <?php selected('align-right', $instance['slides'][$i]['align']) ?>><?php esc_html_e( 'Right', 'positive-backend' ) ?></option>
							</select>
						</p>*/ ?>
						<?php // BUTTON ?>
						<p><strong><?php _e('Do you want to include a button?','positive-backend') ?></strong></p>
						<p><label><?php _e( 'Button text', 'positive-backend' ) ?></label>
							<input type="text" class="widefat" 
								id="<?php echo $this->get_field_id( 'slides' ).'['.$i.'][buttontext]' ?>" 
								name="<?php echo $this->get_field_name( 'slides' ).'['.$i.'][buttontext]' ?>" value="<?php echo $slide['buttontext'] ?>" />
						</p>
						<p><label><?php _e( 'Button url', 'positive-backend' ) ?></label>
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
 * VIDEO (embeded)
 */
class Positive_Panels_Widget_Video extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-video',
			__( 'Video (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Embeds a video.', 'positive-backend' ),
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
		//$embed = new WP_Embed();

		if(!wp_script_is('fitvids'))
			wp_enqueue_script('fitvids', POSITIVE_PANELS_URL.'widgets/js/jquery.fitvids.min.js', array('jquery'), POSITIVE_PANELS_VERSION);

		$embed_code = wp_oembed_get($instance['video']);

		echo $args['before_widget'];
		echo '<div class="positive-fitvids">';
			echo $embed_code;
			
			if(!empty($instance['poster'])){
				preg_match('/src="([^"]+)"/', $embed_code, $match);
				$url = $match[1];
				echo '<a href="'.$url.'" class="positive-icon i-play"><img src="'.$instance['poster'].'"></a>';
			}
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
		<p class="image-fields"><label for="<?php echo $this->get_field_id( 'poster' ) ?>"><?php _e('Image', 'positive-backend' ) ?></label>
			<span class="thumbnail">
				<?php if($instance['poster'] !='') echo '<img src="'.$instance['poster'].'">' ?>
			</span>
			<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','positive-backend');?>">
			<input type="hidden" class="positive-image-src" id="<?php echo $this->get_field_id( 'poster' ) ?>" name="<?php echo $this->get_field_name( 'poster' ) ?>" value="<?php echo $instance['poster'] ?>">
			<input type="button" class="positive-panels-removeimage" value="<?php _e('Remove image','positive-backend');?>">
			<br><small><?php _e('If especified, the image will be displayed while the video is not playing','positive-backend') ?></small>
		</p>
		<p><label for="<?php echo $this->get_field_id( 'video' ) ?>"><?php _e('Video', 'positive-backend' ) ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'video' ) ?>" id="<?php echo $this->get_field_id( 'video' ) ?>" value="<?php echo esc_attr( $instance['video'] ) ?>" />
		</p>

	<?php
	}

	function update( $new, $old ) {
		$new = wp_parse_args($new, array(
			'video' => str_replace( 'https://', 'http://', $new['video'] ),
			'poster' => ''
		));
		return $new;
	}
}


/* **********************
 * Carousel
 */
class Positive_Panels_Widget_Carousel extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-carousel',
			__( 'Logos Carousel (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Create a carousel with images.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		if(!wp_script_is('simplyscroll')){
			wp_enqueue_script('simplyscroll', POSITIVE_PANELS_URL.'widgets/js/jquery.simplyscroll.min.js', array('jquery'), '2.0.5');
		}

		echo $args['before_widget'];?>
		<div class="carousel">
			<ul>
			<?php foreach($instance['logos'] as $logo){
				echo '<li>';
				$attr = ($logo['alt'] ? 
					' alt="'.$logo['alt'].'" title="'.$logo['alt'].'"' : '');
				if($logo['url']){
					$target = ($logo['target'] ? ' target="_blank"' : '');
					echo '<a href="'.$logo['url'].'"'.$target.'>';
				} 
				echo '<img src="'.$logo['image'].'"'.$attr.' width="'.$logo['width'].'" height="'.$logo['height'].'">';
				if($logo['url']) echo '</a>';
				echo '</li>';
			} ?>
			</ul>
		</div>
		<?php echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'logos' => array()
		));
		return $new;
	}

	/**
	 * Array logos
	 *	- image (src)
	 *  - alt (title)
	 *  - width
	 *  - height
	 *  - url (text field)
	 *  - target (checkbox)
	 */
	function form($instance) {
		$instance = wp_parse_args($instance, array(
			'logos' => array(0 => array())
		)); ?>
		<div class="cloneable-fields" data-name="<?php echo $this->get_field_name( 'logos' ); ?>" data-id="<?php echo $this->get_field_id( 'logos' ); ?>">
			<?php foreach($instance['logos'] as $i => $logo){ ?>
				<div class="fields">
					<p class="image-fields">
						<label><?php _e( 'Image', 'positive-backend' ) ?></label>
						<span class="thumbnail">
							<?php if($logo['image'] !='') echo '<img src="'.$logo['image'].'">' ?>
						</span>
						<input type="button" class="positive-panels-uploadimage" value="<?php _e('Select or Upload image','positive-backend');?>">
						<input type="hidden" data-key="image" class="positive-image-src" 
							id="<?php echo $this->get_field_id( 'logos' ).'['.$i.'][image]' ?>" 
							name="<?php echo $this->get_field_name( 'logos' ).'['.$i.'][image]' ?>" value="<?php echo $logo['image'] ?>">
						<input type="hidden" data-key="alt" class="positive-image-alt" 
							id="<?php echo $this->get_field_id( 'logos' ).'['.$i.'][alt]' ?>" 
							name="<?php echo $this->get_field_name( 'logos' ).'['.$i.'][alt]' ?>" value="<?php echo $logo['alt'] ?>">
						<input type="hidden" data-key="width" class="positive-image-width" 
							id="<?php echo $this->get_field_id( 'logos' ).'['.$i.'][width]' ?>" 
							name="<?php echo $this->get_field_name( 'logos' ).'['.$i.'][width]' ?>" value="<?php echo $logo['width'] ?>">
						<input type="hidden" data-key="height" class="positive-image-height" 
							id="<?php echo $this->get_field_id( 'logos' ).'['.$i.'][height]' ?>" 
							name="<?php echo $this->get_field_name( 'logos' ).'['.$i.'][height]' ?>" value="<?php echo $logo['height'] ?>">
					</p>
					<p>
						<label><?php _e( 'Link Url', 'positive-backend' ) ?></label>
						<input type="text" data-key="url" 
							id="<?php echo $this->get_field_id( 'logos' ).'['.$i.'][url]' ?>" 
							name="<?php echo $this->get_field_name( 'logos' ).'['.$i.'][url]' ?>" value="<?php echo $logo['url'] ?>"><br>
						<label><input type="checkbox" data-key="target" 
							id="<?php echo $this->get_field_id( 'logos' ).'['.$i.'][target]' ?>" 
							name="<?php echo $this->get_field_name( 'logos' ).'['.$i.'][target]' ?>"<?php if($logo['target']==1) echo ' checked'; ?>> <?php _e( 'Check to open in new window', 'positive-backend' ) ?></label>
					</p>
				</div>
			<?php } ?>

		</div>
	<?php
	}
}

/* **********************
 * SUBPAGES MENU
 */
class Positive_Panels_Widget_Subpages extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-subpages',
			__( 'Subpages menu (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Insert a menu with the subpages of the current page', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		// align attribute is used on before_widget
		echo $args['before_widget'];
		echo '<nav>';
		echo '<ul>';
		$pageID = $instance['page'];
		wp_list_pages(array('child_of' =>$pageID, 'title_li' =>'', 'order' => 'menu_order'));
		echo '</ul>';
		echo '</nav>';
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'page' => '',
		));
		return $new;
	}

	function form($instance) {
		$instance = wp_parse_args($instance, array(
			'page' => '',
		)); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'page' ) ?>"><?php _e( 'Select the parent page you want to show subpages', 'positive-backend' ) ?></label><br><br>
			<select id="<?php echo $this->get_field_id( 'page' ) ?>" name="<?php echo $this->get_field_name( 'page' ) ?>">
				<?php $pages = get_pages(); 
	  			foreach ( $pages as $page ) { 
	  				if(has_children($page->ID)) {?>
						<option value="<?php echo $page->ID ?>" <?php selected($page->ID, $instance['page']) ?>><?php echo $page->post_title; ?></option>
					<?php } ?>
				<?php } ?>
			</select>
		</p>		
	<?php
	}
}


/* **********************
 * QUOTE
 */
class Positive_Panels_Widget_Quote extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-quote',
			__( 'Quote (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Insert a quote.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo '<blockquote>'. $instance['text'] .'</blockquote>';
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'text' => ''
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'text' => ''
		));

		?>
		<textarea class="widefat" id="<?php echo $this->get_field_id('text') ?>" name="<?php echo $this->get_field_name( 'text' ) ?>"/><?php echo esc_attr($instance['text']) ?></textarea>
		
	<?php
	}
}

/* **********************
 * TAXONOMY ACTIVIDADES
 */
class Positive_Panels_Widget_Taxonomy_Actividades extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-taxonomy-actividades',
			__( 'Categorias de Actividades (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Lista de categorías de Actividades.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];?>
		<?php $categories = get_terms( 'tipo_actividades', 'orderby=count&hide_empty=0' );
		echo '<h2 class="widgettitle">'.$instance['title'].'</h2>';
		echo '<ul>';
			 foreach ( $categories as $category ) { 
		echo	'<li>';
		echo 		'<a href="'. esc_url(get_term_link($category)).'">'.$category->name .'</a>';
		echo 	'</li>';
			}	
		echo '</ul>'; 
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'title' => ''
		));
		return $new;
	}

	function form($instance) {
		$instance = wp_parse_args($instance, array(
			'title' => ''
		)); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>">Titulo:</label><br>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $instance['title'] ) ?>" />
		</p>		
	<?php
	}
}

/* **********************
 * LAST POST ACTIVIDADES
 */
class Positive_Panels_Widget_Last_Actividades extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-last-actividades',
			__( 'Ultimas Actividades (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Listado de las últimas Actividades.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo '<h2 class="widgettitle">'.$instance['title'].'</h2>';
			$query = new WP_Query( array('post_type' => 'actividades', 'posts_per_page' => 3, 'order' => 'ASC') );
			if ( $query->have_posts()) {
		echo '<ul>';
				while ( $query->have_posts() ) { $query->the_post();
		echo	'<li>';
		echo 		'<a href="'.get_permalink().'">'. get_the_title() .'</a>';
		echo 	'</li>';	 
				} wp_reset_query();
		echo '</ul>';
			}
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'title' => ''
		));
		return $new;
	}

	function form($instance) {
		$instance = wp_parse_args($instance, array(
			'title' => ''
		)); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>">Titulo:</label><br>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $instance['title'] ) ?>" />
		</p>		
	<?php
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
	register_widget('Positive_Panels_Widget_Video');
	register_widget('Positive_Panels_Widget_Carousel');
	register_widget('Positive_Panels_Widget_Subpages');
	register_widget('Positive_Panels_Widget_Quote');
	register_widget('Positive_Panels_Widget_Taxonomy_Actividades');
	register_widget('Positive_Panels_Widget_Last_Actividades');
}
add_action('widgets_init', 'positive_panels_basic_widgets');

/**
 * Enqueue widget compatibility files.
 */
function positive_panels_comatibility_init(){
	if(is_plugin_active('black-studio-tinymce-widget/black-studio-tinymce-widget.php')){
		include 'compat/black-studio-tinymce/black-studio-tinymce.php';
	}
}
add_action('admin_init', 'positive_panels_comatibility_init', 5);