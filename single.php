<?php 

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        	
	        <h1><?php the_title(); ?></h1>
	        <?php the_content(); ?>
	        <?php
 
			    // Retrieves the stored value from the database
			    $custom_text = get_post_meta( get_the_ID(), 'custom_text', true );
			    $custom_textarea = get_post_meta( get_the_ID(), 'custom_textarea', true );
			    $custom_checkbox = get_post_meta( get_the_ID(), 'custom_checkbox', true );
			    $custom_select = get_post_meta( get_the_ID(), 'custom_select', true );
			 
			    // Checks and displays the retrieved value
			    if( !empty( $custom_text ) ) {
			        echo $custom_text;
			    };
			    echo '<br>';
			    if( !empty( $custom_textarea ) ) {
			        echo $custom_textarea;
			    };
			    echo '<br>';
			    if( !empty( $custom_checkbox ) ) {
			        echo $custom_checkbox;
			    };
			    echo '<br>';
			    if( !empty( $custom_select ) ) {
			        echo $custom_select;
			    };
			 
			?>
	       

	<?php endwhile; endif; ?>