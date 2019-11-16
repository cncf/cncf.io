<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Post_Cache
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Shared { 

	private $plugin_slug = "search-filter";
	public function __construct() {

		global $wpdb;
		add_action( 'init', array( $this, 'create_custom_post_types' ) );
        add_action('widgets_init', array($this, 'init_widget'));

        add_filter('rewrite_rules_array', array($this, 'sf_rewrite_rules'));

        // Load plugin text domain
        add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

        // Activate plugin when new blog is added
        //add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

    }
	public function create_custom_post_types()
	{
		$labels = array(
		    'name'					=>	__( 'Search &amp; Filter', $this->plugin_slug ),
			'singular_name'			=>	__( 'Search Form', $this->plugin_slug ),
		    'add_new'				=>	__( 'Add New Search Form', $this->plugin_slug ),
		    'add_new_item'			=>	__( 'Add New Search Form', $this->plugin_slug ),
		    'edit_item'				=>	__( 'Edit Search Form', $this->plugin_slug ),
		    'new_item'				=>	__( 'New Search Form', $this->plugin_slug ),
		    'view_item'				=>	__( 'View Search Form', $this->plugin_slug ),
		    'search_items'			=>	__( 'Search \'Search Forms\'', $this->plugin_slug ),
		    'not_found'				=>	__( 'No Search Forms found', $this->plugin_slug ),
		    'not_found_in_trash'	=>	__( 'No Search Forms found in Trash', $this->plugin_slug ),
		);
		
		register_post_type($this->plugin_slug.'-widget' , array(
			'labels'			=> $labels,
			'public'			=> false,
			'show_ui'			=> true,
			'_builtin'			=> false,
			'capability_type'	=> 'page',
			'hierarchical'		=> true,
			'rewrite'			=> false,
			'supports'			=> array('title'),
			'show_in_menu'		=> false
			/*'has_archive' => true,*/
		));
	}


    public function init_widget()
    {
        register_widget( 'Search_Filter_Register_Widget' );
    }



    function sf_rewrite_rules( $rules )
    {
        global $searchandfilter;
        $newrules = array();

        $args = array(
            'posts_per_page' => -1,
            'post_type' => $this->plugin_slug."-widget",
            'post_status' => 'publish'
        );

        if (has_filter('sf_rewrite_query_args')) {
            $args = apply_filters('sf_rewrite_query_args', $args);
        }

        $all_search_forms = get_posts( $args );
        
        foreach ($all_search_forms as $search_form)
        {
            $settings = Search_Filter_Helper::get_settings_meta($search_form->ID);

            if(isset($settings['page_slug']))
            {
                if($settings['page_slug']!="")
                {
                    $base_id = $search_form->ID;

                    //$newrules[$settings['page_slug'].'/page/([0-9]+)/([0-9]+)$'] = 'index.php?&sfid='.$base_id.'&paged=$matches[2]&lang=$matches[1]'; //pagination & lang rule
                    //$newrules[$settings['page_slug'].'/page/([0-9]+)$'] = 'index.php?&sfid='.$base_id.'&paged=$matches[1]'; //pagination rule
                    //$newrules[$settings['page_slug'].'/page/([0-9]+)$'] = 'index.php?&sfid='.$base_id.'&paged=$matches[1]'; //pagination rule

                    $use_rewrite = true;
                    if(isset($settings['display_results_as']))
                    {
                        //if(($settings['display_results_as']=="post_type_archive")||($settings['display_results_as']=="shortcode")||($settings['display_results_as']=="custom_woocommerce_store")||($settings['display_results_as']=="custom_edd_store"))
                        if($settings['display_results_as']!="archive")
                        {
                            $use_rewrite = false;
                        }
                    }


                    if($use_rewrite==true)
                    {
                        $newrules[$settings['page_slug'].'$'] = 'index.php?&sfid='.$base_id; //regular plain slug

                        if(has_filter('sf_archive_slug_rewrite')) {

                            $newrules = apply_filters('sf_archive_slug_rewrite', $newrules, $base_id, $settings['page_slug']);
                        }
                    }

                }
            }
        }

        return $newrules + $rules;
    }
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        $domain = $this->plugin_slug;
        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

        load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
        load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

    }



    /**
     *
     * @since    1.0.0
     *
     * @param    int    $blog_id    ID of the new blog.
     */
    /*public function activate_new_site( $blog_id ) {

        if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
            return;
        }

        switch_to_blog( $blog_id );
        self::single_activate();
        restore_current_blog();

    }*/

}
