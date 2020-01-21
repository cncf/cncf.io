<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Generate_Input
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Generate_Input {
	
	private $field_count = 0;
	
	public function __construct($plugin_slug, $sfid) {

		$this->plugin_slug = $plugin_slug;
		$this->sfid = $sfid;
	}
	
	
	public function generate_range_checkbox($field, $min, $max, $step, $smin, $smax, $value_prefix = "", $value_postfix = "")
	{
		$returnvar = '<ul>';
		$input_class = SF_CLASS_PRE."input-checkbox";
		
		if(isset($this->defaults[SF_FPRE.'meta_'.$field]))
		{
			$defaults = $this->defaults[SF_FPRE.'meta_'.$field];
		}
		
		if(isset($defaults[0]))
		{
			$smin = intval($defaults[0]);
		}
		
		if(isset($defaults[1]))
		{
			$smax = intval($defaults[1]);
		}
		
		$startval = $min;
		$endval = $max;
		$diff = $endval - $startval;
		$istep = ceil($diff/$step);
		
		
		for($i=0; $i<($istep); $i++)
		{
			$radio_value = $startval + ($i * $step);
			$radio_top_value = ($radio_value + $step - 1);
			
			if($radio_top_value>$endval)
			{
				$radio_top_value = $endval;
			}
			
			global $searchandfilter;
			$sf_instance_count = $searchandfilter->get_form_count($this->sfid);
			$input_id = SF_INPUT_ID_PRE.sanitize_html_class($this->sfid."_".$sf_instance_count."_".$name."_".$radio_value);

			$radio_label = $value_prefix.$radio_value.$value_postfix." - ".$value_prefix.$radio_top_value.$value_postfix;
			$returnvar .= '<li><input class="'.$input_class.'" id="'.$input_id.'" type="checkbox" name="'.SF_FPRE.'meta_'.$field.'[]" value="'.esc_attr($radio_value).'"><label for="'.$input_id.'">'.esc_html($radio_label).'</label></li>';
		}
		
		
		$returnvar .= '</ul>';
		
		return $returnvar;
	}
	
	/* finish remove */
	
	public function datepicker($args)
	{
		$returnvar = '';
		
		$args['attributes']['class'] = 'sf-datepicker sf-input-date';
		
		if(isset($args['prefix']))
		{
			if($args['prefix']!="")
			{
				$args['prefix'] = "<span class='".SF_CLASS_PRE."date-prefix'>".$args['prefix']."</span>";
			}
		}
		if(isset($args['postfix']))
		{
			if($args['postfix']!="")
			{
				$args['postfix'] = "<span class='".SF_CLASS_PRE."date-postfix'>".$args['postfix']."</span>";
			}
		}
		
		$returnvar .= $this->text($args);
		
		return $returnvar;
	}
	
	public function text($args)
	{
		
		//init defaults & vars
		$input_args = $this->prepare_input_args($args, "text");
		
		//wcag 2.0
		$accessibility_label = "";
		if(isset($input_args['accessibility_label']))
		{
			if($input_args['accessibility_label']!="")
			{
				$accessibility_label = $input_args['accessibility_label'];
			}
		}
		
		//now we want to put the class attribute on the LI, and remove from input
		$input_args['attributes']['class'] .= ' '.$input_args['input_class'];
		$input_args['attributes']['class'] = trim($input_args['attributes']['class']);
		$input_args['attributes']['type'] = $input_args['type'];
		$input_args['attributes']['value'] = $input_args['value'];
		$input_args['attributes']['title'] = $accessibility_label;
		
		//filter the input arguments before the html is generated - allowing almost all options to be modified
		if(has_filter('sf_input_object_pre')) {
			$input_args = apply_filters('sf_input_object_pre', $input_args, $this->sfid);
		}
		
		
		//prepare html
		$attibutes_html = $this->convert_attributes_to_html($input_args['attributes']);
		
		$prefix = "";
		$postfix = "";
		
		if(isset($input_args['prefix']))
		{
			if($input_args['prefix']!="")
			{
				$prefix = $input_args['prefix'];
			}
		}
		if(isset($input_args['postfix']))
		{
			if($input_args['postfix']!="")
			{
				$postfix = $input_args['postfix'];
			}
		}
		
		ob_start();
		
		?>
		<?php echo $prefix; ?><label><?php if($accessibility_label!=""){ ?><span class="screen-reader-text"><?php echo $accessibility_label; ?></span><?php } ?><input<?php echo $attibutes_html; ?>></label><?php echo $postfix; ?>
		<?php
		
		$output = ob_get_clean();
		
		return $output;
	}
	
	
	public function select($args)
	{
		//init defaults & vars
		$input_args = $this->prepare_input_args($args, "select");
		
		//wcag 2.0
		//$accessibility_label = __("Choose an option:", $this->plugin_slug);
		$accessibility_label = "";
		if(isset($input_args['accessibility_label']))
		{
			if($input_args['accessibility_label']!="")
			{
				$accessibility_label = $input_args['accessibility_label'];
			}
		}
		
		$input_args['attributes']['title'] = $accessibility_label;
		
		//now we want to put the class attribute on the LI, and remove from input
		$input_args['attributes']['class'] .= ' '.$input_args['input_class'];
		$input_args['attributes']['class'] = trim($input_args['attributes']['class']);
		unset($input_args['input_class']);//don't want this visible to users
		
		//filter the input arguments before the html is generated - allowing almost all options to be modified
		if(has_filter('sf_input_object_pre')) {
			$input_args = apply_filters('sf_input_object_pre', $input_args, $this->sfid);
		}
		
		//prepare html
		$attibutes_html = $this->convert_attributes_to_html($input_args['attributes']);
		
		$prefix = "";
		$postfix = "";
		
		if(isset($input_args['prefix']))
		{
			if($input_args['prefix']!="")
			{
				$prefix = $input_args['prefix'];
			}
		}
		if(isset($input_args['postfix']))
		{
			if($input_args['postfix']!="")
			{
				$postfix = $input_args['postfix'];
			}
		}

		ob_start();
		
		?>
		<?php echo $prefix; ?><label>
		<?php if($accessibility_label!=""){ ?><span class="screen-reader-text"><?php echo $accessibility_label; ?></span><?php } ?>
		<select<?php echo $attibutes_html; ?>>
			
			<?php
			
			foreach($input_args['options'] as $option)
			{
				//check a default has been set and set it
				if(!isset($option->attributes))
				{
					$option->attributes = array(
						'class' => '',
						'id'	=> ''
					);
				}

				if($this->is_option_selected($option, $input_args['defaults']))
				{
					$option->attributes['selected'] = 'selected';
					$option->attributes['class'] = trim($option->attributes['class']).' sf-option-active';
				}
				else
				{
					if(isset($option->attributes['selected']))
					{
						unset($option->attributes['selected']);
					}
				}
				
				$container_attibutes_html = "";
				if(isset($option->count))
				{
					$option->attributes['data-sf-count'] = $option->count;
				}
                $option->attributes['data-sf-depth'] = "0";

				//add padding to labels for anything hierarchical
				$label_pad = '';
				if(isset($option->depth))
				{
					$label_pad = str_repeat('&nbsp;', $option->depth * 3);
                    $option->attributes['data-sf-depth'] = $option->depth;
				}

                //create the attributes
                $option_attibutes_html = $this->convert_attributes_to_html($option->attributes);


                $option_label = $label_pad.$option->label;
				
			?>
			<option<?php echo $option_attibutes_html; ?> value="<?php echo esc_attr($option->value); ?>"><?php echo $option_label; ?></option>
			<?php
			}
			?>
		</select>
		</label><?php echo $postfix; ?>
		<?php
		
		$output = ob_get_clean();

		return $output;
	}
	
	
	public function checkbox($args)
	{
		//init defaults & vars
		$input_args = $this->prepare_input_args($args, "checkbox");
				
		$input_name = $input_args['attributes']['name'];
		unset($input_args['attributes']['name']);
		
		//filter the input arguments before the html is generated - allowing almost all options to be modified
		if(has_filter('sf_input_object_pre')) {
			$input_args = apply_filters('sf_input_object_pre', $input_args, $this->sfid);
		}
		
		//prepare html
		$attibutes_html = $this->convert_attributes_to_html($input_args['attributes']);
		
		$open_child_count = 0;
		
		ob_start();
		
		?>
		<ul<?php echo $attibutes_html; ?>>
			
			<?php
			
			$last_option_depth = 0;
			
			$option_count = count($input_args['options']);
			$current_depth = 0;
			
			$is_li_open = array();

			for($i=0; $i<$option_count; $i++)
			{
				$option = &$input_args['options'][$i];
				
				if(!isset($option->attributes))
				{
					$option->attributes = array(
						'class' => '',
						'id'	=> ''
					);
				}
				//check a default has been set and set it
				$option->attributes['type'] = "checkbox";
				$option->attributes['value'] = $option->value;
				$option->attributes['name'] = $input_name;
				
				$container_attributes = array();
				
				if($this->is_option_selected($option, $input_args['defaults']))
				{
					$option->attributes['checked'] = 'checked';
					$option->attributes['class'] = trim($option->attributes['class']).' sf-option-active';
				}
				else
				{
					if(isset($option->attributes['checked']))
					{
						unset($option->attributes['checked']);
					}
				}
				
				//now we want to put the class attribute on the LI, and remove from input
				$option_class = $option->attributes['class'];
				$option->attributes['class'] = $input_args['input_class'];
				
				$input_id = $this->generate_input_id($input_name."_".$option->value);
				$option->attributes['id'] = $input_id;
				
				$container_attibutes_html = "";
				if(isset($option->count))
				{
					$container_attributes['data-sf-count'] = $option->count;
				}

                $container_attributes['data-sf-depth'] = "0";
                if(isset($option->depth))
                {
                    $container_attributes['data-sf-depth'] = $option->depth;
                }

                $container_attibutes_html = $this->convert_attributes_to_html($container_attributes);

				//create the attributes
				$input_attibutes_html = $this->convert_attributes_to_html($option->attributes);
				$option_label = $option->label;

				echo '<li class="'.$option_class.'"'.$container_attibutes_html.'><input '.$input_attibutes_html.'><label class="sf-label-checkbox" for="'.$input_id.'">'.$option_label.'</label>';

				if(isset($option->depth))
				{//then we do depth calculations

					$current_depth = $option->depth;

					$close_li = true;
					$open_child_list = false;
					$close_ul = false;

					$next_depth = -1;

					if(isset($input_args['options'][$i+1]))
					{
						$next_option = $input_args['options'][$i+1];
						$next_depth = $next_option->depth;
					}

					if($next_depth!=-1)
					{
						if($next_depth!=$current_depth)
						{//there is a change in depth

							if($next_depth>$current_depth)
							{//then we need to open a child list
								//and, not close the current li
								$open_child_list = true;
								$close_li = false;
							}
							else
							{
								$close_ul = true;
							}
						}
					}

					if($open_child_list)
					{
						$open_child_count++;
						echo '<ul class="children">';
					}
					if($close_li)
					{
						echo "</li>";
					}
					if($close_ul)
					{
						$diff = $current_depth - $next_depth;
						$open_child_count = $open_child_count - $diff;
						$str_repeat = str_repeat("</ul></li>", $diff);
						echo $str_repeat;
					}
				}
				else
				{
					echo "</li>";
				}
			}
			
			$str_repeat = str_repeat("</ul></li>", (int)$open_child_count);
			echo $str_repeat;
			
			?>
		</ul>
		<?php
		
		$output = ob_get_clean();
		
		return $output;
	}
	
	public function radio($args)
	{
		//init defaults & vars
		$input_args = $this->prepare_input_args($args, "radio");
				
		$input_name = $input_args['attributes']['name'];
		unset($input_args['attributes']['name']);
		
		//filter the input arguments before the html is generated - allowing almost all options to be modified
		if(has_filter('sf_input_object_pre')) {
			$input_args = apply_filters('sf_input_object_pre', $input_args, $this->sfid);
		}
		
		//prepare html
		$attibutes_html = $this->convert_attributes_to_html($input_args['attributes']);
		
		$open_child_count = 0;
		
		ob_start();
		
		?>
		<ul<?php echo $attibutes_html; ?>>
			
			<?php
			
			$last_option_depth = 0;
			
			$option_count = count($input_args['options']);
			$current_depth = 0;
			
			$is_li_open = array();
			//echo "<ul>";
			for($i=0; $i<$option_count; $i++)
			{
				$option = &$input_args['options'][$i];
				
				if(!isset($option->attributes))
				{
					$option->attributes = array(
						'class' => '',
						'id'	=> ''
					);
				}
				
				//check a default has been set and set it
				$option->attributes['type'] = "radio";
				$option->attributes['value'] = $option->value;
				$option->attributes['name'] = $input_name;
				
				if($this->is_option_selected($option, $input_args['defaults']))
				{
					$option->attributes['checked'] = 'checked';
					$option->attributes['class'] = trim($option->attributes['class']).' sf-option-active';
				}
				else
				{
					if(isset($option->attributes['checked']))
					{
						unset($option->attributes['checked']);
					}
				}
				
				//now we want to put the class attribute on the LI, and remove from input
				$option_class = $option->attributes['class'];
				$option->attributes['class'] = $input_args['input_class'];
				
				$input_id = $this->generate_input_id($input_name."_".$option->value);
				$option->attributes['id'] = $input_id;
				
				$container_attibutes_html = "";
				if(isset($option->count))
				{
					$container_attributes = array(
						'data-sf-count' 	=> $option->count
					);
				}

                $container_attributes['data-sf-depth'] = "0";
                if(isset($option->depth))
                {
                    $container_attributes['data-sf-depth'] = $option->depth;
                }

                $container_attibutes_html = $this->convert_attributes_to_html($container_attributes);

				//create the attributes
				$input_attibutes_html = $this->convert_attributes_to_html($option->attributes);
				$option_label = $option->label;
				
				echo '<li class="'.$option_class.'"'.$container_attibutes_html.'><input '.$input_attibutes_html.'><label class="sf-label-radio" for="'.$input_id.'">'.$option_label.'</label>';
				
				if(isset($option->depth))
				{//then we do depth calculations
					
					$current_depth = $option->depth;
					$close_li = true;
					$open_child_list = false;
					$close_ul = false;
					
					$next_depth = -1;
					
					if(isset($input_args['options'][$i+1]))
					{
						$next_option = $input_args['options'][$i+1];
						$next_depth = $next_option->depth;
					}
					
					if($next_depth!=-1)
					{
						if($next_depth!=$current_depth)
						{//there is a change in depth
							
							if($next_depth>$current_depth)
							{//then we need to open a child list
								//and, not close the current li
								$open_child_list = true;
								$close_li = false;
							}
							else
							{
								$close_ul = true;
							}
						}
					}
					
					if($open_child_list)
					{
						$open_child_count++;
						echo '<ul class="children">';
					}
					if($close_li)
					{
						echo "</li>";
					}
					if($close_ul)
					{
						$diff = $current_depth - $next_depth;
						$open_child_count = $open_child_count - $diff;
						$str_repeat = str_repeat("</ul></li>", $diff);
						echo $str_repeat;
						
					}
				}
				else
				{
					echo "</li>";
				}
			}
			
			//close any child lists we may not have accounted for
			$str_repeat = str_repeat("</ul></li>", (int)$open_child_count);
			echo $str_repeat;
			
			?>
		</ul>
		<?php
		
		$output = ob_get_clean();
		
		return $output;
	}
	
	private function generate_input_id($unique_name)
	{
		global $searchandfilter;
		$sf_instance_count = $searchandfilter->get_form_count($this->sfid);
		
		//use count + time, because on page load, time (md5'd) seems to remain the same - via ajax count will always be set to 1, however time will keep this unique
		//return SF_CLASS_PRE."input-".md5($this->sfid.$unique_name);
		
		return SF_CLASS_PRE."input-".md5($this->sfid.'_'.$sf_instance_count.'_'.time().'_'.$unique_name);
	}
	
	//this just some basic stuff like adding a name attribute to a field and the basic CSS class that needs to be added
	private function is_option_selected($option, $defaults)
	{
		//first grab the comparison value from this option
		$select_value = ""; //selected value allows another value for matching occur, or "selected status" to be applied.
		if(isset($option->selected_value))
		{
			$select_value = $option->selected_value;
		}
		else
		{
			$select_value = $option->value;
		}
		
		$no_selected_options = count($defaults);

		if($no_selected_options>0)
		{
			if(in_array((string)$select_value, $defaults))
			{
				return true;
			}
		}
		
		return false;
	}
	
	
	
	public function range_slider($args)
	{
		$field_name = $args['name'];
		
		$args = $this->prepare_range_args($args, "slider");
		
		if($args['number_display_values_as']=="text") {

			$input_class = 'sf-text-number';
			$value_min_html = $args['prefix'].'<span class="sf-range-min '.$input_class.'">'.$args['attributes']['data-start-min-formatted'].'</span>'.$args['postfix'];
			$value_max_html = $args['prefix'].'<span class="sf-range-max '.$input_class.'">'.$args['attributes']['data-start-max-formatted'].'</span>'.$args['postfix'];
		}
		else {
			//setup input/text fields
			
			//setup vars in common with both fields
			if(($args['decimal_places']==0)&&($args['thousand_seperator']=="")) //if there is no formatting to display, then we can use number input type - a bit cooler
			{
				$input_type = "number";
			}
			else
			{
				$input_type = "text";	
			}
			
			$accessibility_label = "";
			if(isset($args['accessibility_label']))
			{
				$accessibility_label = $args['accessibility_label'];
			}
			
			$text_args = array(
				'name'						=> $args['name'],
				'value'						=> '',
				'accessibility_label'		=> $accessibility_label,
				'type'						=> $input_type,
				'attributes'				=> array(
						'class' => 'sf-input-range-number'
				)
			);
			
			if($input_type=="number")
			{
				$text_args['attributes']['min'] = $args['attributes']['data-min'];
				$text_args['attributes']['max'] = $args['attributes']['data-max'];
				$text_args['attributes']['step'] = $args['attributes']['data-step'];
			}
			
			$text_args['prefix'] = $args['prefix'];
			$text_args['postfix'] = $args['postfix'];
			
			//now setup the min / max vars for the fields
			$text_field_min = $text_args;
			$text_field_min['value'] = $args['attributes']['data-start-min-formatted'];
			$text_field_min['attributes']['class'] .= ' sf-range-min';
			
			$text_field_max = $text_args;
			$text_field_max['value'] = $args['attributes']['data-start-max-formatted'];
			$text_field_max['attributes']['class'] .= ' sf-range-max';
			
			$value_min_html = $this->text($text_field_min);
			$value_max_html = $this->text($text_field_max);
		}
		
		//prepare html
		$attibutes_html = $this->convert_attributes_to_html($args['attributes']);
		
		ob_start();
		
		?>
		<div <?php echo $attibutes_html; ?>>
		
			<?php echo $value_min_html; ?><span class="sf-range-values-seperator"><?php echo $args['number_values_seperator']; ?></span><?php echo $value_max_html; ?>
			
			<div class="meta-slider"></div>
		</div>
		<?php
		
		$output = ob_get_clean();
		
		return $output;
	}
	
	public function range_radio($args)
	{
		$output = "";
		
		$field_name = $args['name'];
		
		$args = $this->prepare_range_args($args, "radio");
		
		
		$args['attributes']['class'] .= ' sf-meta-range-radio-fromto';
		//create the input fields
		$input_type = "radio";
		$radio_args = array(
			'name'			=> $args['name'],
			'value'			=> '',
			'options'		=> $args['options'],
			'type'			=> $input_type,
			'attributes'	=> array(
					'class' => 'sf-input-range-radio'
			)
		);
				
		$radio_args['prefix'] = $args['prefix'];
		$radio_args['postfix'] = $args['postfix'];
		
		//now setup the min / max vars for the fields
		$radio_field_min = $radio_args;
		$radio_field_min['name'] = $args['name'].'_min';
		$radio_field_min['attributes']['class'] .= ' sf-range-min';
		$radio_field_min['defaults'] = array($args['attributes']['data-start-min']);
		
		$radio_field_max = $radio_args;
		$radio_field_max['name'] = $args['name'].'_max';
		$radio_field_max['attributes']['class'] .= ' sf-range-max';
		$radio_field_max['defaults'] = array($args['attributes']['data-start-max']);
		
		$value_min_html = $this->radio($radio_field_min);
		$value_max_html = $this->radio($radio_field_max);
		
		//prepare html
		$attibutes_html = $this->convert_attributes_to_html($args['attributes']);
		ob_start();
		
		?>
		<div <?php echo $attibutes_html; ?>>
		
			<?php echo $value_min_html; ?><span class="sf-range-values-seperator"><?php echo $args['number_values_seperator']; ?></span><?php echo $value_max_html; ?>
			
		</div>
		<?php
		
		$output = ob_get_clean();
		
		return $output;
	}
	
	public function range_select($args)
	{
		$output = "";
		
		$field_name = $args['name'];
		
		$args = $this->prepare_range_args($args, "select");
		
		$args['attributes']['class'] .= ' sf-meta-range-select-fromto';
		
		//create the input fields
		$input_type = "select";
		
		$accessibility_label = "";
		if(isset($args['accessibility_label']))
		{
			$accessibility_label = $args['accessibility_label'];
		}
		
		$select_args = array(
			'name'			=> $args['name'],
			'value'			=> '',
			'accessibility_label'			=> $accessibility_label,
			'options'		=> $args['options'],
			'type'			=> $input_type,
			'attributes'	=> array(
					'class' => 'sf-input-range-select'
			)
		);
				
		$select_args['prefix'] = $args['prefix'];
		$select_args['postfix'] = $args['postfix'];
		
		//now setup the min / max vars for the fields
		$select_field_min = $select_args;
		$select_field_min['name'] = $args['name'].'_min';
		$select_field_min['attributes']['class'] .= ' sf-range-min';
		$select_field_min['defaults'] = array($args['default_min']);
		
		$select_field_max = $select_args;
		$select_field_max['name'] = $args['name'].'_max';
		$select_field_max['attributes']['class'] .= ' sf-range-max';
		$select_field_max['defaults'] = array($args['default_max']);

		$value_min_html = $this->select($select_field_min);
		$value_max_html = $this->select($select_field_max);
		
		//prepare html
		$attibutes_html = $this->convert_attributes_to_html($args['attributes']);
		ob_start();
		
		?>
		<div <?php echo $attibutes_html; ?>>
			<?php echo $value_min_html; ?><span class="sf-range-values-seperator"><?php echo $args['number_values_seperator']; ?></span><?php echo $value_max_html; ?>
		</div>
		<?php
		
		$output = ob_get_clean();
		
		return $output;
	}
	
	public function range_number($args)
	{
		$output = "";
		
		$field_name = $args['name'];
		
		$args = $this->prepare_range_args($args, "number");
		
		//create the input fields
		$input_type = "number";
		
		$accessibility_label = "";
		if(isset($args['accessibility_label']))
		{
			$accessibility_label = $args['accessibility_label'];
		}
		
		$text_args = array(
			'name'			=> $args['name'],
			'value'			=> '',
			'accessibility_label'			=> $accessibility_label,
			'type'			=> $input_type,
			'attributes'	=> array(
					'class' => 'sf-input-range-number',
					'min'	=> $args['attributes']['data-min'],
					'max'	=> $args['attributes']['data-max'],
					'step'	=> $args['attributes']['data-step']
			)
		);
				
		$text_args['prefix'] = $args['prefix'];
		$text_args['postfix'] = $args['postfix'];
		
		//now setup the min / max vars for the fields
		$text_field_min = $text_args;
		$text_field_min['value'] = $args['attributes']['data-start-min'];
		$text_field_min['attributes']['class'] .= ' sf-range-min';
		
		$text_field_max = $text_args;
		$text_field_max['value'] = $args['attributes']['data-start-max'];
		$text_field_max['attributes']['class'] .= ' sf-range-max';
		
		$value_min_html = $this->text($text_field_min);
		$value_max_html = $this->text($text_field_max);
		
		
		//prepare html
		$attibutes_html = $this->convert_attributes_to_html($args['attributes']);
		ob_start();
		
		?>
		<div <?php echo $attibutes_html; ?>>
		
			<?php echo $value_min_html; ?><span class="sf-range-values-seperator"><?php echo $args['number_values_seperator']; ?></span><?php echo $value_max_html; ?>
			
		</div>
		<?php
		
		$output = ob_get_clean();
		
		return $output;
		
	}
	
	private function prepare_range_args($args, $type)
	{
		
		//ensure that min is not bigger than max (causes errors in noUIslider):
		if($args['default_max']<$args['default_min'])
		{
			$args['default_max'] = $args['default_min'];
		}
		
		if(!isset($args['attributes']))
		{
			$args['attributes'] = array();
		}
		
		$args['attributes']['data-start-min'] = $args['default_min'];
		$args['attributes']['data-start-max'] = $args['default_max'];
		$args['attributes']['data-start-min-formatted'] = $args['default_min_formatted'];
		$args['attributes']['data-start-max-formatted'] = $args['default_max_formatted'];
		$args['attributes']['data-min'] = $args['range_min'];
		$args['attributes']['data-max'] = $args['range_max'];
		$args['attributes']['data-step'] = $args['range_step'];
		$args['attributes']['data-decimal-places'] = $args['decimal_places'];
		$args['attributes']['data-thousand-seperator'] = $args['thousand_seperator'];
		$args['attributes']['data-decimal-seperator'] = $args['decimal_seperator'];
		$args['attributes']['data-display-values-as'] = $args['number_display_values_as'];
		$args['attributes']['data-sf-field-name'] = $args['name'];
		$args['attributes']['class'] = 'sf-meta-range sf-meta-range-'.$type;
		
		$args['prefix'] = "";
		$args['postfix'] = "";
		
		if(isset($args['range_value_prefix']))
		{
			if($args['range_value_prefix']!="")
			{
				$args['prefix'] = "<span class='".SF_CLASS_PRE."range-prefix'>".$args['range_value_prefix']."</span>";
			}
		}
		
		if(isset($args['range_value_postfix']))
		{
			if($args['range_value_postfix']!="")
			{
				$args['postfix'] = "<span class='".SF_CLASS_PRE."range-postfix'>".$args['range_value_postfix']."</span>";
			}
		}
		
		$args['type'] = "range-".$type;
		
		//filter the input arguments before the html is generated - allowing almost all options to be modified
		if(has_filter('sf_input_object_pre')) {
			$args = apply_filters('sf_input_object_pre', $args, $this->sfid);
		}
		
		
		
		return $args;
	}
	
	
	private function prepare_input_args($args, $type)
	{
		//init defaults
		$default_args = array(
			'name'					=> '',
			'defaults'				=> array(),
			'options'				=> array(),
			'attributes'			=> array(),
			'accessibility_label'	=> ''
		);
		
		$input_args = array_replace($default_args, $args); //replace defaults with $args
		
		
		$input_args['attributes']['name'] = $input_args['name'].'[]'; //setup name attribute
		
		//add required class to attributes list
		if(!isset($input_args['attributes']['class']))
		{
			$input_args['attributes']['class'] = '';
		}
		//$input_args['attributes']['class'] .= ' '.SF_CLASS_PRE."input-".$type;
		
		if(!isset($input_args['type']))
		{
			$input_args['type'] = $type;
		}
		
		$input_args['input_class'] = SF_CLASS_PRE."input-".$input_args['type'];
		
		//$input_args['attributes']['class'] = trim($input_args['attributes']['class']);
		
		return $input_args;
	}
	
	
	public function convert_attributes_to_html($attributes)
	{
		$attibutes_html = '';
		
		if(is_array($attributes))
		{
			foreach($attributes as $attribute_name => $attribute_val)
			{
				$attibutes_html .= ' '.$attribute_name.'="'.esc_attr($attribute_val).'"';
			}
		}
		
		return $attibutes_html;
	}
	
}

