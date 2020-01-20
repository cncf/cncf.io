<footer class="footer">
<div class="container wrap">
	<div class="footer-logo">
		<a href="/" title="<?php echo bloginfo( 'name' ); ?>">

		</a>
	</div>

	<div class="footer-align">
<div>

	<?php
	wp_nav_menu(
		array(
			'menu'       => 'Footer Menu',
			'menu_class' => 'navigation',
			'depth'      => 1,
		)
	);
	?>

	<?php // get_template_part('blocks/social-links'); ?>

</div>
<div>Newsletter
	<?php // get_template_part('blocks/newsletter'); ?>

	<?php // Back to top ?>
	<a
		href="#top"><svg aria-hidden="true" data-prefix="fas"
				data-icon="chevron-up"
				role="img" xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 448 512"
				class="svg-inline--fa fa-chevron-up fa-w-14 fa-2x">
			<path fill="currentColor"
					d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"
					class=""></path>
		</svg> Back to Top</a>

</div>
</div>

</div>
<div class="container wrap cred">
	<p>Copyright &copy; <?php echo bloginfo( 'name' ); ?> <?php echo date( 'Y' ); ?>. All
		rights reserved.</p>
</div>
</footer>

<?php get_footer(); ?>
