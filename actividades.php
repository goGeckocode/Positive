<?php
global $theme_data;
get_header(); ?>

<div id="main">
	<div class="section white-box blog-layout">
		<div class="grid">
			<?php get_sidebar(); ?>
			<section class="column column-2 span-4 ">
				<?php if ($theme_data['ps_events_image']){ 
					echo '<div class="positive-panels-css-image" style="background-image:url('
						. $theme_data['ps_events_image']['src'].
						')"></div>';
				} ?>
				<header class="panel gray-box">
					<h1 class="positive-icon i-events-title"><?php echo positive_events_title(); ?></h1>
				</header>
				<div class="panel posts-list">
					<?php get_template_part('loop','actividades'); ?>
				</div>
			</section>
		</div>
	</div>
	
</div><!-- /main -->

<?php get_footer(); ?>
