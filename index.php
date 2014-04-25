<?php 
get_header(); ?>

<div id="main">
	<div class="section white-box blog-layout">
		<div class="grid">
			<?php get_sidebar(); ?>
			
			<section class="column column-2 span-4 ">
				<?php if ($theme_data['ps_blog_image']){ 
					echo '<div class="positive-panels-css-image" style="background-image:url('
						. $theme_data['ps_blog_image']['src'].
						')"></div>';
				} ?>
				<header class="panel gray-box">
					<?php if(is_home()){?>
						<h1 class="positive-icon i-news-title"><?php echo positive_blog_title(); ?></h1>
					<?php } elseif(is_category()) { ?>
						<div class="heading-in">
							<span class="cat-title positive-icon i-news-title"><?php echo positive_blog_title(); ?></span>
							<h1><?php single_cat_title(); ?></h1>
						</div>
					<?php } elseif (is_archive()) { ?>
						<div class="heading-in">
							<span class="cat-title positive-icon i-news-title"><?php echo positive_blog_title(); ?></span>
							<h1><?php echo get_the_date('F Y'); ?></h1>
						</div>
					<?php } ?> 
				</header>
				<div class="panel posts-list">
					<?php get_template_part('loop'); ?>
				</div>
			</section>
		</div>
	</div>
	
</div><!-- /main -->

<?php get_footer(); ?>
