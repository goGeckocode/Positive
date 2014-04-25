
<footer>
	<div class="grid grid-1">
		<div class="column span-2 column-1">
			<?php if ( is_active_sidebar( 'footer' ) )
				dynamic_sidebar( 'footer' ); ?>
		</div>
		<div class="column span-2 column-2">
			<?php if ( is_active_sidebar( 'footer-2' ) )
				dynamic_sidebar( 'footer-2' ); ?>
		</div>
		<div class="column span-2 column-3">
			<?php if ( is_active_sidebar( 'footer-3' ) )
				dynamic_sidebar( 'footer-3' );

			// copyright & social networks
			echo '<div class="panel">';
				echo '<p class="copyright">&copy;'.date("Y").' '.get_bloginfo('name').'</p>';
				positive_social_buttons();
			echo '</div>'; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-533272e55d4ec385"></script>
</body>
</html>
