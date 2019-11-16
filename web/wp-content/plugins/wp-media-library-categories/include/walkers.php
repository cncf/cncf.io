<?php
/** Custom walker for wp_dropdown_categories, based on https://gist.github.com/stephenh1988/2902509 */
class wpmediacategory_walker_category_filter extends Walker_CategoryDropdown{

    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $pad = str_repeat( '&nbsp;', $depth * 3 );
        $cat_name = apply_filters( 'list_cats', $category->name, $category );

        if( ! isset( $args['value'] ) ) {
            $args['value'] = ( $category->taxonomy != 'category' ? 'slug' : 'id' );
        }

        $value = ( $args['value']=='slug' ? $category->slug : $category->term_id );
        if ( 0 == $args['selected'] && isset( $_GET['category_media'] ) && '' != $_GET['category_media'] ) {  // custom taxonomy
            $args['selected'] = $_GET['category_media'];
        }

        $output .= '<option class="level-' . $depth . '" value="' . $value . '"';
        if ( (string) $value === (string) $args['selected'] ) {
            $output .= ' selected="selected"';
        }
        $output .= '>';
        $output .= $pad . $cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;(' . $category->count . ')';

        $output .= "</option>\n";
    }

}

/** Custom walker for wp_dropdown_categories for media grid view filter */
class wpmediacategory_walker_category_mediagridfilter extends Walker_CategoryDropdown {

    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $pad = str_repeat( '&nbsp;', $depth * 3 );

        $cat_name = apply_filters( 'list_cats', $category->name, $category );

        $output .= ',{"term_id":"' . $category->term_id . '",';

        $output .= '"term_name":"' . $pad . esc_attr( $cat_name );
        if ( $args['show_count'] ) {
            $output .= '&nbsp;&nbsp;('. $category->count .')';
        }
        $output .= '"}';
    }

}

/** Custom walker for wp_terms_checklist on insert media popup */
class wpmediacategory_walker_media_taxonomy_checklist extends Walker {

    var $tree_type = 'category';
    var $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id'
    );

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children'>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        extract( $args );

        // Default taxonomy
        $taxonomy = 'category';
        // Add filter to change the default taxonomy
        $taxonomy = apply_filters( 'wpmediacategory_taxonomy', $taxonomy );

        $name = 'tax_input[' . $taxonomy . ']';

        $class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';
        $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->slug . '" type="checkbox" name="' . $name . '[' . $category->slug . ']" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
    }

    function end_el( &$output, $category, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}

/**
 *  wpmediacategory_walker_media_taxonomy_uploader_filter
 */
class wpmediacategory_walker_media_taxonomy_uploader_filter extends Walker {

    var $tree_type = 'category';
    var $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id'
    );

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "";
    }

    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        extract( $args );

        $indent = str_repeat( '&nbsp;&nbsp;&nbsp;', $depth );

        $el = array(
            'term_id'   => intval( $category->term_id ),
            'slug'      => $category->slug,
            'term_name' => esc_html( apply_filters( 'the_category', $category->name ) ),
            'term_row'  => $indent . esc_html( apply_filters( 'the_category', $category->name ) ) . '&nbsp;(' . $category->count . ')'
        );

        $output .= json_encode( $el );
    }

    function end_el( &$output, $category, $depth = 0, $args = array() ) {
        $output .= "";
    }
}
