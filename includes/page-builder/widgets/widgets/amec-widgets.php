<?php
/**
 * Amec widgets
 */

/* **********************
 * POST-TYPE LIST
 */
class Positive_Panels_Widget_Post_type_list extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-post-type',
			__( 'Sectors (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Include a Sectors list.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];?>
		<?php $query = new WP_Query( array('post_type' => 'sectores', 'posts_per_page' => -1, 'order' => 'ASC') );
		if ( $query->have_posts()) {
			echo '<ul>';
			while ( $query->have_posts() ) { $query->the_post();
				$sector_desc = rwmb_meta('PS_sector_desc' );
				$sector_image = rwmb_meta( 'PS_sector_image', 'type=image' );
				
				foreach ($sector_image as $img ) {
					$imgUrl = $img['url'];
				}

				echo '<li>'; ?>
					<figure>
						<?php if($imgUrl) { ?>
							<img src="<?php echo $imgUrl; ?>" alt="<?php echo strip_tags(get_the_title()); ?>" title="<?php echo strip_tags(get_the_title()); ?>">
						<?php } else the_title(); ?>

						<figcaption><?php echo $sector_desc; ?></figcaption>
					</figure>
					<a class="btn show-info" href="#">leer mas</a>
					<div class="pt-content">
						<div class="pt-header">
							<img src="<?php echo $imgUrl; ?>" alt="<?php echo strip_tags(get_the_title()); ?>">
							<span><?php echo $sector_desc; ?></span>
						</div>
						<div class="panel textwidget">
							<?php the_content(); ?>
						</div>
					</div>
				<?php echo '</li>';
			} 
			echo '</ul>';

		} wp_reset_query();?>
		<?php echo $args['after_widget'];
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
		
	<?php
	}
}


/* **********************
 * Latest posts - News & Events
 */
class Positive_Panels_Widget_latest_post_NewEvent extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-listPosts',
			__( 'News & Events (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Display lastest Entries & Events.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];?>
		<ul>
			<li><h2>
				<?php echo positive_blog_title(); ?> <span>/</span>
			</h2></li>
			<li><h2>
				<?php echo positive_events_title(); ?>
			</h2></li>
		</ul>
		<?php echo $args['after_widget'];
		echo '</div></div>';// .column - .grid ?>
		<!-- POST NEWS -->
		<div id="post-news" class="list-posts content-select">
			<ul class="grid">
			<?php $i=1; 
			$query = new WP_Query( array('post_type' => 'post' , 'posts_per_page'  => 3) );
			while ( $query->have_posts() ) : $query->the_post();?>
				<li class="column span-2 column-<?php echo $i; ?>">
					<div class="panel">
						<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
						<time><?php the_date(); ?></time>
						<div class="excerpt"><?php the_excerpt();?></div>
						<p class="cat"><?php the_category(' &gt; '); ?></p>
					</div>
				</li>
				<?php $i++; 
			endwhile; wp_reset_query(); ?>
			</ul>
		</div>
		<!-- POST ACTIVIDADES -->
		<div id="post-actividades" class="list-posts">
			<ul class="grid">
			<?php $i=1; 
			$query = new WP_Query( array('post_type' => 'actividades' , 'posts_per_page'  => 3) );
			while ( $query->have_posts() ) : $query->the_post();?>
			<li class="column span-2 column-<?php echo $i; ?>">
				<div class="panel">
					<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
					<span class="date"><?php the_date(); ?></span>
					<div class="excerpt"><?php the_excerpt();?></div>
					<p class="cat"><?php the_category(' &gt; '); ?></p>
				</div>
			</li>
		<?php $i++; endwhile; wp_reset_query(); ?>
			</ul> 
		</div>				
		<?php echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
			'category' => ''
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'category' => ''
		));

		?>
		<?php // Category ?>
		<label for="<?php echo $this->get_field_id( 'category' ) ?>"><?php _e( 'Include the special widget for display last post of News & Events', 'positive-backend' ) ?></label>	
	<?php
	}
}

/* **********************
 * NUESTROS MIEMBROS
 */
class Positive_Panels_Widget_Member extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-Member',
			__( 'Our Member (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Create a widget with Member post type.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];?>
		<?php $query = new WP_Query( array('post_type' => 'sectores', 'posts_per_page' => -1, 'order' => 'ASC') );
		if ( $query->have_posts()) {
			echo '<ul class="list-sect">';
			$i=1;
			while ( $query->have_posts() ) { $query->the_post();
				// Cogemos la imagen de cada Sector
				$sector_image2 = rwmb_meta( 'PS_sector_image2', 'type=image' );
				foreach ($sector_image2 as $img ) {$imgUrl = $img['full_url'];}
				// Guardamos el ID del sector.
				$sectorID = get_the_ID();?>
				<li class="<?php if($i==1){echo'active';}?>">
					<a href="#">
						<img src="<?php echo $imgUrl; ?>" alt="<?php echo strip_tags(get_the_title()); ?>">
					</a>
					<ul class="members">
					<?php $query2 = new WP_Query( array('post_type' => 'miembros', 'posts_per_page' => -1,'meta_key'=>'PS_sectores', 'meta_value'=>$sectorID, 'order' => 'ASC') );
						if ( $query2->have_posts()) {
							while ( $query2->have_posts() ) { $query2->the_post();
								// Cogemos la imagen de cada Miembro
								$member_image = rwmb_meta( 'PS_member_image', 'type=image' );
								foreach ($member_image as $img ) {$imgUrl = $img['full_url'];}
								echo '<li>';
								echo 	'<figure><img src="'.$imgUrl.'" alt="'.strip_tags(get_the_title()).'" title="'.strip_tags(get_the_title()).'"></figure>';
								echo 	'<div>'. apply_filters('the_content',get_the_content()) .'</div>';
								echo'</li>';
								//} 
							}
						}?>
					</ul>
				</li>
			<?php $i++; } 
			echo '</ul>';
		} wp_reset_query();
		echo $args['after_widget'];
	}

	function update($new, $old){
		$new = wp_parse_args($new, array(
		));
		return $new;
	}

	function form( $instance ) {
		$instance = wp_parse_args($instance, array(
		));
		echo '<p>Se insertara en la pagina un listado con todos los Miembros de Amec clasificados por Sectores.</p>';
	}
}

/**
 * Register the widgets.
 */
function amec_widgets(){
	register_widget('Positive_Panels_Widget_Post_type_list');
	register_widget('Positive_Panels_Widget_latest_post_NewEvent');
	register_widget('Positive_Panels_Widget_Member');
}
add_action('widgets_init', 'amec_widgets');
