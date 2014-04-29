<?php 
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	query_posts( array('post_type'=>'comunicacion', 'order'=>'ASC', 'paged'=>$paged) );
	if ( have_posts()) :
		while ( have_posts() ) { the_post(); 
			?><article>
	    		<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
	    		<time><?php echo get_the_date(); ?></time>
	    		<?php the_excerpt(''); ?>
	    		<p class="cat">
	    		<?php $terms = get_the_terms( $post->ID , 'tipo_comunicacion' );
				 if ( $terms != null ){
				 	foreach( $terms as $term ) {?>
				 		<a href="<?php echo esc_url(get_term_link($term));?>"><?php echo $term->name ;?></a>
				 		<?php unset($term);
					} 
				} ?>
	    		</p>
	    	</article><?php 
	    } ?>
		<div class="paginate"><?php paginate() ?></div>
	<?php 
	else: ?>
		<p class="panel"><?php _e('Lo sentimos, no tenemos nada programado por el momento.','positive') ?></p>
	<?php 
	endif;
?>
