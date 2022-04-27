<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Post_Data
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Global
{
	private $plugin_slug = '';
	private $active_sfid = 0;
	private $post_cache;
	private $pagination_init;
	private $queried_object;
    private $form_count;
	private $data;
	private $active_loop_id = 0;
    public $_GET;

	function __construct($plugin_slug)
	{
		$this->plugin_slug = $plugin_slug;

		global $search_filter_post_cache;
		$this->post_cache = $search_filter_post_cache;

		$this->pagination_init = false;

		add_action('search_filter_prep_query', array($this, 'set'), 10);
		add_action('search_filter_archive_query', array($this, 'query_posts'), 10); //legacy
		add_action('search_filter_do_query', array($this, 'query_posts'), 10); //legacy
		add_action('search_filter_query_posts', array($this, 'query_posts'), 10);
		add_action('search_filter_setup_pagination', array($this, 'setup_pagination'), 10);
		add_action('search_filter_remove_pagination', array($this, 'remove_pagination'), 10);

		add_action('search_filter_pagination_init', array($this, 'set_pagination_init'), 10);
		add_action('search_filter_pagination_unset', array($this, 'set_pagination_unset'), 10);
		add_action('wp', array($this, 'set_queried_object'), 10);

		//to prevent loops within loops, we need to keep track of which one is active
		add_action('loop_start', array($this, 'loop_start'), 10);
		add_action('loop_end', array($this, 'loop_end'), 10);

		$this->data = new stdClass();
		$this->form_count = new stdClass();
        $this->_GET = $_GET;

	}

	public function loop_start($query)
	{
		if($query->get('search_filter_id')){
			if(SEARCH_FILTER_QUERY_DEBUG==true) {
                echo "\r\n<!-- #sfdebug loop_start | query \r\n";

                $query_args_new = $query->query_vars;
                var_dump($query_args_new);
	            echo "\r\nLast SQL-Query: {$query->request}";
                echo "\r\n -->\r\n";
            }

			$this->active_loop_id = (int)$query->query_vars['search_filter_id'];
		}

	}

	public function loop_end($query)
	{
		if(isset($query->query_vars['search_filter_id']))
		{
			if((int)$query->query_vars['search_filter_id']==$this->active_loop_id)
			{
				$this->active_loop_id = 0;
			}
		}

	}

	public function set($sfid)
	{
		//$this->active_sfid = $sfid;
		if(!isset($this->data->$sfid))
		{
			$this->data->$sfid = new Search_Filter_Config($this->plugin_slug, $sfid);
		}
	}


	public function setup_pagination($sfid)
	{
		if(!isset($this->data->$sfid))
		{
			$this->data->$sfid = new Search_Filter_Config($this->plugin_slug, $sfid);
		}

		$this->data->$sfid->query->setup_pagination();
	}

	public function remove_pagination($sfid)
	{
		if(!isset($this->data->$sfid))
		{
			$this->data->$sfid = new Search_Filter_Config($this->plugin_slug, $sfid);
		}

		$this->data->$sfid->query->remove_pagination();
	}

	public function query_posts($sfid)
	{
		//$this->active_sfid = $sfid;
		$this->get($sfid)->query()->do_main_query();
	}

	public function get($sfid)
	{
		//$this->active_sfid = $sfid;
		if(!isset($this->data->$sfid))
		{
			$this->data->$sfid = new Search_Filter_Config($this->plugin_slug, $sfid);
		}

		return $this->data->$sfid;
	}

	public function set_active_sfid($sfid)
	{
		$this->active_sfid = $sfid;
	}
	public function active_loop_id()
	{
		return $this->active_loop_id;
	}

	public function active_sfid()
	{
		return $this->active_sfid;
	}

	public function is_search_form($sfid)
	{
		return $this->get($sfid)->is_valid_form();
	}

	public function set_pagination_init()
	{
		$this->pagination_init = true;
	}

	public function set_pagination_unset()
	{
		$this->pagination_init = false;
	}

	public function has_pagination_init()
	{
		return $this->pagination_init;
	}
	public function increment_form_count($sfid)
	{
		if(!isset($this->form_count->$sfid))
		{
			$this->form_count->$sfid = 0;
		}

		$this->form_count->$sfid++;
	}
	public function get_form_count($sfid)
	{
		if(!isset($this->form_count->$sfid))
		{
			$this->form_count->$sfid = 0;
		}

		return $this->form_count->$sfid;
	}
	public function set_queried_object()
	{
		$this->queried_object =	get_queried_object();
	}
	public function get_queried_object()
	{
		if((!isset($this->queried_object))||(empty($this->queried_object)))
		{
			$this->set_queried_object();
		}

		return $this->queried_object;

	}

}

