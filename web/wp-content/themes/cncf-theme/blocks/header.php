<?php
	get_header();
	$image = new Image();
?>
	<header class="site-header">
	<div class="container wrap">
	<div class="logo">
	<a href="/"
	title="<?php echo bloginfo( 'name' ); ?>"><?php $image->get_svg( 'logo.svg' ); ?>
	</a>
	</div>
	</div>
	</header>

	<nav class="site-navigation">
	<div class="container">
	<a href="#" class="show-menu">
	<svg aria-hidden="true" data-prefix="fas" data-icon="bars" role="img"
	xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
	class="svg-inline--fa fa-bars fa-w-14 fa-3x">
	<path fill="currentColor"
	d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"
	class=""></path>
	</svg>
	<svg aria-hidden="true" data-prefix="fas" data-icon="times" role="img"
	xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"
	class="svg-inline--fa fa-times fa-w-11 fa-2x">
	<path fill="currentColor"
	d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
	class=""></path>
	</svg>
	</a>
	<?php
	wp_nav_menu(
		array(
			'menu'       => 'Main Menu',
			'menu_class' => 'navigation',
			'depth'      => 1,
		)
	);
	?>
	<ul class="social">
	<li><a href="https://uk.linkedin.com/in/todo"><svg aria-hidden="true"
	data-prefix="fab" data-icon="linkedin-in" role="img"
	xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
	class="svg-inline--fa fa-linkedin-in fa-w-14 fa-2x">
	<path fill="currentColor"
	d="M100.3 480H7.4V180.9h92.9V480zM53.8 140.1C24.1 140.1 0 115.5 0 85.8 0 56.1 24.1 32 53.8 32c29.7 0 53.8 24.1 53.8 53.8 0 29.7-24.1 54.3-53.8 54.3zM448 480h-92.7V334.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V480h-92.8V180.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V480z"
	class=""></path>
	</svg></a></li>
	<li><a href="https://twitter.com/todo"><svg aria-hidden="true"
	data-prefix="fab" data-icon="twitter" role="img"
	xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
	class="svg-inline--fa fa-twitter fa-w-16 fa-2x">
	<path fill="currentColor"
	d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
	class=""></path>
	</svg></a></li>
	<li><a href="https://www.facebook.com/todo"><svg aria-hidden="true"
	data-prefix="fab" data-icon="facebook-f" role="img"
	xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 512"
	class="svg-inline--fa fa-facebook-f fa-w-9 fa-2x">
	<path fill="currentColor"
	d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"
	class=""></path>
	</svg></a></li>
	</ul>
	</div>
	</nav>
