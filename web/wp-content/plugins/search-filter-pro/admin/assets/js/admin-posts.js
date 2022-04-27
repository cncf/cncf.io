(function ( $ ) {
	"use strict";

	$(function () {
		/* metabox processing :) */
		
		//thickbox mods
		jQuery.fn.SfPopupMeta = function(options)
		{
			var defaults = {
				startOpened: false
			};
			var opts = jQuery.extend(defaults, options);
			
			//loop through each item matched
			$(this).each(function()
			{
				var item = $(this);
				
				var $widget_ref = $(this).closest('.widget');
				var $meta_options_list = $widget_ref.find('.meta_options_list');
				
				
				function getMetaKeyValues(meta_key, $target)
				{
					
					var meta_prefs_action_name = "get_meta_values";
					
					$.post( ajaxurl, {meta_key: meta_key, action: meta_prefs_action_name}).done(function(data)
					{//don't do anything
						
						if(data)
						{
							$target.html(data);
						}
					});
					
				}
				
				function getMetaKey($this)
				{
					/* ***************** */
					var $the_field = $this.closest(".widget");
					var $meta_key_manual_toggle  = $the_field.find(".meta_key_manual_toggle");
					var $meta_key_manual  = $the_field.find(".meta_key_manual");
					var $meta_key = $the_field.find(".choice_meta_key");
					
					var meta_key_value = $meta_key.val();
					
					if(meta_key_value!="")
					{
						return meta_key_value;
					}
					else 
					{
						return "";
					}
				}
				
				item.on( 'click', function()
				{
					//add overlay
					var $overlay = jQuery('<div/>', {
						id: 'foo',
						'class': 'sf-thickbox-overlay',
					}).appendTo('body');
					
					//add popup div
					var $popup = jQuery('<div/>', {
						'class': 'sf-thickbox',
					}).appendTo('body');
					
					var popup_hd_str = "";
					popup_hd_str += '<div class="sf-thickbox-title">';
					popup_hd_str += '<div class="sf-ajax-window-title"></div>';
					popup_hd_str += '<div class="sf-thickbox-title-inner">Add Options</div>';
					popup_hd_str += '<div class="sf-close-ajax-window">';
					popup_hd_str += '<a href="#" id="TB_closeWindowButton" name="TB_closeWindowButton"></a>';
					popup_hd_str += '<div class="sf-close-icon"></div>';
					popup_hd_str += '</div>';
					popup_hd_str += '</div>';
					
					/* init content */
					var meta_key = getMetaKey($(this));
					
					var popup_content_str = "";
					popup_content_str += '<div class="sf-ajax-content">';
					popup_content_str += '<p>Found the following values in use for meta key `<strong>'+meta_key+'</strong>`</p>';
					popup_content_str += '<p class="sf-thickbox-content">';
					popup_content_str += '<span class="spinner" style="display: block; float:left; text-align:left;"></span>';
					popup_content_str += '</p>';
					popup_content_str += '</div>';
					
					var popup_ft_str = "";
					popup_ft_str += '<div class="sf-thickbox-frame-toolbar">';
					popup_ft_str += '<div class="sf-thickbox-toolbar">';
					popup_ft_str += '<p><a href="#" class="button-secondary sf-meta-select-none">Select None</a> <a href="#" class="button-secondary sf-meta-select-all">Select All</a> <a href="#" class="button-primary sf-thickbox-action-right sf-meta-add-options">Add Options</a> <label class="replace-meta-options-label">Replace current options? &nbsp;<input type="checkbox" class="replace-options-checkbox" /></label></p>';
					popup_ft_str += '</div>';
					popup_ft_str += '</div>';
					
					var $popup_header = $(popup_hd_str);
					var $popup_content = $(popup_content_str);
					var $popup_footer = $(popup_ft_str);
					
					$popup.append($popup_header);
					$popup.append($popup_content);
					$popup.append($popup_footer);
					
					var $close_button = $popup_header.find(".sf-close-ajax-window");
					$close_button.on( 'click', function()
					{
						$('.sf-thickbox-overlay').remove();
						$popup.remove();
						
					});
					
					var $select_none_button = $popup_footer.find(".sf-meta-select-none");
					$select_none_button.on( 'click', function()
					{
						$popup_content.find('.sf-thickbox-content input[type="checkbox"]').each(function(){
						
							this.checked = false;							
						});
						
						return false;
						
					});
					
					var $select_all_button = $popup_footer.find(".sf-meta-select-all");
					$select_all_button.on( 'click', function()
					{
						$popup_content.find('.sf-thickbox-content input[type="checkbox"]').each(function(){
						
							this.checked = true;							
						});
						
						return false;
						
					});
					
					var $add_options_button = $popup_footer.find(".sf-meta-add-options");
					$add_options_button.on( 'click', function()
					{
						var $no_sort_label = $widget_ref.find(".no_sort_label");
						var $replace_options_checkbox = $popup_footer.find('.replace-options-checkbox');
						var $checked_options = $popup_content.find('.sf-thickbox-content input[type="checkbox"]:checked');
						
						if($checked_options.length>0)
						{
							if($replace_options_checkbox.prop('checked'))
							{
								var $meta_options = $meta_options_list.find("li:not(.meta-option-template)");
								
								$meta_options.each(function(){
									
									var $meta_option = $(this);
									
									$meta_option.slideUp("fast",function(){
										$meta_option.remove();
										
										if($meta_options_list.find("li:not(.meta-option-template)").length==0)
										{
											$no_sort_label.show();
										}
									});
								});
							}
							
							
							$checked_options.each(function(){
								
								var optionsId = $meta_options_list.find("li:not(.meta-option-template)").length;
								
								var $meta_option = $meta_options_list.find("li.meta-option-template").clone();
								$meta_option.removeClass("meta-option-template");
								
								setOptionVars($meta_option, $widget_ref.attr('data-widget-id'), optionsId);
								$meta_options_list.append($meta_option);
								$meta_option.slideDown("fast");
								
								$meta_option.find('input[type="text"]').val($(this).val());
								
								initMetaOptionControls($meta_option, $meta_options_list, $no_sort_label);
								
								$no_sort_label.hide();
								
								
								this.checked = true;					
							});
						}
						
						//hide popup
						$('.sf-thickbox-overlay').remove();
						$popup.remove();
						
						return false;
						
					});
					
					getMetaKeyValues(meta_key, $popup_content.find(".sf-thickbox-content"));
					
					
					return false;
					
					
				});
				
			});
		}
		
		jQuery.fn.SfPopupTax = function(options)
		{
			var defaults = {
				startOpened: false
			};
			var opts = jQuery.extend(defaults, options);
			
			//loop through each item matched
			$(this).each(function()
			{
				function getTaxonomyTerms(taxonomy_name, taxonomy_ids, $target)
				{
					var action_name = "get_taxonomy_terms";
					
					$.get( ajaxurl+"?action="+action_name+"&taxonomy_name="+taxonomy_name+"&taxonomy_ids="+taxonomy_ids ).done(function(data)
					{//don't do anything
						
						if(data)
						{
							$target.html(data);
						}
					});
				}
				
				var item = $(this);
				
				if(item.attr("data-init-popup") != 1)
				{
					item.attr("data-init-popup", 1);
										
					item.on( 'click', function()
					{
						if(!item.hasClass("disabled"))
						{
							//add overlay
							var $overlay = jQuery('<div/>', {
								id: 'foo',
								'class': 'sf-thickbox-overlay',
							}).appendTo('body');
							
							//add popup div
							var $popup = jQuery('<div/>', {
								'class': 'sf-thickbox',
							}).appendTo('body');
							
							var popup_hd_str = "";
							popup_hd_str += '<div class="sf-thickbox-title">';
							popup_hd_str += '<div class=".sf-ajax-window-title"></div>';
							popup_hd_str += '<div class="sf-thickbox-title-inner">Update Terms</div>';
							popup_hd_str += '<div class="sf-close-ajax-window">';
							popup_hd_str += '<a href="#" id="TB_closeWindowButton" name="TB_closeWindowButton"></a>';
							popup_hd_str += '<div class="sf-close-icon"></div>';
							popup_hd_str += '</div>';
							popup_hd_str += '</div>';
							
							/* init content */
							var taxonomy_name = $(this).attr("data-taxonomy-name");
							var taxonomy_label = $(this).attr("data-taxonomy-label");
							var taxonomy_ids = $(this).parent().find(".settings_exclude_ids").val();
							var $this = $(this);
							
							var popup_content_str = "";
							popup_content_str += '<div class="sf-ajax-content">';
							popup_content_str += '<p>Choose the terms to include/exclude for `<strong>'+taxonomy_label+'</strong>`</p>';
							popup_content_str += '<p class="sf-thickbox-content">';
							popup_content_str += '<span class="spinner" style="display: block; float:left; text-align:left;"></span>';
							popup_content_str += '</p>';
							popup_content_str += '</div>';
							
							var popup_ft_str = "";
							popup_ft_str += '<div class="sf-thickbox-frame-toolbar">';
							popup_ft_str += '<div class="sf-thickbox-toolbar">';
							popup_ft_str += '<p><a href="#" class="button-secondary sf-meta-select-none">Select None</a> <a href="#" class="button-secondary sf-meta-select-all">Select All</a> <a href="#" class="button-primary sf-thickbox-action-right sf-update-button">Update</a></p>';
							popup_ft_str += '</div>';
							popup_ft_str += '</div>';
							
							var $popup_header = $(popup_hd_str);
							var $popup_content = $(popup_content_str);
							var $popup_footer = $(popup_ft_str);
							
							$popup.append($popup_header);
							$popup.append($popup_content);
							$popup.append($popup_footer);
							
							var $close_button = $popup_header.find(".sf-close-ajax-window");
							$close_button.on( 'click', function()
							{
								$('.sf-thickbox-overlay').remove();
								$popup.remove();
								
							});
							
							var $select_none_button = $popup_footer.find(".sf-meta-select-none");
							$select_none_button.on( 'click', function()
							{
								$popup_content.find('.sf-thickbox-content input[type="checkbox"]').each(function(){
								
									this.checked = false;							
								});
								
								return false;
								
							});
							
							var $select_all_button = $popup_footer.find(".sf-meta-select-all");
							$select_all_button.on( 'click', function()
							{
								$popup_content.find('.sf-thickbox-content input[type="checkbox"]').each(function(){
								
									this.checked = true;							
								});
								
								return false;
								
							});
							
							var $update_button = $popup_footer.find(".sf-update-button");
							
							$update_button.on( 'click', function()
							{
								var $replace_options_checkbox = $popup_footer.find('.replace-options-checkbox');
								var $checked_options = $popup_content.find('.sf-thickbox-content input[type="checkbox"]:checked');
								
								var checkedIds = [];
														
								if($checked_options.length>0)
								{
									$checked_options.each(function(){
										
										checkedIds.push($(this).val());
									});
								}
								
								var checkedStr = "";
								
								if(checkedIds.length>0)
								{
									checkedStr = checkedIds.join(',');
								}
								
								$this.parent().find(".settings_exclude_ids").val(checkedStr);
								
								//hide popup
								$('.sf-thickbox-overlay').remove();
								$popup.remove();
								
								return false;
								
							});
							
							getTaxonomyTerms(taxonomy_name, taxonomy_ids, $popup_content.find(".sf-thickbox-content"));
							
						}
						
						return false;
						
						
					});
				}
			});
		}
		
		String.prototype.parseArray = function (arr) {
			return this.replace(/\{([0-9]+)\}/g, function (_, index) { return arr[index]; });
		};
		
		String.prototype.parse = function (a, b, c) {
			return this.parseArray([a, b, c]);
		};
		$.fn.hasAttr = function(name) {  
		   return this.attr(name) !== undefined;
		};
		
		var $search_tax_button = $('#search-filter-settings-box .search-tax-button');
		$search_tax_button.SfPopupTax();
		
		
		$("#search-filter-search-form").addClass("widgets-search-filter-sortables").addClass("ui-search-filter-sortable");
		
		//create all default handlers, open/close/delete/save
		jQuery.fn.makeWidget = function(options)
		{
			var defaults = {
				startOpened: false
			};
			var opts = jQuery.extend(defaults, options);
			
			//loop through each item matched
			this.each(function()
			{
				var item = $(this);
				item.addClass("widget-enabled");
				var field_type = item.attr("data-field-type");
				
				var itemInside = item.find('.widget-inside');
				
				if(opts.startOpened==true)
				{
					itemInside.show();
				}
				var container = item.parent();
			
				item.find('.widget-top').on( 'click', function(e){
					
					e.stopPropagation();
					e.preventDefault();
					
					var allowExpand = container.attr("data-allow-expand");
					if(typeof(allowExpand)=="undefined")
					{//init data-dragging if its not on already
						container.attr("data-allow-expand", "1");
						allowExpand = "1";
					}
					
					if(allowExpand==1)
					{					
						var dataDragging = item.attr("data-dragging");
						if(typeof(dataDragging)=="undefined")
						{//init data-dragging if its not on already
							item.attr("data-dragging", "0");
							dataDragging = "0";
						}
						
						if(dataDragging=="0") 
						{
							var is_open = item.find('.widget-top').attr("data-sf-field-open");
							if(typeof(is_open) == "undefined") {
								is_open = 0;
							}
							is_open = 1 - is_open;
                            item.find('.widget-top').attr("data-sf-field-open", is_open);

							itemInside.slideToggle("fast");
						}
					}
					
					return false;
				});
				
				item.find('.widget-control-remove').on( 'click', function(e){				
					
					item.slideUp("fast", function(){
						
						item.remove();
						if(item.length==1)
						{
							//$emptyPlaceholder.show();
						}
						
					});
					
					return false;
				});
				
				item.find('.widget-control-advanced').on( 'click', function(e){
				
					$(this).parent().find(".advanced-settings").slideToggle("fast");
					$(this).toggleClass("active");
					
					return false;
				});
				
				item.find('.widget-control-close').on( 'click', function(e){
				
					itemInside.slideUp("fast");
					
					return false;
				
				});
				
				//widget specific JS
				//categories
				if((field_type=="category")||(field_type=="tag")||(field_type=="taxonomy")||(field_type=="post_type"))
				{
					
					var $input_type_field = item.find('.sf_input_type select');
					
					// start off by showing/hiding correct fields
					showHideFields($input_type_field.val());
					
					//grab the input type
					$input_type_field.on( 'change', function(e)
					{
						var input_type = $(this).val();
						showHideFields(input_type);
						
					});
					
					var $combobox_container = item.find(".sf_make_combobox");
					var $combobox = item.find(".sf_make_combobox input:checkbox");

					$combobox.on( 'change', function()
					{
						var tinput_type = item.find('.sf_input_type select').val();
						
						if(tinput_type=="multiselect")
						{
							if($(this).prop("checked"))
							{
								item.find(".sf_all_items_label").show();
							}
							else
							{
								item.find(".sf_all_items_label").hide();
							}
						}

						if((tinput_type=="multiselect")||(tinput_type=="select")){
							if($(this).prop("checked")){
								item.find(".sf_combobox_message input").prop("disabled", false);
								item.find(".sf_combobox_message").css("opacity", 1);
							}
							else {
                                item.find(".sf_combobox_message input").prop("disabled", true);
                                item.find(".sf_combobox_message").css("opacity", 0.7);
							}
						}


					});
					
					var $tax_button = null;
					
					if(field_type!="post_type")
					{
						var $sync_include_exclude = item.find(".sync_include_exclude");
						
						$sync_include_exclude.on("change", function(){
							
							init_sync_checkbox($(this));
							
						});
						
						init_sync_checkbox($sync_include_exclude);
						
						$tax_button = item.find(".search-tax-button");
						
						if(field_type!="post_tag")
						{
							//include children
							var $operator_select = item.find(".sf_operator select");
							
						}
					}
					
					if(field_type=="taxonomy")
					{
						
						var $tsel = item.find('.sf_taxonomy_name select');
						var current_tax_name = $tsel.find("option[value='"+$tsel.val()+"']").html();
						
						
						$tax_button.attr('data-taxonomy-name', $tsel.val());
						$tax_button.attr('data-taxonomy-label', current_tax_name);
					}
					
					if(field_type!="post_type")
					{
						$tax_button.SfPopupTax();
					}
					
				}
				
				function init_sync_checkbox($this)
				{
					if($this.is(":checked"))
					{
						item.find(".exclude_ids").attr("disabled", "disabled");
						item.find(".exclude_ids_hidden").removeAttr("disabled");
						item.find(".exclude_ids_hidden").val(item.find(".exclude_ids").val());
						item.find(".search-tax-button").addClass("disabled");
						
					}
					else
					{
						item.find(".exclude_ids").removeAttr("disabled");
						item.find(".exclude_ids_hidden").attr("disabled", "disabled");
						item.find(".search-tax-button").removeClass("disabled");
					}
				}
				
				if(field_type=="author")
				{
					
					var $input_type_field = item.find('.sf_input_type select');
					
					// start off by showing/hiding correct fields
					showHideFieldsAuthor($input_type_field.val());
					
					var $combobox = item.find(".sf_make_combobox input:checkbox");
					
					$combobox.on( 'change', function()
					{
                        var tinput_type = item.find('.sf_input_type select').val();

                        if(tinput_type=="multiselect")
                        {
                            if($(this).prop("checked"))
                            {
                                item.find(".sf_all_items_label").show();
                            }
                            else
                            {
                                item.find(".sf_all_items_label").hide();
                            }
                        }

                        if((tinput_type=="multiselect")||(tinput_type=="select")){
                            if($(this).prop("checked")){
                                item.find(".sf_combobox_message input").prop("disabled", false);
                                item.find(".sf_combobox_message").css("opacity", 1);
                            }
                            else {
                                item.find(".sf_combobox_message input").prop("disabled", true);
                                item.find(".sf_combobox_message").css("opacity", 0.7);
                            }
                        }
					});
					
					
					//grab the input type
					$input_type_field.on( 'change', function(e)
					{
						var input_type = $(this).val();
						showHideFieldsAuthor(input_type);						
					});
				}
				
				if(field_type=="taxonomy")
				{
					var $taxonomy_select = item.find('.sf_taxonomy_name select');
					
					$taxonomy_select.on("change",function()
					{
						var current_tax_name = $taxonomy_select.find("option[value='"+$taxonomy_select.val()+"']").html();
						item.find('.in-widget-title').html(": &nbsp;"+current_tax_name);
						
						var $tax_button = item.find(".search-tax-button");
						$tax_button.attr('data-taxonomy-name', $(this).val());
						$tax_button.attr('data-taxonomy-label', current_tax_name);
					});
					
					var current_tax_name = $taxonomy_select.find("option[value='"+$taxonomy_select.val()+"']").html();
					item.find('.in-widget-title').html(": &nbsp;"+current_tax_name);
					
				}
				
				if(field_type=="sort_order")
				{
					setPostMetaManualFields();
					
					var $meta_key_manual_toggle = item.find('.meta_key_manual_toggle');
					
					var $input_type_field = item.find('.sf_input_type select');
					
					// start off by showing/hiding correct fields
					showHideFields($input_type_field.val());
					
					$input_type_field.on( 'change', function(e)
					{
						var input_type = $(this).val();
						showHideFields(input_type);
					});
					
					
					//grab the input type
					$meta_key_manual_toggle.on( 'change', function(e)
					{
						setPostMetaManualFields();
					});
				}
				
				if(field_type=="post_meta")
				{
					/* */
					
					var $use_same_toggle = item.find('.use_same_toggle');
					var $start_meta_key = item.find('.start_meta_key');
					
					$use_same_toggle.each(function(){
						
						setPostMetaUseSameFields($(this));
					});
					
					$use_same_toggle.on( 'change', function(e)
					{
						setPostMetaUseSameFields($(this));
					});
					$start_meta_key.on( 'change', function(e)
					{
						setPostMetaStartKey($(this));
					});
					
					
					/* number */
					
					// start off by showing/hiding correct fields
					
					//decimals toggle
					var $number_is_decimal = item.find('.number_is_decimal');
					var $number_decimal_places = item.find('.number_decimal_places');
					checkboxToggleDeps($number_is_decimal, $number_decimal_places);
					
					$number_is_decimal.on("change",function(){
						checkboxToggleDeps($(this), $number_decimal_places);
					});
					
					//min range toggle
					var $range_min_detect = item.find('.range_min_detect');
					var $range_min = item.find('.range_min');
					checkboxToggleDeps($range_min_detect, $range_min, true);
					
					$range_min_detect.on("change",function(){
						checkboxToggleDeps($(this), $range_min, true);
					});
					
					//max range toggle
					var $range_max_detect = item.find('.range_max_detect');
					var $range_max = item.find('.range_max');
					checkboxToggleDeps($range_max_detect, $range_max, true);
					
					$range_max_detect.on("change",function(){
						checkboxToggleDeps($(this), $range_max, true);
					});
					
					//input type field
					var $number_input_type_field = item.find('.sf_number_input_type select');
					
					showHideFieldsMetaNumber($number_input_type_field.val());
					$number_input_type_field.on( 'change', function(e)
					{
						var input_type = $(this).val();
						showHideFieldsMetaNumber(input_type);
					});
					
					var $sf_display_input_as = item.find('.sf_display_input_as select');
					showHideFieldsMetaNumberDisplayInputAs($sf_display_input_as.val());
					$sf_display_input_as.on( 'change', function(e)
					{
						var display_input_as = $(this).val();
						showHideFieldsMetaNumberDisplayInputAs(display_input_as);
					});
					
					/* choice */
					
					var $input_type_field = item.find('.sf_input_type select');
					
					// start off by showing/hiding correct fields
					
					showHideFields($input_type_field.val());
					
					$input_type_field.on( 'change', function(e)
					{
						var input_type = $(this).val();
						showHideFields(input_type);
					});
					
					var $input_type_field = item.find('.sf_input_type select');
					
					
					var $choice_get_options_field = item.find('.sf_choice_get_options select');
					var $choice_order_options_by_field = item.find('.sf_choice_order_options select.sf_choice_order_option_by');

					// start off by showing/hiding correct fields
					showHideFieldsMetaChoiceOptions($choice_get_options_field.val());
					$choice_get_options_field.on( 'change', function(e)
					{
						var input_type = $(this).val();
						showHideFieldsMetaChoiceOptions(input_type);
					});
					// start off by showing/hiding correct fields
					showHideFieldsMetaChoiceOrderBy($choice_order_options_by_field.val());
					$choice_order_options_by_field.on( 'change', function(e)
					{
						var input_type = $(this).val();
						showHideFieldsMetaChoiceOrderBy(input_type);
					});


					var $combobox = item.find(".sf_make_combobox input:checkbox");

					$combobox.on( 'change', function()
					{
						var tinput_type = item.find('.sf_input_type select').val();
						
						if(tinput_type=="multiselect")
						{
							if($(this).prop("checked"))
							{
								item.find(".sf_all_items_label").show();
							}
							else
							{
								item.find(".sf_all_items_label").hide();
							}
						}

						if((tinput_type=="multiselect")||(tinput_type=="select")){
							if($(this).prop("checked")){
								item.find(".sf_combobox_message input").prop("disabled", false);
								item.find(".sf_combobox_message").css("opacity", 1);
							}
							else {
                                item.find(".sf_combobox_message input").prop("disabled", true);
                                item.find(".sf_combobox_message").css("opacity", 0.7);
							}
						}


					});
					
					/* date */
					var $date_input_type = item.find('.sf_date_input select');
					
					// start off by showing/hiding correct fields
					showHideFields($date_input_type.val());
					
					$date_input_type.on( 'change', function(e)
					{
						var input_type = $(this).val();
						showHideFields(input_type);
					});
					
					
					
					
					var $combobox = item.find(".sf_make_combobox input:checkbox");
					
					$combobox.on( 'change', function()
					{
						var tinput_type = $(this).parent().parent().find('.sf_input_type select').val();
						
						if(tinput_type=="multiselect")
						{
							if($(this).prop("checked"))
							{
								item.find(".sf_all_items_label").show();
							}
							else
							{
								item.find(".sf_all_items_label").hide();
							}
						}
					});
					
					
					//grab the input type
					
				}
				
				if(field_type=="sort_order")
				{
					var $add_sort_button = item.find(".add-sort-button");
					var $clear_option_button = item.find(".clear-option-button");
					var $sort_options_list = item.find(".sort_options_list");
					var $no_sort_label = item.find(".no_sort_label");
					
					var $current_sort_options = $sort_options_list.find("li:not(.sort-option-template)");
					$current_sort_options.show();
					
					if($current_sort_options.length>0)
					{

						 $no_sort_label.hide();
					}
					
					$current_sort_options.each(function(){
						
						initSortOptionControls($(this), $sort_options_list, $no_sort_label);
						
					});					
					
					$sort_options_list.sortable({
						opacity: 0.6,
						//revert: 200,
						revert: false,
						cursor: 'move',
						handle: '.slimmove',
						//cancel: '.widget-title-action,h3,.sidebar-description',
						items: 'li:not(.sort-option-template)',
						placeholder: 'sort-option-placeholder',
						'start': function (event, ui) {
							ui.placeholder.show();
						},
						stop: function(e,ui) {
							
							var optionsCount = 0;
							var $sort_options_list = ui.item.find(".sort_options_list");
							var widgetCount = ui.item.attr("data-widget-id");
							
							$sort_options_list.find("li:not(.sort-option-template)").each(function()
							{
								
								setOptionVars($(this), widgetCount, optionsCount);
								optionsCount++;
							
							});
						}
					});
					
					$clear_option_button.on( 'click', function(){
					
						
						var $sort_options = $sort_options_list.find("li:not(.sort-option-template)");
								
						$sort_options.each(function(){
							
							var $sort_option = $(this);
							
							$sort_option.slideUp("fast",function(){
								$sort_option.remove();
								
								if($sort_options_list.find("li:not(.sort-option-template)").length==0)
								{
									$no_sort_label.show();
								}
							});
						});
						
						return false;
					
					});
					
					$add_sort_button.on( 'click', function(){
					
						
						var $meta_key_manual_toggle  = item.find(".meta_key_manual_toggle");
						var $meta_key_manual  = item.find(".meta_key_manual");
						var $meta_key = item.find(".meta_key");
						
						var meta_key_value = $meta_key.val();
						
						if($meta_key_manual_toggle.is(":checked"))
						{
							meta_key_value = $meta_key_manual.val();
						}
						
						if(meta_key_value!="")
						{
							//reset meta fields
							$meta_key.removeAttr("selected");
							$meta_key[0].selectedIndex = 0;
							$meta_key_manual.val("");
							$meta_key_manual_toggle.prop("checked", false);
							$meta_key.removeAttr("disabled");
							$meta_key_manual.attr("disabled", "disabled");
							
							
							var optionsId = $sort_options_list.find("li:not(.sort-option-template)").length;
							
							var option_html = "";
							
							var $sort_option = $sort_options_list.find("li.sort-option-template").clone();
							$sort_option.removeClass("sort-option-template");
							$sort_option.hide();
							$sort_option.find(".meta_key_val, .meta_disabled, .name").val(meta_key_value);
							
							setOptionVars($sort_option, item.attr('data-widget-id'), optionsId);
							
							var $sort_by_option = $sort_option.find(".sort_by_option");
							
							if($sort_by_option.val()=="meta_value")
							{
								$sort_option.find('.sort-options-advanced').show();
							}
							else
							{
								$sort_option.find('.sort-options-advanced').hide();
							}
							
							$sort_options_list.append($sort_option);
							$sort_option.slideDown("fast");
							
							initSortOptionControls($sort_option, $sort_options_list, $no_sort_label);
							
							$no_sort_label.hide();
							
						}
						return false;
					
					});
				}
				
				if(field_type=="post_meta")
				{
					/* init meta type radios */
					/* set up meta type radios */
					var $meta_type_radio = item.find('.sf_meta_type input[type="radio"]');
					var $meta_type_labels = item.find('.sf_meta_type label');
					var $checked_radio = item.find('.sf_meta_type input[data-radio-checked="1"]');
					
					$meta_type_radio.each(function(){
						this.checked = false;
						$(this).attr("data-radio-checked", 0);
					});
					
					
					if($checked_radio.length==0)
					{
						$checked_radio = item.find(".sf_meta_type label:first-child input");
						
					}
					
					$checked_radio.attr("data-radio-checked", 1);
					$checked_radio.prop('checked',true);
					var meta_type_val = $checked_radio.val();
					
					metaTypeChange($checked_radio);
					
					$meta_type_radio.on( 'change', function()
					{
						$meta_type_radio.attr("data-radio-checked", 0);
						$(this).attr("data-radio-checked", 1);
						metaTypeChange($(this));
						
					});
					
					
					/* ****************************************************** */
					
					
					var $add_option_button = item.find(".add-option-button");
					var $detect_option_button = item.find(".detect-option-button");
					var $clear_option_button = item.find(".clear-option-button");
					var $meta_options_list = item.find(".meta_options_list");
					var $no_sort_label = item.find(".no_sort_label");
					
					var $current_meta_options = $meta_options_list.find("li:not(.meta-option-template)");
					
					$meta_options_list.sortable({
						opacity: 0.6,
						//revert: 200,
						revert: false,
						cursor: 'move',
						handle: '.slimmove',
						//cancel: '.widget-title-action,h3,.sidebar-description',
						items: 'li:not(.meta-option-template)',
						placeholder: 'meta-option-placeholder',
						'start': function (event, ui) {
							ui.placeholder.show();
						},
						stop: function(e,ui) {
							
							var optionsCount = 0;
							var $meta_options_list = ui.item.find(".meta_options_list");
							var widgetCount = ui.item.attr("data-widget-id");
							
							$meta_options_list.find("li:not(.meta-option-template)").each(function()
							{
								
								setOptionVars($(this), widgetCount, optionsCount);
								optionsCount++;
							
							});
							
						}
					});
					
					$current_meta_options.show();
					
					if($current_meta_options.length>0)
					{
						 $no_sort_label.hide();
					}
					
					$current_meta_options.each(function(){
						
						initMetaOptionControls($(this), $meta_options_list, $no_sort_label);
						
					});
					
					$add_option_button.on( 'click', function(){
					
						
						var $meta_key_manual_toggle  = item.find(".meta_key_manual_toggle");
						
						var optionsId = $meta_options_list.find("li:not(.meta-option-template)").length;
						
						var option_html = "";
						
						var $meta_option = $meta_options_list.find("li.meta-option-template").clone();
						$meta_option.removeClass("meta-option-template");
						
						//$meta_option.find(".meta_key_val, .meta_disabled, .name").val(meta_key_value);
						
						setOptionVars($meta_option, item.attr('data-widget-id'), optionsId);
						$meta_options_list.append($meta_option);
						$meta_option.slideDown("fast");
						
						initMetaOptionControls($meta_option, $meta_options_list, $no_sort_label);
						
						$no_sort_label.hide();
						
						
						return false;
					
					});
					
					
					$detect_option_button.SfPopupMeta();
					
					$clear_option_button.on( 'click', function(){
					
						
						var $meta_options = $meta_options_list.find("li:not(.meta-option-template)");
								
						$meta_options.each(function(){
							
							var $meta_option = $(this);
							
							$meta_option.slideUp("fast",function(){
								$meta_option.remove();
								
								if($meta_options_list.find("li:not(.meta-option-template)").length==0)
								{
									$no_sort_label.show();
								}
							});
						});
						
						return false;
					
					});
					
					/* adding meta keys to widget header */
					
					//item.find(".sf_field_data").hide();
					var $widget_title_triggers = item.find(".sf_meta_keys .start_meta_key, .sf_meta_keys .end_meta_key, .sf_meta_keys .choice_meta_key, .sf_meta_type input, .use_same_toggle, .sf_date_input select");
					$widget_title_triggers.on("change", function(){
						
						set_meta_widget_title(item);
						
					});
					
					set_meta_widget_title(item);
					
					
					
				}
				
				function set_meta_widget_title(item)
				{
					
					var $radio = item.find('.sf_meta_type input[data-radio-checked="1"]');
					var radio_val = $radio.val();
					
					var meta_string = "";
					var $meta_container = item.find(".sf_field_data.sf_"+radio_val);
					
					var $use_same_toggle = $meta_container.find('.use_same_toggle');
					
					if(radio_val=="choice")
					{
						meta_string = $meta_container.find(".sf_meta_keys .choice_meta_key").val();
					}
					else if(radio_val=="number")
					{//then there is only 1 meta key
						if($use_same_toggle.prop("checked")==true)
						{
							meta_string = $meta_container.find(".sf_meta_keys .start_meta_key").val();
						}
						else
						{
							var start_meta_val = $meta_container.find(".sf_meta_keys .start_meta_key").val();
							var end_meta_val = $meta_container.find(".sf_meta_keys .end_meta_key").val();
							meta_string = start_meta_val + " - " + end_meta_val;
						}
					}
					else if(radio_val=="date")
					{
						var dateInputType = $meta_container.find(".sf_date_input select");
						
						if(($use_same_toggle.prop("checked")==true)||(dateInputType.val()=="date"))
						{
							meta_string = $meta_container.find(".sf_meta_keys .start_meta_key").val();
						}
						else
						{
							var start_meta_val = $meta_container.find(".sf_meta_keys .start_meta_key").val();
							var end_meta_val = $meta_container.find(".sf_meta_keys .end_meta_key").val();
							meta_string = start_meta_val + " - " + end_meta_val;
						}
					}
					
					//meta_string = " "+meta_string+" &nbsp;&nbsp;<em><small>"+radio_val+"</em></small>";
					item.find('.in-widget-title').html(": &nbsp;"+meta_string);
					
				}
				function initSortOptionControls($sort_option, $sort_options_list, $no_sort_label)
				{
					var $sort_by_option = $sort_option.find(".sort_by_option");
					
					if($sort_by_option.val()=="meta_value")
					{
						$sort_option.find('.sort-options-advanced').show();
					}
					else
					{
						$sort_option.find('.sort-options-advanced').hide();
					}
					
					$sort_by_option.on( 'change', function()
					{
						if($(this).val()=="meta_value")
						{
							$sort_option.find('.sort-options-advanced').slideDown("fast");
						}
						else
						{
							$sort_option.find('.sort-options-advanced').slideUp("fast");
						}
					});
					
					$sort_option.find(".widget-control-option-remove").on( 'click', function(){
								
						$sort_option.slideUp("fast",function(){
							$sort_option.remove();
							
							if($sort_options_list.find("li:not(.sort-option-template)").length==0)
							{
								$no_sort_label.show();
							}
						});
						
						return false;
						
					});
					
					/*$advanced_button.on( 'click', function(){
						
						$(this).toggleClass("active");
						$sort_option.find('.sort-options-advanced').slideToggle("fast");
						return false;
						
					});*/
					
				}
				
				
				function setPostMetaStartKey($this)
				{
					var $start_meta_key = $this;
					var $use_same_parent = $this.closest(".sf_meta_keys");
					//var $end_key_select = $use_same_parent.find(".meta_key");
					var $end_key_select = $use_same_parent.next().find(".meta_key");
					var $use_same_toggle = $use_same_parent.next().find(".use_same_toggle");
					
					//$end_key_select
					
					if($use_same_toggle.prop("checked")==true)
					{
						$end_key_select.val($start_meta_key.val());
					}
				
				}
				
				function setPostMetaUseSameFields($this)
				{
					var $use_same_toggle = $this;
					var $use_same_parent = $this.closest(".sf_meta_keys");
					var $compare_mode = $use_same_parent.parent().find(".sf_compare_mode");
					var $end_key_select = $use_same_parent.find(".meta_key");
					var $start_key_select = $use_same_parent.prev().find(".start_meta_key");
					
					
					//$compare_mode.css("border", "1px solid #f00");
					//$end_key_select.css("border", "1px solid #0f0");
					//$use_same_parent.hide();
					
					if($use_same_toggle.is(":checked"))
					{
						$end_key_select.val($start_key_select.val());
						$end_key_select.prop("disabled", true);
						$compare_mode.hide();
					}
					else
					{
						$end_key_select.prop("disabled", false);
						$compare_mode.show();
					}
					
					/*
					var $meta_key_manual = item.find(".meta_key_manual");
					var $meta_key_manual_hidden = item.find(".meta_key_manual_hidden");
					var $meta_key = item.find(".meta_key");
					var $meta_key_hidden = item.find(".meta_key_hidden");
					
					
					if($meta_key_manual_toggle.is(":checked"))
					{
						$meta_key_manual.removeAttr("disabled");
						$meta_key_manual_hidden.attr("disabled", "disabled");
						
						$meta_key_hidden.removeAttr("disabled");
						$meta_key_hidden.val($meta_key.val());
						$meta_key.attr("disabled", "disabled");
						
						$meta_key_manual.focus();
					}
					else
					{
						$meta_key_manual_hidden.removeAttr("disabled");
						$meta_key_manual_hidden.val($meta_key_manual.val());
						$meta_key_manual.attr("disabled", "disabled");
						
						$meta_key.removeAttr("disabled");
						$meta_key_hidden.attr("disabled", "disabled");
					}*/

				}
				
				function setPostMetaManualFields()
				{
					var $meta_key_manual = item.find(".meta_key_manual");
					var $meta_key_manual_hidden = item.find(".meta_key_manual_hidden");
					var $meta_key = item.find(".meta_key");
					var $meta_key_hidden = item.find(".meta_key_hidden");
					var $meta_key_manual_toggle = item.find(".meta_key_manual_toggle");
					
					if($meta_key_manual_toggle.is(":checked"))
					{
						$meta_key_manual.removeAttr("disabled");
						$meta_key_manual_hidden.attr("disabled", "disabled");
						
						$meta_key_hidden.removeAttr("disabled");
						$meta_key_hidden.val($meta_key.val());
						$meta_key.attr("disabled", "disabled");
						
						$meta_key_manual.focus();
					}
					else
					{
						$meta_key_manual_hidden.removeAttr("disabled");
						$meta_key_manual_hidden.val($meta_key_manual.val());
						$meta_key_manual.attr("disabled", "disabled");
						
						$meta_key.removeAttr("disabled");
						$meta_key_hidden.attr("disabled", "disabled");
					}

				}
				
				function checkboxToggleDeps($self, $deps, reverse)
				{
					var reverse_dir = false;
					if(typeof(reverse)!="undefined")
					{
						reverse_dir = reverse;
					}
					
					var $inputs = $deps;
					
					if($self.is(":checked"))
					{
						//enable all fields
						$inputs.each(function(){
						
							var $input = $(this);
							
							if(!reverse_dir)
							{
								enableInput($input);
							}
							else
							{
								disableInput($input);
							}
							
						});
					}
					else
					{
						//disable all fields
						$inputs.each(function(){
						
							var $input = $(this);
							
							if(!reverse_dir)
							{
								disableInput($input);
							}
							else
							{
								enableInput($input);
							}
							
						});
						
					}
					
				}
				
				function showHideFieldsMetaNumber(input_type)
				{
					var $number_container = item.find(".sf_number");
					$number_container.attr('data-number-input-type', input_type);
				}
				
				function showHideFieldsMetaChoiceOptions(option_type)
				{
					var $choice_container = item.find(".sf_choice");
					$choice_container.attr('data-choice-get-options', option_type);
				}

				function showHideFieldsMetaChoiceOrderBy(option_type)
				{
					var $choice_container = item.find(".sf_choice");

                    //var $sf_choice_order_option_dir = $choice_container.find(".sf_choice_order_option_dir");
                    //var $sf_choice_order_option_type = $choice_container.find(".sf_choice_order_option_type");
                    var $sf_choice_order_option_dependants = $choice_container.find(".sf_choice_order_option_type, .sf_choice_order_option_dir");

					//$choice_container.attr('data-choice-order-by', option_type);

                    if(option_type=="none")
                    {
                        $sf_choice_order_option_dependants.prop("disabled", true);
                    }
                    else
                    {
                        $sf_choice_order_option_dependants.prop("disabled", false);
                    }

				}

				function showHideFieldsMetaNumberDisplayInputAs(display_input_as)
				{
					var $number_container = item.find(".sf_number");
					$number_container.attr('data-display-input-as', display_input_as);
				}
				
				function showHideFields(input_type)
				{
					if(input_type=="select")
					{
						item.find(".sf_operator").hide();
						item.find(".sf_drill_down").show();
						item.find(".sf_all_items_label").show();
						item.find(".sf_make_combobox").show();
						item.find(".sf_combobox_message").show();
						item.find(".sf_accessibility_label").show();

                        if(item.find(".sf_make_combobox input").prop("checked")) {
                            item.find(".sf_combobox_message input").prop("disabled", false);
							item.find(".sf_combobox_message").css("opacity", 1);
                        }
                        else{
                            item.find(".sf_combobox_message input").prop("disabled", true);
                            item.find(".sf_combobox_message").css("opacity", 0.7);
						}
					}
					else if(input_type=="checkbox")
					{
						item.find(".sf_operator").show();
						item.find(".sf_drill_down").hide();
						item.find(".sf_all_items_label").hide();
						item.find(".sf_make_combobox").hide();
                        item.find(".sf_combobox_message").hide();
						item.find(".sf_accessibility_label").hide();
					}
					else if(input_type=="radio")
					{
						item.find(".sf_operator").hide();
						item.find(".sf_drill_down").hide();
						item.find(".sf_make_combobox").hide();
                        item.find(".sf_combobox_message").hide();
						item.find(".sf_all_items_label").show();
						item.find(".sf_accessibility_label").hide();
					}
					else if(input_type=="multiselect")
					{
						item.find(".sf_operator").show();
						item.find(".sf_drill_down").hide();
						item.find(".sf_all_items_label").hide();
						item.find(".sf_make_combobox").show();
                        item.find(".sf_combobox_message").show();
						item.find(".sf_accessibility_label").show();
						
						if(item.find(".sf_make_combobox input").prop("checked"))
						{
							item.find(".sf_all_items_label").show();
						}

                        if(item.find(".sf_make_combobox input").prop("checked")) {
                            item.find(".sf_combobox_message input").prop("disabled", false);
                            item.find(".sf_combobox_message").css("opacity", 1);
                        }
                        else{
                            item.find(".sf_combobox_message input").prop("disabled", true);
                            item.find(".sf_combobox_message").css("opacity", 0.7);
                        }

					}
					else if(input_type=="date")
					{
						item.find(".sf_date_end_meta_key").hide();
						
					}
					else if(input_type=="daterange")
					{
						item.find(".sf_date_end_meta_key").show();
					}
					
				}
				function showHideFieldsAuthor(input_type)
				{
					if(input_type=="select")
					{
						//item.find(".sf_operator").hide();
						item.find(".sf_all_items_label").show();
						item.find(".sf_make_combobox").show();
                        item.find(".sf_combobox_message").show();
						item.find(".sf_accessibility_label").show();

                        if(item.find(".sf_make_combobox input").prop("checked")) {
                            item.find(".sf_combobox_message input").prop("disabled", false);
                            item.find(".sf_combobox_message").css("opacity", 1);
                        }
                        else{
                            item.find(".sf_combobox_message input").prop("disabled", true);
                            item.find(".sf_combobox_message").css("opacity", 0.7);
                        }
					}
					else if(input_type=="checkbox")
					{
						//item.find(".sf_operator").show();
						item.find(".sf_all_items_label").hide();
						item.find(".sf_make_combobox").hide();
                        item.find(".sf_combobox_message").hide();
						item.find(".sf_accessibility_label").hide();
					}
					else if(input_type=="radio")
					{
						//item.find(".sf_operator").hide();
						item.find(".sf_all_items_label").show();
						item.find(".sf_make_combobox").hide();
                        item.find(".sf_combobox_message").hide();
						item.find(".sf_accessibility_label").hide();
					}
					else if(input_type=="multiselect")
					{
						//item.find(".sf_operator").show();
						item.find(".sf_all_items_label").hide();
						item.find(".sf_make_combobox").show();
                        item.find(".sf_combobox_message").show();
						item.find(".sf_accessibility_label").show();
						
						if(item.find(".sf_make_combobox input").prop("checked"))
						{
							item.find(".sf_all_items_label").show();
						}

                        if(item.find(".sf_make_combobox input").prop("checked")) {
                            item.find(".sf_combobox_message input").prop("disabled", false);
                            item.find(".sf_combobox_message").css("opacity", 1);
                        }
                        else{
                            item.find(".sf_combobox_message input").prop("disabled", true);
                            item.find(".sf_combobox_message").css("opacity", 0.7);
                        }
					}
					
				}
			})
			
			return this;
		};
		
		jQuery.fn.makeSortables = function(options)
		{
			/*
			//initialise options
			var opts = jQuery.extend(defaults, options);
			*/
			
			setWidgetFormIds();
			
			//loop through each item matched
			this.each(function()
			{
				
				var container = $(this);
				var allowExpand = true;
				
				var allowExpand = container.attr("data-allow-expand");
				if(typeof(allowExpand)=="undefined")
				{//init data-dragging if its not on already
					container.attr("data-allow-expand", "1");
					allowExpand = "1";
				}
				//var $emptyPlaceholder = $(this).find("#empty-placeholder");
				var received = false;
				
				container.sortable({
					opacity: 0.6,
					//revert: container.hasClass("closed") ? false : 200,
					revert: false,
					cursor: 'move',
					handle: '.widget-top',
					cancel: '.widget-title-action,h3,.sidebar-description',
					items: '.inside #search-form > .widget:not(.sidebar-name,.sidebar-disabled)',
					placeholder: 'widget-placeholder',
					connectWith: '.ui-search-filter-sortable',
					stop: function(e,ui){
						
						setWidgetFormIds();
						
						ui.item.attr("data-dragging", "0");
						var field_type = ui.item.attr("data-field-type");
						
						//check to see if the context (the source item) has the class "widget enabled", if it doesn't then it was from the available fields list, if it doesn't then we were moving the item already in the Search Form
						if(!$(ui.item.context).hasClass("widget-enabled"))
						{
							//if we are moving the item from teh Available fields, automatically slide open
							ui.item.find('.widget-inside').slideDown("fast");
						}
						
						
						if(field_type=="post_meta")
						{
							/* set up meta type radios */
							var $meta_type_radio = ui.item.find('.sf_meta_type input[type="radio"]');
							var $meta_type_labels = ui.item.find('.sf_meta_type label');
							var $checked_radio = ui.item.find('.sf_meta_type input[data-radio-checked="1"]');
							
							$meta_type_radio.each(function(){
								this.checked = false;
								$(this).attr("data-radio-checked", 0);
							});
							
							
							if($checked_radio.length==0)
							{
								$checked_radio = ui.item.find(".sf_meta_type label:first-child input");
								$checked_radio.prop('checked',true);
							}
							
							$checked_radio.attr("data-radio-checked", 1);
							$checked_radio.prop('checked',true);
							var meta_type_val = $checked_radio.val();
							
							metaTypeChange($checked_radio);
							
							$meta_type_radio.on( 'change', function()
							{
								$meta_type_radio.attr("data-radio-checked", 0);
								$(this).attr("data-radio-checked", 1);
								metaTypeChange($(this));
								
							});
							
							
						}
						
						
						
						var $date_format_hidden = ui.item.find('.date_format_hidden');
						if($date_format_hidden.length==1)
						{
							var selected_radio = $date_format_hidden.val();
							//find any radios
							var $date_radio_inputs = ui.item.find("input.date_format_radio");
							if($date_radio_inputs.length>0)
							{
								//make sure default is selected
								if($($date_radio_inputs.get(selected_radio)).length>0)
								{
									$($date_radio_inputs.get(selected_radio)).prop('checked', true);
								}
							}
						}
												
						
					},
					over: function(){	
						
						//$emptyPlaceholder.hide();
						
					},
					out: function(){
						if(!received)
						{
							//$emptyPlaceholder.show();
						}
					},
					start: function(e,ui){
						ui.item.attr("data-dragging", "1");
						ui.item.find('.widget-inside').stop(true,true).hide();
						//if(!ui.placeholder.parent().hasClass("inside"))
						//{//if it is getting appended to the wrong place, then force it in to the right container :)
							ui.placeholder.appendTo(ui.placeholder.parent().find(".inside #search-form"));

					},
					receive: function(ev, ui)
					{
						received = true;
						//$emptyPlaceholder.hide();

					},
					change: function(e,ui){

					}
					
				});
				
				container.on( 'click', function()
				{//prevent animation when the container is closed - no need to animate the helper to an invisible DIV.....
					/*if(container.hasClass("closed"))
					{
						
						container.sortable( "option", "revert", false );
					}
					else
					{
						container.sortable( "option", "revert", 200 );
					}*/
				});
				
					
				var items = container.find(".widget");
				items.makeWidget();
				
			});
			
			return this;
		};
		
		$("#search-filter-search-form").makeSortables();
		
		
		$(".widgets-search-filter-draggables .widget").draggable({
            connectToSortable: ".ui-search-filter-sortable",
			helper: 'clone',
			start: startDrag,
			stop: enableNewWidgets
        });
		
		function startDrag(event, ui)
		{
			//@TODO: add and remove hover effect class
			$("#search-filter-search-form").addClass("post-box-hover");
			/*$("#search-filter-search-form").css("border", "1px solid #f00");
			$("#search-filter-search-form").css("width", "100%");
			$("#search-filter-search-form").css("height", "auto");*/
		}
		
		
		function enableNewWidgets(event, ui)
		{
			//@TODO: add and remove hover effect class
			$("#search-filter-search-form").removeClass("post-box-hover");
			
			var $droppedWidget = $('.widgets-search-filter-sortables .widget:not(.widget-enabled)');
			$droppedWidget.makeWidget();
			$droppedWidget.css("width", "");
			$droppedWidget.css("height", "");
			

		}
		
		function setWidgetFormIds()
		{
			var widgetCount = 0;
			
			var $active_widgets = $("#search-filter-search-form").find(".widget");
			
			/*var $widgets_radio = $active_widgets.find('input[type="radio"]');
			$widgets_radio.each(function(){
			
				$(this).attr("data-radio-val", $(this).prop("checked"));
				
			});*/
			
			$active_widgets.each(function()
			{
				
				
				setFormVars($(this), widgetCount);
				
				//if type is sort_order then loop through the option
				if($(this).attr("data-field-type")=="sort_order")
				{
					
					var optionsCount = 0;
					var $sort_options_list = $(this).find(".sort_options_list");
					$sort_options_list.find("li:not(.sort-option-template)").each(function()
					{
						
						setOptionVars($(this), widgetCount, optionsCount);
						optionsCount++;
					
					});
				}
				
				if($(this).attr("data-field-type")=="post_meta")
				{
					
					var optionsCount = 0;
					var $meta_options_list = $(this).find(".meta_options_list");
					$meta_options_list.find("li:not(.meta-option-template)").each(function()
					{
						
						setOptionVars($(this), widgetCount, optionsCount);
						optionsCount++;
					
					});
				}

				widgetCount++;
			});
			
			var $widgets_radio = $active_widgets.find('input[type="radio"]');
			
			$widgets_radio.each(function()
			{
				if($(this).attr("data-radio-checked")==1)
				{
					$(this).prop("checked", true);
					
					
					
				}
				
			});
			
		}
	
		function setFormVars($droppedWidget, widgetId)
		{
			$droppedWidget.attr("data-widget-id", widgetId);
			var $inputFields = $droppedWidget.find("input, select").not(".ignore-template-init input, .ignore-template-init select");
			var $inputLabels = $droppedWidget.find("label").not(".ignore-template-init label");
			
			$inputFields.each(function()
			{
				//copy structure
				if(!$(this).hasAttr("data-field-template-id"))
				{
					$(this).attr("data-field-template-id", $(this).attr("id"))
				}
				
				if(!$(this).hasAttr("data-field-template-name"))
				{
					$(this).attr("data-field-template-name", $(this).attr("name"))
				}
				
				//rename
				if ( $(this).attr("data-field-template-id") ) {
					$(this).attr("id",$(this).attr("data-field-template-id").parse("widget-field", widgetId));
				}
				if ( $(this).attr("data-field-template-name") ) {
					$(this).attr("name",$(this).attr("data-field-template-name").parse("widget-field", widgetId));
				}
				
				
			});
			
			$inputLabels.each(function()
			{
				//copy structure
				if(!$(this).hasAttr("data-field-template-for"))
				{
					$(this).attr("data-field-template-for", $(this).attr("for"))
				}
				
				$(this).attr("for",$(this).attr("data-field-template-for").parse("widget-field", widgetId));
				
			});
		}
		function setOptionVars($sortOption, widgetId, optionId)
		{
			var $inputFields = $sortOption.find("input, select");
			var $inputLabels = $sortOption.find("label");
			
			$inputFields.each(function()
			{
				//copy structure
				if(!$(this).hasAttr("data-field-template-id"))
				{
					$(this).attr("data-field-template-id", $(this).attr("id"))
				}
				
				if(!$(this).hasAttr("data-field-template-name"))
				{
					$(this).attr("data-field-template-name", $(this).attr("name"))
				}
				
				//rename
				if ( $(this).attr("data-field-template-id") ) {
					$(this).attr("id",$(this).attr("data-field-template-id").parse("widget-field", widgetId, optionId));
				}
				if ( $(this).attr("data-field-template-name") ) {
					$(this).attr("name",$(this).attr("data-field-template-name").parse("widget-field", widgetId, optionId));
				}				
			});
			
			$inputLabels.each(function()
			{
				//copy structure
				if(!$(this).hasAttr("data-field-template-for"))
				{
					$(this).attr("data-field-template-for", $(this).attr("for"))
				}
				
				$(this).attr("for",$(this).attr("data-field-template-for").parse("widget-field", widgetId, optionId));
				
			});
		}
		
		function initMetaOptionControls($meta_option, $meta_options_list, $no_sort_label)
		{
			$meta_option.find(".widget-control-option-remove").on( 'click', function(){
						
				$meta_option.slideUp("fast",function(){
					$meta_option.remove();
					
					if($meta_options_list.find("li:not(.meta-option-template)").length==0)
					{
						$no_sort_label.show();
					}
				});
				
				return false;
				
			});
			
			$meta_option.find(".widget-control-option-advanced").on( 'click', function(){
				
				$(this).toggleClass("active");
				$meta_option.find('.meta-options-advanced').slideToggle("fast");
				return false;
				
			});
		}
		
		function metaTypeChange($radio_field)
		{
			
			var $meta_type_labels = $radio_field.parent().parent().find("label");
			var item = $radio_field.closest(".widget");
			
			$meta_type_labels.removeClass("active");
			var $meta_type_label = $radio_field.closest("label");
			$meta_type_label.addClass("active");
			
			var radio_val = $radio_field.val();
			
			item.find('.sf_input_type_meta input[data-radio-checked="1"]').prop('checked',true);
			
			item.find(".sf_input_type_meta").hide();
			item.find(".sf_field_data").hide();
			
			item.find(".sf_input_type_meta.sf_"+radio_val).show();
			item.find(".sf_field_data.sf_"+radio_val).show();
		}
	
		function initSetupField()
		{
			var $enable_auto_count = $(".setup .sf_tab_content_settings .enable_auto_count");
			
			
			/* display results - shortcode/archive */
			var $results_toggle = $(".setup .display_results_as");
			var $template_table = $('.setup .sf_tab_content_template .template_options_table');
			var $template_ajax_table = $('.setup .sf_tab_content_template .template_ajax_table');
			var $template_pagination_table = $('.setup .sf_tab_content_template .template_pagination_table');
			var $template_sect = $('.setup .sf_tab_content_template .template_options_sect');
			var $display_result_txt_cont = $('.setup .sf_tab_content_template .display_result_txt_cont');
			var $tpl_archive_rows = $('.setup .sf_tab_content_template .tpl_archive_rows');
			var $tpl_post_type_archive_rows = $('.setup .sf_tab_content_template .tpl_post_type_archive_rows');
			var $tpl_woocommerce_rows = $('.setup .sf_tab_content_template .tpl_custom_woocommerce_rows');
			var $tpl_custom_rows = $('.setup .sf_tab_content_template .tpl_custom_rows');
			var $tpl_woo_tax_label = $('.setup .sf_tab_content_template .taxonomy_archive_woocommerce_label');

			var $use_ajax_toggle = $('.setup .sf_tab_content_template .use_ajax_toggle');
			var $selectors_results_div = $('#shortcode-info .results-shortcode');
			var $selectors_edd_div = $('#shortcode-info .edd-shortcode');
			
			var $active_results_display = $(".setup .display_results_as");
			
			//var $alabels = $active_results_display.parent().parent().parent().find("label");
			//$alabels.removeClass("active");
			//$active_results_display.parent().addClass("active");
			
			$display_result_txt_cont.find(".display_result_txt").hide();
			$display_result_txt_cont.find("#display_result_"+$active_results_display.attr("data-sf-base")+"_txt").show();



            display_result_as_toggle($results_toggle);
			/* ajax toggle */
			$results_toggle.on("change", function(){
                display_result_as_toggle($(this));
            });

            function display_result_as_toggle($this){

				var $self = $this;
				var val = $self.find('option[value="'+$self.val()+'"]').attr("data-sf-base");
				var real_display_method = $active_results_display.val();

				if ( ( real_display_method !== 'custom_dce_posts' ) && ( real_display_method !== 'custom_dce_google_maps' )  && ( real_display_method !== 'custom_dce_google_maps_posts' ) ) {
					$template_pagination_table.show();
					
				} else {
					$template_pagination_table.hide();
				}
                var $labels = $self.parent().parent().parent().find("label");
				$labels.removeClass("active");
				$self.parent().addClass("active");
				
				$display_result_txt_cont.find(".display_result_txt").hide();
				$display_result_txt_cont.find("#display_result_"+$active_results_display.val()+"_txt").show();
                //$template_table.removeClass("tpl_custom_woocommerce_rows");
                $tpl_woo_tax_label.hide();


				if(val=="shortcode")
				{
					$template_table.removeClass("template_archive_options");
					$template_table.removeClass("template_post_type_archive_options");
					$template_table.removeClass("template_custom_woocommerce_options");
					$template_table.addClass("template_shortcode_options");

                   // $template_ajax_table.removeClass("template_hide_ajax_selectors");
                   // $template_pagination_table.removeClass("template_hide_ajax_selectors");

					$tpl_custom_rows.hide();

                    if($self.val()=="shortcode") {
                        $selectors_results_div.show();
                    }
                    else {
                        $selectors_results_div.hide();
                    }


					$selectors_edd_div.hide();
					$template_sect.show();
					$tpl_archive_rows.hide();
					$tpl_post_type_archive_rows.hide();
					$tpl_woocommerce_rows.hide();
				}
				else if(val=="archive")
				{
					$template_table.removeClass("template_shortcode_options");
					$template_table.removeClass("template_post_type_archive_options");
					$template_table.removeClass("template_custom_woocommerce_options");
					$template_table.addClass("template_archive_options");

                    //$template_ajax_table.removeClass("template_hide_ajax_selectors");
                    //$template_pagination_table.removeClass("template_hide_ajax_selectors");

					$tpl_custom_rows.hide();
					$selectors_results_div.hide();
					$selectors_edd_div.hide();
					$template_sect.show();

					$tpl_post_type_archive_rows.hide();
					$tpl_woocommerce_rows.hide();

					$tpl_archive_rows.show();
				}
				else if((val=="post_type_archive")||(val=="custom_woocommerce_store"))
				{
					$template_table.removeClass("template_shortcode_options");
					$template_table.removeClass("template_custom_woocommerce_options");
                    $template_table.removeClass("template_archive_options");
					$template_table.addClass("template_post_type_archive_options");


                    //$template_ajax_table.removeClass("template_hide_ajax_selectors");
                    //$template_pagination_table.removeClass("template_hide_ajax_selectors");

					$tpl_custom_rows.hide();
					$selectors_results_div.hide();
					$selectors_edd_div.hide();
					$template_sect.show();

					$tpl_archive_rows.hide();
					$tpl_woocommerce_rows.hide();
					$tpl_post_type_archive_rows.show();

                    if(val=="custom_woocommerce_store")
                    {
                        $tpl_woo_tax_label.show();
						$tpl_woocommerce_rows.show();
                        /*$template_table.addClass("template_custom_woocommerce_options");
                          .addClass("template_custom_woocommerce_options");*/
                    }
				}
				else if(val=="custom")
				{
					$template_table.removeClass("template_archive_options");
                    $template_table.removeClass("template_post_type_archive_options");
                    $template_table.removeClass("template_custom_woocommerce_options");;
					$template_table.addClass("template_shortcode_options");


                    //$template_ajax_table.removeClass("template_hide_ajax_selectors");
                    //$template_pagination_table.removeClass("template_hide_ajax_selectors");

					$selectors_results_div.hide();
					$template_sect.show();
					$selectors_edd_div.hide();
					$tpl_archive_rows.hide();
					$tpl_woocommerce_rows.hide();
					$tpl_post_type_archive_rows.hide();
					$tpl_custom_rows.show();
				}
				else
				{
					$template_table.removeClass("template_shortcode_options");
                    $template_table.removeClass("template_post_type_archive_options");
                    $template_table.removeClass("template_custom_woocommerce_options");
					$template_table.addClass("template_archive_options");

                    //$template_ajax_table.addClass("template_hide_ajax_selectors");
                    //$template_pagination_table.addClass("template_hide_ajax_selectors");

					$tpl_custom_rows.hide();
					$selectors_results_div.hide();
					$selectors_edd_div.hide();
					$template_sect.hide();
					$tpl_archive_rows.show();
					$tpl_post_type_archive_rows.hide();

					if(val=="custom_edd_store")
					{
						$template_table.removeClass("template_archive_options");
						$template_table.addClass("template_shortcode_options");
						$tpl_archive_rows.hide();
						$tpl_custom_rows.show();
						$selectors_edd_div.show();
						$template_sect.show();
					}
				}

				var built_in_display_methods = ['archive', 'post_type_archive', 'shotrcode', 'custom_woocommerce_store', 'custom_edd_store', 'custom' ];



                if(built_in_display_methods.indexOf(real_display_method) == -1)
                {//then its another display method, a third party integration, which means we set ajax selectors
                    $template_ajax_table.addClass("template_hide_ajax_selectors");
                    $template_pagination_table.addClass("template_hide_ajax_selectors");
                }
                else{
                    $template_ajax_table.removeClass("template_hide_ajax_selectors");
                    $template_pagination_table.removeClass("template_hide_ajax_selectors");

                }


				
			}
			
			var $scroll_to_pos = $(".setup .scroll_to_pos");
			
			ajaxToggle($use_ajax_toggle);
			$use_ajax_toggle.on("change",function(){
				ajaxToggle($(this));
				updateScrollToPos($scroll_to_pos);
			});
			
			autoCountToggle($enable_auto_count);
			$enable_auto_count.on("change",function(){
				autoCountToggle($(this));
				updateScrollToPos($scroll_to_pos);
			});
			
			/* scroll to pos */
			
			updateScrollToPos($scroll_to_pos);
			$scroll_to_pos.on("change", function(e){
				updateScrollToPos($(this));
				
			});
			//end scroll_to_pos
			
			
			/* pagination type */
			var $pagination_type = $(".setup .pagination_type");
			updatePaginationType($pagination_type);
			$pagination_type.on("change", function(e){
				updatePaginationType($(this));
				
			});
			//end scroll_to_pos
			
			/* sort by */
			var $default_sort_by = $('.setup .default_sort_by');
			var $sort_by_meta_container_default = $('.setup .sort_by_meta_container_default');
			$default_sort_by.on( 'change', function(e)
			{
				handleDefaultSortBy($(this), $sort_by_meta_container_default);
			});
			
			handleDefaultSortBy($default_sort_by, $sort_by_meta_container_default);
			
			
			var $secondary_sort_by = $('.setup .secondary_sort_by');
			var $sort_by_meta_container_secondary = $('.setup .sort_by_meta_container_secondary');
			$secondary_sort_by.on( 'change', function(e)
			{
				handleDefaultSortBy($(this), $sort_by_meta_container_secondary);
			});
			
			handleDefaultSortBy($secondary_sort_by, $sort_by_meta_container_secondary);
			
				
		}
		function updatePaginationType($paginationType)
		{
			if($paginationType.prop("disabled")==false)
			{
				var pagination_type = $paginationType.val();
				var $pagination_table = $('#search-filter-settings-box .template_pagination_table');
				
				$pagination_table.attr("data-sf-pagination-type", pagination_type);
			}
			
			
		}
		
		function updateScrollToPos($scrollToObject)
		{
			if($scrollToObject.prop("disabled")==false)
			{
				var $custom_scroll_to = $(".setup .custom_scroll_to");
				var $scroll_on_action = $(".setup .scroll_on_action");
				
				if($scrollToObject.val()=="custom")
				{
					$custom_scroll_to.show();
				}
				else
				{
					$custom_scroll_to.hide();
				}
				
				
				if($scrollToObject.val()=="0")
				{
					disableInput($scroll_on_action); 
				}
				else
				{
					enableInput($scroll_on_action);
				}
			}
			
			
		}
		function autoCountToggle($self)
		{
			var $inputs = $self.closest("tr").find(".auto_count_refresh_mode");
			
			if($self.is(":checked"))
			{
				//enable all fields
				$inputs.each(function(){
				
					var $input = $(this);
					enableInput($input);
					
				});
			}
			else
			{
				//disable all fields
				$inputs.each(function(){
				
					var $input = $(this);
					disableInput($input);
				});
				
			}
			
		}
		function ajaxToggle($self)
		{
			var $inputs = $(".tpl_use_ajax_rows input, .tpl_use_ajax_rows select");
			
			if($self.is(":checked"))
			{
				//enable all fields
				$inputs.each(function(){
				
					var $input = $(this);
					enableInput($input);
					
				});
			}
			else
			{
				//disable all fields
				$inputs.each(function(){
				
					var $input = $(this);
					disableInput($input);
				});
				
			}
			
		}
		function disableInput($input)
		{
			//create a hidden version of the field, that is not disabled - so we can retain even disabled values in the DB
			var $inputClone = $('<input/>', {
				'type'						: 'hidden',
				'name'						: $input.attr("name"),
				'class'						: 'clone',
				'data-field-template-id'	: $input.attr("data-field-template-id"),
				'data-field-template-name'	: $input.attr("data-field-template-name"),
				'value'						: ''
			});
			
			if($input.get(0).tagName=="INPUT")
			{
				if(($input.attr("type")=="checkbox")||($input.attr("type")=="radio"))
				{
					$inputClone.val($input.prop("checked") ? 1 : "");
				}
				else if($input.attr("type")=="text")
				{
					$inputClone.val($input.val());
				}
				else
				{
					$inputClone.val($input.val());
				}
			}
			else if($input.get(0).tagName=="SELECT")
			{
				$inputClone.val($input.val());
			}
			else
			{
				$inputClone.val($input.val());
			}
			
			$input.after($inputClone);
			$input.prop("disabled",true);
		}
		
		function enableInput($input)
		{
			$input.prop("disabled", false);
			
			var $inputClone = $input.parent().find(".clone");
			
			if($inputClone.length>0)
			{
				if($input.get(0).tagName=="INPUT")
				{
					if(($input.attr("type")=="checkbox")||($input.attr("type")=="radio"))
					{
						if($inputClone.val()==1)
						{
							$input.prop("checked", true);
						}
						else
						{
							$input.prop("checked", false);
						}
					}
					else if($input.attr("type")=="text")
					{
						$input.val($inputClone.val());
					}
					else
					{
						$input.val($inputClone.val());
					}
				}
				else if($input.get(0).tagName=="SELECT")
				{
					$input.val($inputClone.val());
				}
			
				$inputClone.remove();
			}
		}
		
		function handleDefaultSortBy($this, $sort_by_meta_container)
		{
			if($this.val()=="meta_value")
			{
				$sort_by_meta_container.show();
			}
			else
			{
				$sort_by_meta_container.hide();
			}
			
			
		}
		
		
		initSetupField();
		
				
		
		function setMetaSettingsFields($list)
		{
			var itemId = 0;
			$list.each(function(){
			
				if($(this).attr("data-remove")!=1)
				{
					
					var $self = $(this);
					var $inputFields = $self.find("input, select");
					var $inputLabels = $self.find("label");
					
					
					$inputFields.each(function()
					{
						//copy structure
						if(!$(this).hasAttr("data-field-template-id"))
						{
							$(this).attr("data-field-template-id", $(this).attr("id"))
						}
						
						if(!$(this).hasAttr("data-field-template-name"))
						{
							$(this).attr("data-field-template-name", $(this).attr("name"))
						}
						
						//rename
						if ( $(this).attr("data-field-template-id") ) {
							$(this).attr("id",$(this).attr("data-field-template-id").parse(itemId));
						}
						if ( $(this).attr("data-field-template-name") ) {
							$(this).attr("name",$(this).attr("data-field-template-name").parse(itemId));
						}
					});
					
					$inputLabels.each(function()
					{
						//copy structure
						if(!$(this).hasAttr("data-field-template-for"))
						{
							$(this).attr("data-field-template-for", $(this).attr("for"))
						}
						
						$(this).attr("for",$(this).attr("data-field-template-for").parse(itemId));
						
						
					});
					
					itemId++;
				}
			});
		}
		function removeMetaOption(e){
		
			e.preventDefault();
			
			$(this).closest("li").attr("data-remove","1");
			$(this).closest("li").slideUp("fast", function(){
				$(this).remove();
			});
			
			setMetaSettingsFields($("#search-filter-settings-box .sf_tab_content_post_meta ul.meta_list li:not(.template)"));
					
			return false;
		}
		function initSettingsMetabox()
		{
			/* init meta type radios */
			/* set up meta type radios */
			var $settings_tab_radio = $('#search-filter-settings-box .sf_settings_tabs input[type="radio"]');
			var $settings_tab_label = $('#search-filter-settings-box .sf_settings_tabs label');
			var $checked_radio = $('#search-filter-settings-box .sf_settings_tabs input[data-radio-checked="1"]');
			
			$settings_tab_radio.each(function(){
				this.checked = false;
				$(this).attr("data-radio-checked", 0);
			});
			
			
			$settings_tab_radio.on( 'change', function()
			{
				$settings_tab_radio.attr("data-radio-checked", 0);
				$(this).attr("data-radio-checked", 1);
				tabChange($(this));
				
			});
			
			
			var $meta_list = $("#search-filter-settings-box .sf_tab_content_post_meta ul.meta_list");
			var $meta_list_template = $meta_list.find(".template");
			var $add_condition_button = $("#search-filter-settings-box .sf_tab_content_post_meta .add-option-button");
			
			$meta_list.find(".option-remove").on( 'click', removeMetaOption);
			
			$meta_list.find(".meta_date_value_current_date").each(function(){
				metaSettingsCurrentDateChange($(this));
			});
			$meta_list.find(".meta_date_value_current_date").on("change", function(){
				metaSettingsCurrentDateChange($(this));
			});
			
			$meta_list.find(".meta_date_value_current_timestamp").each(function(){
				metaSettingsCurrentTimestampChange($(this));
			});
			$meta_list.find(".meta_date_value_current_timestamp").on("change", function(){
				metaSettingsCurrentTimestampChange($(this));
			});
			
			$meta_list.find(".meta_type").on("change", function(){
				metaSettingsFieldTypeChange($(this));
			});
			$meta_list.find(".meta_type").each(function(){
				metaSettingsFieldTypeChange($(this));
			});
			
			setMetaSettingsFields($("#search-filter-settings-box .sf_tab_content_post_meta ul.meta_list li:not(.template)"));
			
			$add_condition_button.on( 'click', function(){
			
				
				var $meta_option = $meta_list_template.clone();
				$meta_option.hide();
				$meta_option.removeClass("template");
				
				$meta_list.append($meta_option);
				
				$meta_option.find(".option-remove").on( 'click', removeMetaOption);
				
				$meta_option.find(".meta_type").on("change", function(){
					metaSettingsFieldTypeChange($(this));
				});
				
				$meta_option.find(".meta_date_value_current_date").on("change", function(){
					metaSettingsCurrentDateChange($(this));
				});				
				
				$meta_option.find(".meta_date_value_current_timestamp").on("change", function(){
					metaSettingsCurrentTimestampChange($(this));
				});
				
				setMetaSettingsFields($("#search-filter-settings-box .sf_tab_content_post_meta ul.meta_list li:not(.template)"));
				
				$meta_option.slideDown("fast");
				
				return false;
			
			});
		}
		function metaSettingsCurrentDateChange($field){
						
			var $datefields = $field.parent().parent().find('input[type="text"]');
			
			if($field.is(":checked"))
			{
				$datefields.each(function(){
			
					var $input = $(this);
					disableInput($input);
				});
			}
			else
			{
				$datefields.each(function(){
			
				var $input = $(this);
					enableInput($input);
				});
				
			}
			
		}
		function metaSettingsCurrentTimestampChange($field){
						
			var $datefields = $field.parent().parent().find('input[type="text"]');
			
			if($field.is(":checked"))
			{
				$datefields.each(function(){
			
					var $input = $(this);
					disableInput($input);
				});
			}
			else
			{
				$datefields.each(function(){
			
				var $input = $(this);
					enableInput($input);
				});
				
			}
			
		}
		function metaSettingsFieldTypeChange($field)
		{
			var val = $field.val();
			var $meta_value_c = $field.parent().parent().parent().find(".meta_value_c");
			var $meta_value_date_c = $field.parent().parent().parent().find(".meta_value_date_c");
			var $meta_value_timestamp_c = $field.parent().parent().parent().find(".meta_value_timestamp_c");
			var $meta_compare_field = $field.parent().parent().parent().find(".meta_compare");			
			
			
			if(val=="DATE")
			{
				$meta_value_c.hide();
				$meta_value_timestamp_c.hide();
				$meta_value_date_c.show();
				$meta_compare_field.find("option:not(.date-format-supported)").hide();
				
				var meta_compare_val = $meta_compare_field.val();
				var $meta_compare_option = $meta_compare_field.find(":selected");	
				if(!$meta_compare_option.hasClass('date-format-supported'))
				{
					$meta_compare_field.val("e");
				}
			}
			else if(val=="TIMESTAMP")
			{
				$meta_value_c.hide();
				$meta_value_date_c.hide();
				$meta_value_timestamp_c.show();
				$meta_compare_field.find("option:not(.date-format-supported)").hide();
				
				var meta_compare_val = $meta_compare_field.val();
				var $meta_compare_option = $meta_compare_field.find(":selected");	
				if(!$meta_compare_option.hasClass('date-format-supported'))
				{
					$meta_compare_field.val("e");
				}
			}
			else
			{
				if(($meta_value_date_c.is(":visible"))||($meta_value_timestamp_c.is(":visible")))
				{
					$meta_value_c.show();
					//$meta_compare_field.val("e");
					$meta_value_date_c.hide();
					$meta_value_timestamp_c.hide();
					$meta_compare_field.find("option").show();
				}
			}
		}
		
		
		function tabChange($radio_field)
		{
			
			var $tab_labels = $radio_field.parent().parent().find("label");
			var item = $radio_field.closest(".tabs-container");
			
			$tab_labels.removeClass("active");
			var $meta_type_label = $radio_field.closest("label");
			$meta_type_label.addClass("active");
			
			var radio_val = $radio_field.val();
			
			item.find(".sf_field_data").hide();
			
			item.find(".sf_field_data.sf_tab_content_"+radio_val).show();
		}
		initSettingsMetabox();
		
		
		
	});
	
	

}(jQuery));