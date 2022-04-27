<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Wp_Data
{
    public static $wp_tax_terms = array();
    public static $wp_tax_terms_found_all = array();
    public static $wp_transients_loaded = array();
    public static $wp_tax_terms_cache_key = 'wp_tax_terms_';
    public static $use_transients = -1;
    public static $post_types = array();
    public static $is_taxonomy_archive = -1;


    public static function setup($taxonomy_name)
    {
        if(!isset(self::$wp_tax_terms_found_all[$taxonomy_name]))
        {
            self::$wp_tax_terms_found_all[$taxonomy_name] = false;
        }
        if(!isset(self::$wp_transients_loaded[$taxonomy_name]))
        {
            self::$wp_transients_loaded[$taxonomy_name] = false;
        }

        //check to see if we have this data already in the transient
        if(self::$use_transients===-1) {
            self::$use_transients = (int)get_option('search_filter_cache_use_transients');
        }
        //self::$use_transients = 0;

        if(self::$use_transients==1) {

            if((self::$wp_tax_terms_found_all[$taxonomy_name]==false)&&(self::$wp_transients_loaded[$taxonomy_name]==false)) {

                self::$wp_transients_loaded[$taxonomy_name] = true; //never do `get_transient` more than once

                $wp_tax_terms = Search_Filter_Wp_Cache::get_transient(self::$wp_tax_terms_cache_key . $taxonomy_name);

                if (!empty($wp_tax_terms)) {
                    foreach ($wp_tax_terms as $taxonomy_term) {
                        self::$wp_tax_terms[$taxonomy_name]['id'][$taxonomy_term->term_id] = $taxonomy_term;
                        self::$wp_tax_terms[$taxonomy_name]['slug'][$taxonomy_term->slug] = $taxonomy_term;
                    }

                    self::$wp_tax_terms_found_all[$taxonomy_name] = true;
                }

            }
        }
    }

    public static function get_taxonomy_terms($taxonomy_name)
    {
        self::setup($taxonomy_name);

        if((isset(self::$wp_tax_terms[$taxonomy_name]))&&(isset(self::$wp_tax_terms_found_all[$taxonomy_name])))
        {
            if(self::$wp_tax_terms_found_all[$taxonomy_name]==true) {
                return self::$wp_tax_terms[$taxonomy_name]["id"];
            }
        }

        self::$wp_tax_terms_found_all[$taxonomy_name] = true;

        self::$wp_tax_terms[$taxonomy_name] = array();
        self::$wp_tax_terms[$taxonomy_name]["id"] = array();
        self::$wp_tax_terms[$taxonomy_name]["slug"] = array();

        self::$wp_tax_terms[$taxonomy_name] = array();
        $t_taxonomy_terms = get_terms($taxonomy_name, array(
            'hide_empty' => false
        ));

        if(!empty($t_taxonomy_terms)) {

            foreach ($t_taxonomy_terms as $taxonomy_term)
            {
                $tax_term_basic = new stdClass();
                $tax_term_basic->term_id = $taxonomy_term->term_id;
                $tax_term_basic->slug = $taxonomy_term->slug;

                self::$wp_tax_terms[$taxonomy_name]['id'][$taxonomy_term->term_id] = $tax_term_basic;
                self::$wp_tax_terms[$taxonomy_name]['slug'][$taxonomy_term->slug] = $tax_term_basic;

                //self::$wp_tax_terms[$taxonomy_name]['id'][$t_taxonomy_terms[$ti]->term_id] = $t_taxonomy_terms[$ti];
                //self::$wp_tax_terms[$taxonomy_name]['slug'][$t_taxonomy_terms[$ti]->slug] = $t_taxonomy_terms[$ti];
            }

            if(self::$use_transients==1) {
                Search_Filter_Wp_Cache::set_transient(self::$wp_tax_terms_cache_key . $taxonomy_name, array_values(self::$wp_tax_terms[$taxonomy_name]['id']));
            }
        }

        /*for ($ti = 0; $ti < count($t_taxonomy_terms); $ti++) {
            self::$wp_tax_terms[$taxonomy_name]['id'][$t_taxonomy_terms[$ti]->term_id] = $t_taxonomy_terms[$ti];
            self::$wp_tax_terms[$taxonomy_name]['slug'][$t_taxonomy_terms[$ti]->slug] = $t_taxonomy_terms[$ti];
        }*/
        //

        if(empty(self::$wp_tax_terms[$taxonomy_name]))
        {
            return array();
        }

        return self::$wp_tax_terms[$taxonomy_name]["id"];
    }


    public static function get_taxonomy_term_by($by, $term_name, $taxonomy_name)
    {
        self::setup($taxonomy_name);

        if(!isset(self::$wp_tax_terms[$taxonomy_name]))
        {
            self::$wp_tax_terms[$taxonomy_name] = array();
            self::$wp_tax_terms[$taxonomy_name]["id"] = array();
            self::$wp_tax_terms[$taxonomy_name]["slug"] = array();
        }

        if(isset(self::$wp_tax_terms[$taxonomy_name][$by][$term_name]))
        {
            return self::$wp_tax_terms[$taxonomy_name][$by][$term_name];
        }

        //else, term name does not exist, so fetch it
        $term = get_term_by( $by, $term_name, $taxonomy_name );
		
        //if ( !is_wp_error( $term ) ) {
        if ( $term ) {
            self::$wp_tax_terms[$taxonomy_name]["id"][$term->term_id] = $term;
            self::$wp_tax_terms[$taxonomy_name]["slug"][$term->slug] = $term;

            if(isset(self::$wp_tax_terms[$taxonomy_name][$by][$term_name])) {
                return self::$wp_tax_terms[$taxonomy_name][$by][$term_name];
            }
            else
            {
                return array();
            }
        }

        return false;
    }

    public static function get_post_type_taxonomies($post_type)
    {

    }

    public static function is_taxonomy_archive($query = "")
    {
        if($query=="") {
            if(self::$is_taxonomy_archive===-1)
            {
                self::$is_taxonomy_archive = false;

                if ((is_tax() || is_category() || is_tag()) && (is_archive())) {

                    self::$is_taxonomy_archive = true;
                }
            }

            return self::$is_taxonomy_archive;
        }
        else
        {
            if (($query->is_tax() || $query->is_category() || $query->is_tag()) && ($query->is_archive())) {

                return true;
            }

            return false;
        }


    }
	public static function get_post_types_by_taxonomy( $tax = 'category' ){
		$out = array();
		$post_types = get_post_types();
		foreach( $post_types as $post_type ){

			if (!isset(self::$post_types[$post_type]))
			{
				self::$post_types[$post_type] = array();
			}

			if (!isset(self::$post_types[$post_type]['taxonomies']))
			{
				self::$post_types[$post_type]['taxonomies'] = get_object_taxonomies( $post_type );
			}

			$taxonomies = self::$post_types[$post_type]['taxonomies'];
			if( in_array( $tax, $taxonomies ) ){
				$out[] = $post_type;
			}
		}
		return $out;
	}

    public static function is_taxonomy_archive_of_post_type($post_type, $single = true)
    {
        if(!self::is_taxonomy_archive()) {
            return false;
        }

        if (!isset(self::$post_types[$post_type])) {
            self::$post_types[$post_type] = array();
        }

        if (!isset(self::$post_types[$post_type]['taxonomies'])) {
            self::$post_types[$post_type]['taxonomies'] = get_object_taxonomies( $post_type );
        }


        global $searchandfilter;
        $term = $searchandfilter->get_queried_object();
	    $is_taxonomy_archive = false;

        if(isset($term->taxonomy)){
	        $taxonomy_name = $term->taxonomy;

	        $tax_post_types = self::get_post_types_by_taxonomy($taxonomy_name);

	        //make sure this tax is not shared unless single is false(we need for woocommerce, because all taxes are shared betweeen 2 post types - variations and products
			if((( 1 === count($tax_post_types)) && ($single)) || (!$single)){
				$is_taxonomy_archive = in_array( $taxonomy_name, self::$post_types[$post_type]['taxonomies'] );
			}
        }

        return $is_taxonomy_archive;
    }
}

