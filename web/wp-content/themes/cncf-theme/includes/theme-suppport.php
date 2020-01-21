<?php

/**
 * Theme Support functions
 *
 * Used to enable specific features of WordPress and other toolS
 */
if (! function_exists('the_theme_support_setup') ) :

    function the_theme_support_setup()
    {

        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');

        add_theme_support(
            'html5',
            array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            )
        );

        register_nav_menus(
            array(
            'main-menu' => esc_html__('Main Menu'),
            // 'secondary-menu' => esc_html__( 'Secondary Menu' ),
            // 'footer-menu' => esc_html__( 'The Footer Menu' )
            )
        );

    }
endif;
add_action('after_setup_theme', 'the_theme_support_setup');
