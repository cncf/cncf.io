<?php
/**
 * The template for displaying pages and all lfevents post types
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

if ( $post->post_parent ) {
	$ancestors = get_post_ancestors( $post->ID );
	$parent_id = $ancestors[ count( $ancestors ) - 1 ];
} else {
	$parent_id = $post->ID;
}

$splash_page = get_post_meta( $post->ID, 'lfes_splash_page', true );
if ( ! $splash_page ) {
	// menu background color.
	$menu_color = get_post_meta( $parent_id, 'lfes_menu_color', true );
	$menu_color_2 = get_post_meta( $parent_id, 'lfes_menu_color_2', true );
	$menu_color_3 = get_post_meta( $parent_id, 'lfes_menu_color_3', true );
	$menu_text_color = get_post_meta( $parent_id, 'lfes_menu_text_color', true );
	$background_style = 'background-color: ' . $menu_color . ';';
	if ( $menu_color_2 ) {
		$background_style = 'background: linear-gradient(90deg, ' . $menu_color . ' 0%, ' . $menu_color_2 . ' 100%);';
	}
	$text_style = 'color: ' . $menu_text_color . ';';

	$logo = get_post_meta( $parent_id, 'lfes_' . $menu_text_color . '_logo', true );
	if ( $logo ) {
		$event_link_content = '<img src="' . wp_get_attachment_url( $logo ) . '" alt="' . get_the_title( $parent_id ) . '">';
	} else {
		$event_link_content = get_the_title( $parent_id );
	}

	?>

	<div data-sticky-container>
		<header class="event-header sticky" data-sticky data-sticky-on="large" data-options="marginTop:0;" style="<?php echo esc_html( $background_style . $text_style ); ?>">

			<div class="pre-nav">
				<?php
				echo '<a class="event-home-link" href="' . get_permalink( $parent_id ) . '">' . $event_link_content . '</a>'; //phpcs:ignore
				?>

				<button class="menu-toggler button alignright" data-toggle="event-menu">
					<span class="hamburger-icon"></span>
				</button>
			</div>

			<nav id="event-menu" class="event-menu show-for-large" data-toggler="show-for-large">
				<ul class="event-menu-list">
					<li class="page_item event-home-link" id="popout-header-link"><a href="<?php echo esc_url( get_permalink( $parent_id ) ); ?>" style="background-color:<?php echo $menu_color; ?>;"><?php echo $event_link_content; //phpcs:ignore ?></a></li>
					<?php
					if ( $menu_color_3 ) {
						$background_style_solid = 'background: ' . $menu_color_3 . ';';
					} else {
						$background_style_solid = $background_style;
					}
					$children = lfe_get_event_menu( $parent_id, $post->post_type, $background_style_solid );
					if ( $children ) {
						echo $children; //phpcs:ignore
					}
					lfe_get_other_events( $parent_id, $background_style_solid, $menu_text_color );
					?>
				</ul>
			</nav>

		</header>
	</div>

	<?php
} else {

	if ( is_lfeventsci() ) {
		$home_img = 'logo_lfevents_white.svg';
	} else {
		$home_img = 'logo_lfasiallc_white.svg';
	}
	?>
	
	<div data-sticky-container>
		<header class="main-header sticky" data-sticky data-sticky-on="large" data-options="marginTop:0;">
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/dist/assets/images/' . foundationpress_asset_path( $home_img ); //phpcs:ignore ?>"></a>	
		</header>
	</div>
	<?php
}
?>

<div class="main-container">
  <div class="main-grid">
	<main class="main-content-full-width">
		<?php
		while ( have_posts() ) :
			the_post();
			if ( $post->post_parent ) {
				if ( 'white' == $menu_text_color ) {
					$subpage_header_text_color       = 'black';
					$subpage_header_background_color = 'white';
				} else {
					$subpage_header_text_color       = 'white';
					$subpage_header_background_color = 'black';
				}
				$subpage_header_style = 'color:' . $subpage_header_text_color . '; background-color: ' . $subpage_header_background_color . '; -webkit-text-fill-color: transparent; background: -webkit-gradient(linear,left top,right bottom,from(' . $menu_color_2 . '),to(' . $menu_color . ')); background: -o-gradient(linear,left top,right bottom,from(' . $menu_color_2 . '),to(' . $menu_color . ')); -webkit-background-clip: text;';
				?>
	  <header class="event-subpage-header background-image-wrapper"
			  style="<?php echo esc_html( $text_style ); ?>">
		<div class="overlay"
			 style="background: linear-gradient(90deg, <?php echo esc_html( $menu_color_2 ); ?> 0%, <?php echo esc_html( $menu_color ); ?> 100%); <?php echo esc_html( $text_style ); ?>">
		</div>
		<figure class="figure-container">
				<?php
				if ( has_post_thumbnail() ) {
					echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'fp-xlarge', false, array( 'class' => 'f' ) );
				} else {
					echo wp_get_attachment_image( get_post_thumbnail_id( $parent_id ), 'fp-xlarge', false, array( 'class' => '' ) );
				}
				?>
		</figure>

		<h1 class="content-wrapper"
			style="background-color: <?php echo esc_html( $subpage_header_background_color ); ?>;">
		  <span style="<?php echo esc_html( $subpage_header_style ); ?>">
				<?php the_title(); ?>
		  </span>
		</h1>
	  </header>
				<?php
			} else {
				?>
					<h1 class="show-for-sr"><?php the_title(); ?></h1>
					<?php
			}

			if ( is_page_template( 'page-templates/multi-part-page.php' ) ) {
				get_template_part( 'template-parts/content', 'multi-part-page' );
			} else {
				get_template_part( 'template-parts/content', 'page' );
			}
			lfe_get_sponsors( $parent_id );
			endwhile;
		?>
	</main>
  </div>
</div>

<div class="event-footer"
	style="background: linear-gradient(90deg, <?php echo esc_html( $menu_color_2 ); ?> 0%, <?php echo esc_html( $menu_color ); ?> 100%); <?php echo esc_html( $text_style ); ?>">

		<?php
		$wechat = get_post_meta( $parent_id, 'lfes_wechat', true );
		$linkedin = get_post_meta( $parent_id, 'lfes_linkedin', true );
		$qq = get_post_meta( $parent_id, 'lfes_qq', true );
		$youtube = get_post_meta( $parent_id, 'lfes_youtube', true );
		$facebook = get_post_meta( $parent_id, 'lfes_facebook', true );
		$twitter = get_post_meta( $parent_id, 'lfes_twitter', true );

		if ( $wechat || $linkedin || $qq || $youtube || $facebook || $twitter ) {
			echo '<h3 class="event-social-links-header">Follow Us</h3>';
			echo '<ul class="event-social-links">';

			if ( $wechat ) {
				echo '<li>';
				echo '<a data-toggle="wechat-dropdown">';
				get_template_part( 'template-parts/svg/wechat' );
				echo '</a>';
				echo '<div class="dropdown-pane" id="wechat-dropdown" data-dropdown data-hover="true" data-hover-pane="true" data-hover-delay="0" data-position="top" data-alignment="center">' . wp_get_attachment_image( esc_html( $wechat ) ) . '</div>';
				echo '</li>';
			}
			if ( $linkedin ) {
				echo '<li><a target="_blank" href="' . esc_html( $linkedin ) . '">';
				get_template_part( 'template-parts/svg/linkedin' );
				echo '</a></li>';
			}
			if ( $qq ) {
				echo '<li><a target="_blank" href="' . esc_html( $qq ) . '">';
				get_template_part( 'template-parts/svg/qq' );
				echo '</a></li>';
			}
			if ( $youtube ) {
				echo '<li><a target="_blank" href="' . esc_html( $youtube ) . '">';
				get_template_part( 'template-parts/svg/youtube' );
				echo '</a></li>';
			}
			if ( $facebook ) {
				echo '<li><a target="_blank" href="' . esc_html( $facebook ) . '">';
				get_template_part( 'template-parts/svg/facebook' );
				echo '</a></li>';
			}
			if ( $twitter ) {
				echo '<li><a target="_blank" href="' . esc_html( $twitter ) . '">';
				get_template_part( 'template-parts/svg/twitter' );
				echo '</a></li>';
			}

			echo '</ul>';
		}
		?>
</div>

<?php
get_footer();
