
<footer>
	<div class="grid grid-1">
		<div class="column span-2 column-1">

			<?php if ( is_active_sidebar( 'footer' ) ) : ?>
				<ul id="sidebar">
				<div class="panel widget_positive-panels-image"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo-footer.png"></div>
					<?php dynamic_sidebar( 'footer' ); ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="column span-2 column-2">
			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<ul id="sidebar">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="column span-2 column-3">
			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<ul id="sidebar">
					<?php dynamic_sidebar( 'footer-3' ); ?>
					<?php $data = get_option('demo_options');
					if($data['ps_network']) { ?>
					<div class="panel panel-social">
                        <ul class="social-network">
                        <?php foreach ($data['ps_network'] as $red) {
                            echo '<li class="'.$red['ps_social_network_name'].'"><a target="_blank" title="'.$red['ps_social_network_name'].'" href="'.$red['ps_social_network_url'].'">'.$red['ps_social_network_name'].'</a></li>';
                        }?>
                        </ul>
                    </div>
                	<?php } ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
