<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Widget
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Search_Filter_Register_Widget extends WP_Widget
{
	
	/*public function __construct()
	{

		$plugin = Search_Filter::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		
		//register_widget('search_filter_widget');
	}*/
	
	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, 'Search & Filter Form' );
		
		//$plugin = Search_Filter::get_instance();
		$this->plugin_slug = "search-filter";
	}
	function widget( $args, $instance )
	{
		extract($args);
		
		$title = apply_filters('widget_title', $instance['title']);
		
		echo $before_widget; //Widget starts to print information
		
		// Check if title is set
		if ( $title )
		{
			echo $before_title . $title . $after_title;
		}
		
		$formid = apply_filters( 'widget_title', $instance['formid'] );
		
		echo do_shortcode('[searchandfilter id="'.$formid.'"]');
				
		echo $after_widget; //Widget ends printing information
		//do_shortcode('[searchandfilter id="11"]');
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		$instance = $old_instance;
		 
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['formid'] = ( ! empty( $new_instance['formid'] ) ) ? strip_tags( $new_instance['formid'] ) : '';
		
		return $instance;
		 
	}

	function form( $instance )
	{
		
		
		if (( isset( $instance[ 'title' ]) ) && ( isset( $instance[ 'formid' ]) ))
		{
			$title = __(esc_attr($instance['title']), $this->plugin_slug);
			$formid = esc_attr($instance[ 'formid' ]);
		}
		else
		{
			$title = __( '', $this->plugin_slug);
			$formid = __( '', $this->plugin_slug);
		}
		
		?>
		<div class="sf-widget-content">
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p>
				<label for="<?php echo $this->get_field_id( 'formid' ); ?>">Choose a Search Form: 
					<select class="widefat" name="<?php echo $this->get_field_name( 'formid' ); ?>" id="<?php echo $this->get_field_id( 'formid' ); ?>">
						<option value="0"><?php _e('Please choose'); ?></option>
						<?php //
							$custom_posts = new WP_Query('post_type=search-filter-widget&post_status=publish&posts_per_page=-1');
							
							if ( Search_Filter_Helper::has_wpml() )
							{
								$current_lang = Search_Filter_Helper::wpml_current_language();
								if ( $current_lang ) {
									$formid = Search_Filter_Helper::wpml_object_id( $formid, 'search-filter-widget', true, $current_lang );
								}
							}

                            if( $custom_posts->post_count > 0 ){
                                foreach ($custom_posts->posts as $post){
                                    ?>
                                    <option value="<?php echo $post->ID; ?>" <?php if($formid==$post->ID){ echo ' selected="selected"'; } ?>><?php echo esc_html($post->post_title); ?></option>
                                    <?php
                                }
                            }

							/*while ($custom_posts->have_posts()) : $custom_posts->the_post();
						?>
							<option value="<?php the_ID(); ?>" <?php if($formid==get_the_ID()){ echo ' selected="selected"'; } ?>><?php the_title(); ?></option>
						<?php endwhile; ?>
                        <?php wp_reset_postdata();*/ ?>
					</select>
				</label>
			</p>
			<!--<p class="sf-widget-text-last">
				<?php _e('Don\'t see a Search Form you want to use? <a href="'.admin_url( 'post-new.php?post_type=search-filter-widget' ).'">Create a new Search Form</a>.'); ?>
				
			</p>-->
		</div>
		<?php
	}
}
