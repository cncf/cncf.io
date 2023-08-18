<?php
/**
 *
 * Learning Journey Menu
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 **/

/**
 * Output Learning Journey Menu
 *
 * @return void
 */
function output_learning_journey_menu() {
	$blocks       = parse_blocks( get_the_content() );
	$found_blocks = recursive_find_blocks( $blocks );

	if ( empty( $found_blocks ) ) {
		if ( is_admin() ) {
			echo 'This block requires the Learning Journey Block to be used on the page.';
		}
		return;
	}

	echo '<ul>';
	foreach ( $found_blocks as $block ) {
		$number = isset( $block['attrs']['data']['ljs_section_number'] ) ? $block['attrs']['data']['ljs_section_number'] : '';
		$title  = isset( $block['attrs']['data']['ljs_title'] ) ? $block['attrs']['data']['ljs_title'] : '';
		$slug   = strtolower( trim( preg_replace( '/[^A-Za-z0-9-]+/', '-', $title ), '-' ) );

		printf(
			'<li><a href="#%s"><span>%s</span>%s</a></li>',
			esc_attr( $slug ),
			esc_html( $number ),
			esc_html( $title )
		);
	}
	echo '</ul>';
}

/**
 * Recursive Find Block
 *
 * @param array $block_objects Blocks.
 * @return array $results Blocks.
 */
function recursive_find_blocks( $block_objects ) {
	$results = array();

	foreach ( $block_objects as $block_object ) {
		if ( 'lf/learning-journey-section' === $block_object['blockName'] ) {
			$results[] = $block_object;
		}

		if ( ! empty( $block_object['innerBlocks'] ) ) {
			$results = array_merge( $results, recursive_find_blocks( $block_object['innerBlocks'] ) );
		}
	}

	return $results;
}
