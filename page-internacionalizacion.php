<?php 
/* Template Name: internacionalizacion */
get_header();	?>
		<article id="main">
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
	<?php get_footer(); ?>
