<?php
/**
 * Tab Container Filter
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Adds the menu section to the top of the content of each post.
 *
 * @param string $content Content of the post.
 */
function cncf_content_filter( $content ) {
	// get all div tags of class "wp-block-cgb-block-tab-container-block".
	$tag_regex = '/<[^>]*class="[^"]*\bwp-block-cgb-block-tab-container-block\b[^"]*"[^>]*>/i';
	preg_match_all( $tag_regex, $content, $matches );

	if ( ! $matches[0] ) {
		echo 'Check that you have set the tab section titles in the sidebar';
		return $content;
	}

	ob_start();
	?>
<div class="sticky-container">
	<div class="sticky-column">
	<div class="sticky-element">
	<span class="sticky-nav-hint">Page Navigation</span>
		<ol id="tab-container-nav" class="tab-container-nav">
			<?php
			// grab the data-menu-title and id from each tag to construct the menu.
			foreach ( $matches[0] as $match ) :
				preg_match( '/data-menu-slug="([^"]*)"/i', $match, $id );
				preg_match( '/data-menu-title="([^"]*)"/i', $match, $menu_title );
				?>
			<li><a
					href="#<?php echo esc_html( $id[1] ); ?>"><?php echo esc_html( $menu_title[1] ); ?></a>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>

	</div>

	<div class="sticky-main-content">
		<?php echo wp_kses_post( $content ); ?>
	</div>
</div>
	<?php
	$tab_container = ob_get_clean();
	return $tab_container;
}
add_filter( 'the_content', 'cncf_content_filter' );
