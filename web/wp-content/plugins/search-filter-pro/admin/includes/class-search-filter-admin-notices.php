<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Post_Data_Validation
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Admin_Notices {
	
	private $plugin_slug = '';
	private $error_log = array();
	private $all_search_form_ids = array();
	private $post_message_log = array();
	private $all_post_message_log = array();
	private $warning_log = array();
	private $success_log = array();
	
	public function __construct($plugin_slug) {

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		
		$this->plugin_slug = $plugin_slug;
		
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		
	}
	
	//notices shown when viewing all posts
	public function set_all_post_notices()
	{
		//$this->get_all_search_forms_wlang();
		
		if((Search_Filter_Helper::has_wpml())&&(defined('ICL_LANGUAGE_CODE')))
		{
			if(ICL_LANGUAGE_CODE=="all")
			{//this means a user has selected "all languages" - so loop loop through each language and check for errors - appending lang code
				
				$langs = icl_get_languages('skip_missing=0&orderby=KEY&order=DIR&link_empty_to=str');
				
				foreach($langs as $lang)
				{
					if(isset($lang['code']))
					{
						$search_form_ids = $this->get_all_search_forms_wlang($lang['code']);
						$this->set_all_post_notices_wlang($search_form_ids, $lang['code']);
					}
				}

				//reset current language - should be "all"
				global $sitepress;
				if( !empty($sitepress) )
				{
					$sitepress->switch_lang(ICL_LANGUAGE_CODE);
				}
				
				
			}
			else
			{
				//user must be on a specifc language, let wpml filter the rest
				$search_form_ids = $this->get_all_search_forms_wlang();
				$this->set_all_post_notices_wlang($search_form_ids);
			}
		}
		else
		{
			$search_form_ids = $this->get_all_search_forms_wlang();
			$this->set_all_post_notices_wlang($search_form_ids);
		}
		
	}
	
	public function get_all_search_forms_wlang($lang = "")
	{
		if($lang!="")
		{
			if(Search_Filter_Helper::has_wpml())
			{
				global $sitepress;
				if( !empty($sitepress) )
				{
					$sitepress->switch_lang($lang);
				}
				
			}
		}
		
		$search_form_query = new WP_Query('post_type=search-filter-widget&fields=ids&post_status=publish&posts_per_page=-1');
		$all_search_form_ids = $search_form_query->get_posts();
			
		return $all_search_form_ids;
		
	}
	
	//pass search form IDs to test for potential problems
	public function set_all_post_notices_wlang($search_form_ids, $lang = "")
	{
		$lang_text = '';
		if($lang!="")
		{
			$lang_text = '<span class="sf-error-langcode">['.$lang.']</span>';
		}
		
		$woocommerce_error_count = 0;
		$woocommerce_form_count = 0;
		$post_type_archive_count = array();
		
		
		foreach($search_form_ids as $search_form_id)
		{
			//$search_form_id
			//echo $search_form_id;

            $settings = Search_Filter_Helper::get_settings_meta($search_form_id);
            $fields = Search_Filter_Helper::get_fields_meta($search_form_id);

			if(isset($settings['display_results_as']))
			{
				$display_results_as = $settings['display_results_as'];
				
				if($display_results_as=="archive")
				{//warning - check to see if custom template is selected
					
					
				}
				else if($display_results_as=="post_type_archive")
				{//warning - check to see if custom template is selected
					
					if(isset($settings['post_types']))
					{
						$post_types = array_keys($settings['post_types']);
					}
					
					if(count($post_types)==1)
					{
						$post_type = $post_types[0];
						
						if(!isset($post_type_archive_count[$post_type]))
						{
							$post_type_archive_count[$post_type] = 0;
						}
						
						$post_type_archive_count[$post_type]++;
					}
				}
				else if($display_results_as=="custom_woocommerce_store")
				{
					//count number of forms using WooCommerce shop - can only be one
					$woocommerce_form_count++;
					
					
					
				}
			}
		}
		
		if($woocommerce_form_count>0)
		{//the there is a form with WooCommerce
			
			//check to make sure woocommerce is enabled
			if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				
				$message = array(
					'type' 		=> 'error',
					'message' 	=> sprintf(__('WooCommerce is not enabled and is in use in your search forms.  Choose a different display method or enable <strong>WooCommerce</strong> plugin.%s', $this->plugin_slug), $lang_text)
				);
				
				array_push($this->all_post_message_log, $message);
			}
			
			//display error if more than 1 set
			if($woocommerce_form_count>1)
			{
				$message = array(
					'type' 		=> 'error',
					'message' 	=> sprintf(__('There are <strong>%d</strong> Search Forms using display mode <strong>WooCommerce Shop</strong> - you may only have <strong>1</strong>%s', $this->plugin_slug), $woocommerce_form_count, $lang_text)
				);
				
				array_push($this->all_post_message_log, $message);
			}			
		}
		
		//post type archive
		foreach ($post_type_archive_count as $post_type => $post_count)
		{
			if($post_count>1)
			{
				//then there is an error - there are multiple search forms using post type archive, with the same post type - must be unique (==1)
				$post_type_object = get_post_type_object( $post_type );
				$label_name = "";
				
				if(isset($post_type_object->label))
				{
					$label_name = $post_type_object->label;
				}
				
				
				$message = array(
					'type' 		=> 'error',
					'message' 	=> sprintf(__('There are <strong>%d</strong> Search Forms set to use <strong>Post Type Archive</strong> display mode for the post type <strong>%s</strong> - you may only have <strong>1</strong>%s', $this->plugin_slug), $post_count, $label_name, $lang_text)
				);
				
				array_push($this->all_post_message_log, $message);
			}
		}
	}
	
	public function display_all_post_notices()
	{
		
		foreach($this->all_post_message_log as $post_message)
		{
			?>
			<div class="<?php echo $post_message['type']; ?>">
				<p>
					<?php 
						//_e( '<strong>Search &amp; Filter Error: </strong> ', $this->plugin_slug );
						_e( '<strong>Error: </strong> ', $this->plugin_slug );
						echo $post_message['message'];
					?>
				</p>
			</div>
			<?php
		}
	}
	
	//notices shown when editing a specific post
	public function set_post_notices($post_id = 0)
	{
		if($post_id==0)
		{
			global $post;
			$post_id = $post->ID;
		}
		$this->post_message_log = array();
		//setup errors

        $settings = Search_Filter_Helper::get_settings_meta($post_id);
        $fields = Search_Filter_Helper::get_fields_meta($post_id);
		
		if(isset($settings['display_results_as']))
		{
			$display_results_as = $settings['display_results_as'];
			
			if($display_results_as=="archive")
			{//warning - check to see if custom template is selected
				//error - check if template exists
				
				if(isset($settings['use_template_manual_toggle']))
				{
					$use_template_manual = (bool)$settings['use_template_manual_toggle'];
					
					if($use_template_manual)
					{
						//check to see if we have a valid template specified
						$template_error = false;
						
						$template_name_manual = trim($settings['template_name_manual']);
						$located = locate_template( $template_name_manual );
						
						if ( !empty( $located ) )
						{
							$template_error = false;
						}
						else
						{
							$template_error = true;
						}
						
						if($template_error)
						{
							$message = array(
								'type' 		=> 'error',
								'message' 	=> sprintf(__('The custom template file `<strong>%s</strong>` cannot be found - go to <strong>Display Results</strong> tab to fix', $this->plugin_slug), $template_name_manual)
							);
							
							array_push($this->post_message_log, $message);
						}
					}
					else
					{
						$message = array(
							'type' 		=> 'sf-notice',
							'message' 	=> __('You have not specified a <strong>custom template</strong> file for your results - this may lead to unexpected behaviour when displaying your results', $this->plugin_slug)
						);
						
						array_push($this->post_message_log, $message);
					}
					
				}
				
			}
			else if($display_results_as=="post_type_archive")
			{
				//check to see if there is only 1 post type set
				
				if(isset($settings['post_types']))
				{
					$post_types = array_keys($settings['post_types']);
				}
				else
				{
					$settings['post_types'] = array();
				}
				
				$this->set_max_post_types_error($post_types, 1);
				$this->set_post_type_archive_attributes_error($post_types);
				
				
				//check for duplicates - can't have 2 search forms set to post type archive, with the same post type
				$args = array(
					'property_key' => 'display_results_as',
					'property_value' => 'post_type_archive',
					'secondary_key' => 'post_types',
					'secondary_value' => $post_types
				);
				
				$total_forms_with_properties = $this->count_forms_with_properties($args);
				
				if($total_forms_with_properties>1)
				{
					if(count($post_types)==1)
					{
						$post_type_object = get_post_type_object( $post_types[0] );
						$label_name = "";
						
						if(isset($post_type_object->label))
						{
							$label_name = $post_type_object->label;
						}
						
						
						$message = array(
							'type' 		=> 'error',
							'message' 	=> sprintf(__('There are <strong>%d</strong> Search Forms set to use <strong>Post Type Archive</strong> display mode for the post type <strong>%s</strong> - you may only have <strong>1</strong>', $this->plugin_slug), $total_forms_with_properties, $label_name)
						);
						
						array_push($this->post_message_log, $message);
					}
				}
				
			}
			else if($display_results_as=="shortcode")
			{
				//check to make sure the results url is filled in
				if(isset($settings['results_url']))
				{
					$results_url = trim($settings['results_url']);
					
					$this->set_results_url_error($results_url);
					
					if($results_url!="")
					{//ensure there is a results URL before doing this check
						
						//this is just a warning, if the user is using SSL, try to warn in case they are not using https in their URL
						//is_ssl()
					}
				}
				
			}
			else if($display_results_as=="custom_woocommerce_store")
			{
				//check to make sure woocommerce is enabled
				if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
					
					$message = array(
						'type' 		=> 'error',
						'message' 	=> __('WooCommerce is not enabled. Choose a different display method or enable <strong>WooCommerce</strong> plugin.', $this->plugin_slug)
					);
					
					array_push($this->post_message_log, $message);
				}
				else
				{
					//check to make only product / variation post type is selected
					if(!isset($settings['post_types']))
					{
						$settings['post_types'] = array();
					}
					$this->set_post_types_error(array_keys($settings['post_types']), array("product", "product_variation"));
				}
				
				
				
				//check for duplicates - can't have 2 search forms set to WooCommerce store
				$args = array(
					'property_key' => 'display_results_as',
					'property_value' => 'custom_woocommerce_store'
					
				);
				
				$total_forms_with_properties = $this->count_forms_with_properties($args);
				
				if($total_forms_with_properties>1)
				{
					$message = array(
						'type' 		=> 'error',
						'message' 	=> sprintf(__('There are <strong>%d</strong> Search Forms using display mode <strong>WooCommerce Shop</strong> - you may only have <strong>1</strong>', $this->plugin_slug), $total_forms_with_properties)
					);
					
					array_push($this->post_message_log, $message);
			
				}
			}
			else if($display_results_as=="custom_edd_store")
			{
				//check to make sure edd is enabled
				if ( !is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) ) {
					
					$message = array(
						'type' 		=> 'error',
						'message' 	=> __('Easy Digital Downloads is not enabled. Choose a different display method or enable <strong>Easy Digital Downloads</strong> plugin.', $this->plugin_slug)
					);
					
					array_push($this->post_message_log, $message);
				}
				else
				{
					if(isset($settings['post_types']))
					{
						//check to make only download post type is selected
						$this->set_post_types_error(array_keys($settings['post_types']), array("download"));
					}
				}
				
				//check to make sure results url is filled in
				if(isset($settings['results_url']))
				{
					$results_url = trim($settings['results_url']);
					$this->set_results_url_error($results_url);
				}
								
				
			}
		}
		
		//fields
		
			//meta fields
				//if choice, check to make sure some options have been added
		
		//cache
		
			//check / display progress - warn if not yet complete
			
	}
	
	public function has_property_value($settings, $property_key, $property_value)
	{
		
		if(isset($settings[$property_key]))
		{
			if($property_key=="post_types")
			{//special case
				
				$post_types = array_keys($settings[$property_key]);
				
				if($post_types == $property_value)
				{
					return true;
				}
				
			}
			else
			{
				if($settings[$property_key]==$property_value)
				{
					return true;
				}
			}
		}
		
		return false;
	}
	
	function array_equal($a1, $a2) {
		return !array_diff($a1, $a2) && !array_diff($a2, $a1);
	}
	public function count_forms_with_properties($args)
	{
		$form_count = 0;
		
		$this->get_all_search_forms();
		
		foreach($this->all_search_form_ids as $search_form_id)
		{
    		//as we only want to update "enabled", then load all settings and update only this key
			$search_form_settings = Search_Filter_Helper::get_settings_meta($search_form_id);

			$first_match = false;
			$second_match = false;
			
			if($this->has_property_value($search_form_settings, $args['property_key'], $args['property_value']))
			{
				$first_match = true;
			}
						
			if(!isset($args['secondary_key']))
			{
				$second_match = true; //its not a match but we ignore it
			}
			else if((isset($args['secondary_key']))&&(isset($args['secondary_value'])))
			{
				if($this->has_property_value($search_form_settings, $args['secondary_key'], $args['secondary_value']))
				{
					$second_match = true;
				}
			}
			
			if(($first_match==true)&&($second_match==true))
			{
				$form_count++;
			}
			
		}
		
		return $form_count;
	}
	
	
	public function get_all_search_forms()
	{
		$search_form_query = new WP_Query('post_type=search-filter-widget&fields=ids&post_status=publish&posts_per_page=-1');
		$this->all_search_form_ids = $search_form_query->get_posts();
			
		
	}
	//fg
	public function set_post_type_archive_attributes_error($post_types)
	{
		if(count($post_types)==1)
		{
			//check to see if the post type is public - otherwise the archive URL simply will not work
			
			if($post_types[0]=="post")
			{//ignore for posts - we treat the blog page as its archive
				return;
			}
			
			$post_type_object = get_post_type_object( $post_types[0] );
			
			$archive_error = false;
			if(isset($post_type_object->has_archive))
			{
				if($post_type_object->has_archive==false)
				{
					//has_archive
					$archive_error = true;
				}
			}
			else
			{
				$archive_error = true;
			}
			
			if($archive_error==true)
			{
				$label_name = "";
				
				if(isset($post_type_object->label))
				{
					$label_name = $post_type_object->label;
				}
				
				$message = array(
					'type' 		=> 'error',
					'message' 	=> sprintf(__('The `<strong>has_archive</strong>` attribute is set to false for the post type <strong>%s</strong> - this must be enabled in order to use the Post Type Archive in WP', $this->plugin_slug), $label_name)
				);
				
				
				array_push($this->post_message_log, $message);
			}
			
		}
	}
	//check to ensure the post types selected are only in the required list
	public function set_max_post_types_error($post_types, $max_post_types)
	{
		if(count($post_types)>$max_post_types)
		{
			$message = array(
				'type' 		=> 'error',
				'message' 	=> sprintf(__('You can only select <strong>%d</strong> post type(s) - or change your display method', $this->plugin_slug), $max_post_types)
			);
			
			array_push($this->post_message_log, $message);
		}			
	}
	
	//check to ensure the post types selected are only in the required list
	public function set_post_types_error($post_types, $req_post_types)
	{
		$error = false;
		foreach($post_types as $post_type)
		{
			if(!in_array($post_type, $req_post_types))
			{
				$error = true;
			}
		}
		
		$post_types_labels = array();
		
		foreach($req_post_types as $post_type)
		{
			
			$post_type_object = get_post_type_object( $post_type );
			
			$label_name = "";
			if(isset($post_type_object->label))
			{
				$label_name = $post_type_object->label;
			}
			
			array_push($post_types_labels, $label_name);
		}
		
		if($error==true)
		{
			$message = array(
				'type' 		=> 'error',
				'message' 	=> __('You can only select the following post types: ', $this->plugin_slug) . '<strong>' . implode( ', ' , $post_types_labels ) . '</strong>' . __(' (or change your display method)', $this->plugin_slug)
			);
			
			array_push($this->post_message_log, $message);
		}
	}
	
	public function set_results_url_error($results_url)
	{
		if($results_url=="")
		{
			$message = array(
				'type' 		=> 'error',
				'message' 	=> __('Your <strong>Results URL</strong> is empty - go to <strong>Display Results</strong> tab to fix', $this->plugin_slug)
			);
			
			array_push($this->post_message_log, $message);
		}
		
	}
	
	public function display_post_notices()
	{
		foreach($this->post_message_log as $post_message)
		{
			?>
			<div class="notice <?php echo $post_message['type']; ?>">
				<p>
					<?php 
						$message_level = __("Error: ", $this->plugin_slug);
						if($post_message['type']=="sf-notice")
						{
							$message_level = __("Notice:", $this->plugin_slug);
						}
						//_e( '<strong>Search &amp; Filter Error: </strong> ', $this->plugin_slug );
						echo '<strong>'.$message_level.'</strong> ';
						echo $post_message['message'];
					?>
				</p>
			</div>
			<?php
		}
	}
	
	public function get_post_notices()
	{
		return $this->post_message_log;
	}
	
	public function clear_post_notices()
	{
		$this->post_message_log = array();
	}
	
	public function admin_notices()
	{
		
		
		global $current_screen;
		global $current_user;
		
		$user_id = $current_user->ID;
		
		//set default user meta
		if($current_screen->id=="edit-search-filter-widget")
		{
			if( !get_user_meta($user_id, $this->plugin_slug.'-show-welcome-notice') )
			{
				add_user_meta($user_id, $this->plugin_slug.'-show-welcome-notice', '1', true);
			}

			$this->set_all_post_notices();
			$this->display_all_post_notices();
		}
		else if($current_screen->id==$this->plugin_slug.'-widget')
		{
			$this->set_post_notices();
			$this->display_post_notices();
		}
		
		global $wpdb;
		$table_error = false;
		/*
		?>
		<div class="error">
			<p>
				<?php _e( '<strong>Search &amp; Filter Error: </strong> The caching tables are missing - ', $this->plugin_slug ); ?>
				<a href="<?php echo admin_url( 'admin-ajax.php?action=search_filter_build_cache_table' ); ?>"><?php _e( 'click here to create them', $this->plugin_slug ); ?></a>
			</p>
		</div>
		<?php
		*/
	}
	
}

