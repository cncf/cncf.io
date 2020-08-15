<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Wp_Cache
{
    public static $wp_tax_terms = array();
    public static $transient_keys = array();
    public static $transient_keys_key = "search_filter_transient_keys";
    public static $cache_options = array();
    public static $cache_option_name = 'search-filter-cache';
    public static $use_transients = -1;

    public static function set_transient($transient_key, $data, $lifespan = null)
    {
        self::update_transient_keys($transient_key);

        if(self::$use_transients!==1)
        {
            return;
        }

        //only set transients if the cache has completed..
        $update_transient = false;

        if(empty(self::$cache_options))
        {
            self::$cache_options = get_option(self::$cache_option_name);
        }

        if(isset(self::$cache_options['status']))
        {
            if(self::$cache_options['status']=="finished")
            {
                $update_transient = true;
            }
        }

        if($update_transient) {
        	if($lifespan===null){
        		$lifespan = self::get_transient_lifespan();
	        }
            return set_transient(self::create_transient_key($transient_key), $data, $lifespan);
        }

        return false;
    }

    public static function get_transient($transient_key)
    {
        self::update_transient_keys($transient_key);

        if(self::$use_transients!==1)
        {
            return;
        }

        return get_transient(self::create_transient_key($transient_key));

    }


    public static function delete_transient($transient_key)
    {
        self::update_transient_keys($transient_key, true);
        return delete_transient(self::create_transient_key($transient_key));
    }

    public static function purge_all_transients()
    {
        self::init_transient_keys(true);

        // For each key, delete that transient.
        foreach( self::$transient_keys as $t ) {
            delete_transient( $t );
        }

        // Reset our DB value.
        update_option( self::$transient_keys_key, array() );
    }

    public static function get_transient_lifespan()
    {
        $ten_mins = (DAY_IN_SECONDS / 24 / 60) * 10;
        $one_week = DAY_IN_SECONDS * 7;

        /*if( is_super_admin() && WP_DEBUG ) {
            return 1;
        } else {
            return $one_week;
        }*/

        return $one_week;
    }

    public static function create_transient_key($transient_key)
    {
        return "sf_ca_".md5($transient_key);
    }

    public static function init_transient_keys($override = false)
    {
        if(self::$use_transients===-1) {
            self::$use_transients = (int)Search_Filter_Helper::get_option('cache_use_transients');
        }

        if((self::$use_transients===1)||($override==true)) {
            if (empty(self::$transient_keys)) {
                $transient_keys = get_option(self::$transient_keys_key);

                if (!empty($transient_keys)) {
                    self::$transient_keys = $transient_keys;
                }
            }
        }
    }
    public static function update_transient_keys( $transient_key, $delete = false )
    {
        self::init_transient_keys();

        if(self::$use_transients!==1)
        {
            return;
        }

        $real_tranient_key = self::create_transient_key($transient_key);

        if(!in_array($real_tranient_key, self::$transient_keys)) {

            array_push(self::$transient_keys, $real_tranient_key);
            update_option( self::$transient_keys_key, self::$transient_keys);
        }
        else if($delete==true)
        {
            //if delete is true try to find it and remove it
            $search_index = array_search($real_tranient_key, self::$transient_keys);

            if($search_index!==false)
            {
                unset(self::$transient_keys[$search_index]);
                update_option( self::$transient_keys_key, self::$transient_keys);
            }
        }
    }
}

