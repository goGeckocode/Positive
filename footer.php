
<footer>
	<div class="grid grid-1">
		<div class="column span-2 column-1">
			<?php if ( is_active_sidebar( 'footer' ) ) : ?>
				<ul id="sidebar">
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
				</ul>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
