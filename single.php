<?php 
get_header(); ?>

<div id="main">
	<div class="section white-box blog-layout">
		<div class="grid">
			<?php get_sidebar(); ?>
			
			<section class="column column-2 span-4 ">
				<header class="panel gray-box">
					<?php
					if( is_event() ) 
						echo '<h1 class="positive-icon i-events-title">'. positive_events_title().'</h1>';
					else echo '<h1 class="positive-icon i-news-title">'. positive_blog_title().'</h1>'; ?>
				</header>
				<?php get_post_type();
				if ('actividades'== get_post_type()){ ?>
					<article class="panel">
						<header>
							<h2><?php the_title();?></h2>
							<p class="cat">
								<?php 
								if( is_event() ) the_terms($post->ID, 'tipo_actividades','', ','); ?>
								
								<!-- Share buttons -->
								<span class="addthis_toolbox addthis_default_style">
									<a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="http://www.addthis.com/features/pinterest" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
									<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
									<a class="addthis_button_tweet"></a>
									<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
								</span>
							</p>
							<div class="event-info">
							<?php 
							echo '<time>'.rwmb_meta('PS_event_dates' ).'</time>';
							echo '<p>'. __('Lugar', 'positive').': <span class="event-place">'.rwmb_meta('PS_event_place' ).'</span></p>';
							echo '<p>'.__('Contacto', 'positive').': <span class="event-phone">'.rwmb_meta('PS_event_phone' ).'</span><a class="event-mail" href="mailto:'.rwmb_meta('PS_event_mail' ).'">'. rwmb_meta('PS_event_mail' ).'</a></p>';?>
							</div>
						</header>
						<?php the_post_thumbnail('full');?>
						<?php the_content() ?>
					</article>
				<?php } else {?>
					<article class="panel">
						<header>
							<time><?php the_date(); ?></time>
							<h2><?php the_title();?></h2>
							<p class="cat">
								<?php 
								if( is_event() ) the_terms($post->ID, 'tipo_actividades','', ' &gt; ');
								else the_category(' &gt; '); ?>
								
								<!-- Share buttons -->
								<span class="addthis_toolbox addthis_default_style">
									<a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="http://www.addthis.com/features/pinterest" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
									<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
									<a class="addthis_button_tweet"></a>
									<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
								</span>
							</p>
						</header>
						<?php the_post_thumbnail('full');?>
						<?php the_content() ?>

					</article>
				<?php } ?>				
			</section>
		</div>
	</div>
	
</div><!-- /main -->

<?php get_footer(); ?>