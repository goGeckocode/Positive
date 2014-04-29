<?php 
global $theme_data;
$args = array (
	'sort_column' => 'menu_order',
	'child_of' => $post->ID,
);
$page = get_pages($args);

// Si la pagina tiene hijos se redirige a la primera pagina hija.
if(!empty($page)){
	wp_redirect(get_permalink($page[0]));
// si existe la pagina de eventos(actividades) me pintas plantilla especial
} elseif ($theme_data['ps_page_events'] && $post->ID==$theme_data['ps_page_events']){
	include'actividades.php';
} elseif ($theme_data['ps_page_comunicacion'] && $post->ID==$theme_data['ps_page_comunicacion']){
	include'comunicacion.php';
} else {
	get_header();
	// Si la pagina actual tiene un padre [0] se le añade a main la clase con su slug.
	$ancestors = get_post_ancestors( $post->ID );
	$ancestors = array_reverse($ancestors);
	$main_class = '';
	$page = get_post($ancestors[0]);
	if($ancestors) { $main_class = 'class="'.$page->post_name.'"';}?>
		<article id="main" <?php echo $main_class;?>>
			<?php if (have_posts()) : while (have_posts()) : the_post();					
				
				// template layout builder
				if(function_exists('positive_panels_get_current_admin_panels_data') && positive_panels_get_current_admin_panels_data() )
					the_content();

				// default template
				else { ?>
					<div class="grid">
						<div class="column span-6 gray-box">
							<div class="panel positive-panels-heading align-center">
								<h1><?php the_title(); ?></h1>
							</div>
						</div>
					</div>
					<div class="section white-box">
						<div class="grid">
							<div class="column span-6">
								<div class="panel">
									<?php the_content(); ?>
								</div>
							</div>
						</div>
					</div>
				<?php }
			endwhile; endif; ?>
		</article><!-- #main -->
	<?php get_footer(); 
} ?>
