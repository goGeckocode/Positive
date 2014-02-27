<?php get_header(); ?>
	
	<?php if (have_posts()) : ?>
		<ul>
		<?php while (have_posts()) : the_post(); ?>
        	<li>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
				<p class="more"><a href="<?php the_permalink(); ?>">+</a></p>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
			</li>

		<?php endwhile; ?>
		</ul>
	<?php endif; ?>


<?php get_sidebar();
get_footer(); ?>
