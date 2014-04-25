<?php
/* **********************
 * ONE CATEGORY - LIST POSTS
 */
class Positive_Panels_Widget_listPostsOneCategory extends WP_Widget {
	function __construct() {
		parent::__construct(
			'positive-panels-listPosts',
			__( 'List Posts (Positive)', 'positive-backend' ),
			array(
				'description' => __( 'Create a custom List Posts.', 'positive-backend' ),
			)
		);
	}

	function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo '<h2>'.get_category($instance['category'])->name.'</h2>';
		echo $args['after_widget'];
		echo '</div></div>';// .column - .grid
		echo '<ul class="grid list-posts">';?>
		<?php 
		$i=1; 
		$query = new WP_Query( array(/*'cat' => $instance['category']*/'post_type' => 'post' , 'posts_per_page'  => 3) );
		while ( $query->have_posts() ) : $query->the_post();?>
			<li class="column span-2 column-<?php echo $i; ?>">
				<div class="panel">
					<h3><?php the_title(); ?></h3>
					<span class="date"><?php the_date(); ?></span>
					<div class="excerpt"><?php the_excerpt();?></div>
					<p class="cat"><?php the_category(' &gt; '); ?></p>
				</div>
			</li>
		<?php $i++; endwhile; wp_reset_query(); ?>
		<?php echo '</ul>';		
		echo $args['after_widget'];
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
		<label for="<?php echo $this->get_field_id( 'category' ) ?>"><?php _e( 'Choose a category to display the last posts', 'positive-backend' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'category' ) ?>" name="<?php echo $this->get_field_name( 'category' ) ?>" value="">
		<?php $categories = get_categories();
		foreach ($categories as $category ) { ?>
			<option value="<?php echo $category->term_id; ?>" <?php selected($category->term_id, $instance['category']) ?>><?php echo $category->name; ?></option>
		<?php } ?>
		</select>		
	<?php
	}
}
?>