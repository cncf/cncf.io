<?php

if ( ! function_exists( 'wp_all_import_get_import_id' ) ) {
    function wp_all_import_get_import_id() {
        global $argv;
        $import_id = 'new';

        if ( ! empty( $argv ) ) {
            if ( isset( $argv[3] ) ) {
                $import_id = $argv[3];
            }
        }
    
        if ( $import_id == 'new' ) {
            if ( isset( $_GET['import_id'] ) ) {
                $import_id = $_GET['import_id'];
            } elseif ( isset( $_GET['id'] ) ) {
                $import_id = $_GET['id'];
            }
        }

        return $import_id;
    }
}