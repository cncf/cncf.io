<?php
/**
 * Register widget areas
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

if ( ! function_exists( 'lf_widget_areas' ) ) :

	/**
	 * Register widget areas.
	 */
	function lf_widget_areas() {
		register_sidebar(
			array(
				'id'            => 'footer-widgets',
				'name'          => __( 'Footer widgets', 'lfevent' ),
				'description'   => __( 'Drag widgets to this container.', 'lfevent' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h6>',
				'after_title'   => '</h6>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'community-events-widgets',
				'name'          => __( 'Community Events Sidebar', 'lfevent' ),
				'description'   => __( 'Drag widgets to this container.', 'lfevent' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h6>',
				'after_title'   => '</h6>',
			)
		);
	}

	add_action( 'widgets_init', 'lf_widget_areas' );

endif;
