<?php 

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        	
	        <h1><?php the_title(); ?></h1>
	        <?php the_content(); 

	        include(TEMPLATEPATH.'/addthis.php'); ?>

	        <?php comments_template( '', true ); ?>

	        <div class="posts-nav">
		        <span class="nav-previous"><?php previous_post_link( '%link', 'Anterior' ); ?></span>
				<span class="nav-next"><?php next_post_link( '%link', 'Posterior' ); ?></span>
			</div>

	<?php endwhile; endif; ?>



<?php get_sidebar();		
get_footer(); ?>
