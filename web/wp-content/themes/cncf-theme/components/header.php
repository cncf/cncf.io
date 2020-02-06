<?php
/**
 * Header
 *
 * Header section - can contain the navigation.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_header();

$options = get_option( 'cncf-mu' );
if ( $options['show_hello_bar'] ) :
	get_template_part( 'components/hello-bar' );
endif;
$image = new Image();
?>

<header class="site-header">
	<div class="container wrap">

		<?php if ( $options['header_image_id'] ) { ?>
		<div class="logo">
			<a href="/" title="<?php echo bloginfo( 'name' ); ?>">
				<?php // TODO: replace with SVG in-line from theme. ?>
				<img src="<?php echo esc_url( wp_get_attachment_url( $options['header_image_id'] ) ); ?>"
					height="38" alt="<?php echo bloginfo( 'name' ); ?>">
			</a>
			<?php } ?>
		</div>
		<nav class="site-navigation">

			<a href="#" class="show-menu">
				<svg aria-hidden="true" data-prefix="fas" data-icon="bars"
					role="img" xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 448 512"
					class="svg-inline--fa fa-bars fa-w-14 fa-3x">
					<path fill="currentColor"
						d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"
						class=""></path>
				</svg>
				<svg aria-hidden="true" data-prefix="fas" data-icon="times"
					role="img" xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 352 512"
					class="svg-inline--fa fa-times fa-w-11 fa-2x">
					<path fill="currentColor"
						d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
						class=""></path>
				</svg>
			</a>
			<div class="menu-container-with-search">
				<?php
				wp_nav_menu(
					array(
						'menu'       => 'Main Menu',
						'menu_class' => 'navigation',
						'depth'      => 1,
					)
				);
				?>

				<?php if ( $options['header_cta_text'] && $options['header_cta_link'] ) : ?>
				<div class="header-cta">
					<a href="<?php echo esc_url( get_permalink( $options['header_cta_link'] ) ); ?>"
						class="button stocky header"><?php echo esc_html( $options['header_cta_text'] ); ?></a>
				</div>
				<?php endif; ?>
				<div class="header-search">

					<a href="#" class="button search transparent header"><?php $image->get_svg( 'search.svg' ); ?></a>
				</div>
			</div>
		</nav>
	</div>
</header>
