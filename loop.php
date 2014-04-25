<?php 
if (have_posts()) : 
	while (have_posts()) : the_post(); 
		?><article>
    		<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
    		<time><?php echo get_the_date(); ?></time>
    		<?php the_excerpt(''); ?>
    		<p class="cat"><?php the_category(' &gt; '); ?></p>
    	</article><?php 
	endwhile;?>
	<div class="paginate"><?php paginate(); echo'</div>';
else :

endif; ?>
