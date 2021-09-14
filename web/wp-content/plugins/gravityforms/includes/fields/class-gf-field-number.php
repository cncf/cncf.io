<?php

if ( ! class_exists( 'GFForms' ) ) {
	die();
}


class GF_Field_Number extends GF_Field {

	public $type = 'number';

	public function get_form_editor_field_title() {
		return esc_attr__( 'Number', 'gravityforms' );
	}

	/**
	 * Returns the field's form editor description.
	 *
	 * @since 2.5
	 *
	 * @return string
	 */
	public function get_form_editor_field_description() {
		return esc_attr__( 'Allows users to enter a number.', 'gravityforms' );
	}

	/**
	 * Returns the field's form editor icon.
	 *
	 * This could be an icon url or a gform-icon class.
	 *
	 * @since 2.5
	 *
	 * @return string
	 */
	public function get_form_editor_field_icon() {
		return 'gform-icon--numbers-alt';
	}

	function get_form_editor_field_settings() {
		return array(
			'conditional_logic_field_setting',
			'prepopulate_field_setting',
			'error_message_setting',
			'label_setting',
			'label_placement_setting',
			'admin_label_setting',
			'size_setting',
			'number_format_setting',
			'range_setting',
			'rules_setting',
			'visibility_setting',
			'duplicate_setting',
			'default_value_setting',
			'placeholder_setting',
			'description_setting',
			'css_class_setting',
			'calculation_setting',
			'autocomplete_setting',
		);
	}

	public function is_conditional_logic_supported() {
		return true;
	}

	public function get_value_submission( $field_values, $get_from_post_global_var = true ) {

		$value = $this->get_input_value_submission( 'input_' . $this->id, $this->inputName, $field_values, $get_from_post_global_var );

		if ( is_array( $value ) ) {
			$value = array_map( 'trim', $value );
			foreach ( $value  as &$v ) {
				$v = trim( $v );
				$v = $this->clean_value( $v );
			}
		} else {
			$value = trim( $value );
			$value = $this->clean_value( $value );
		}

		return $value;
	}

	/**
	 * Ensures the POST value is in the correct number format.
	 *
	 * @since 2.4
	 *
	 * @param $value
	 *
	 * @return bool|float|string
	 */
	public function clean_value( $value ) {

		if ( $this->numberFormat == 'currency' ) {
			$currency = new RGCurrency( GFCommon::get_currency() );
			$value    = $currency->to_number( $value );
		} elseif ( $this->numberFormat == 'decimal_comma' ) {
			$value = GFCommon::clean_number( $value, 'decimal_comma' );
		} elseif ( $this->numberFormat == 'decimal_dot' ) {
			$value = GFCommon::clean_number( $value, 'decimal_dot' );
		}

		return $value;
	}

	public function validate( $value, $form ) {

		// The POST value has already been converted from currency or decimal_comma to decimal_dot and then cleaned in get_field_value().
		$value = GFCommon::maybe_add_leading_zero( $value );

		// Raw value will be tested against the is_numeric() function to make sure it is in the right format.
		// If the POST value is an array then the field is inside a repeater so use $value.
		$raw_value = isset( $_POST[ 'input_' . $this->id ] ) && ! is_array( $_POST[ 'input_' . $this->id ] ) ? GFCommon::maybe_add_leading_zero( rgpost( 'input_' . $this->id ) ) : $value;

		$requires_valid_number = ! rgblank( $raw_value ) && ! $this->has_calculation();
		$is_valid_number       = $this->validate_range( $value ) && GFCommon::is_numeric( $raw_value, $this->numberFormat );

		if ( $requires_valid_number && ! $is_valid_number ) {
			$this->failed_validation  = true;
			$this->validation_message = empty( $this->errorMessage ) ? $this->get_range_message() : $this->errorMessage;
		} elseif ( $this->type == 'quantity' ) {
			if ( intval( $value ) != $value ) {
				$this->failed_validation  = true;
				$this->validation_message = empty( $field['errorMessage'] ) ? esc_html__( 'Please enter a valid quantity. Quantity cannot contain decimals.', 'gravityforms' ) : $field['errorMessage'];
			} elseif ( ! empty( $value ) && ( ! is_numeric( $value ) || intval( $value ) != floatval( $value ) || intval( $value ) < 0 ) ) {
				$this->failed_validation  = true;
				$this->validation_message = empty( $field['errorMessage'] ) ? esc_html__( 'Please enter a valid quantity', 'gravityforms' ) : $field['errorMessage'];
			}
		}

	}

	/**
	 * Validates the range of the number according to the field settings.
	 *
	 * @param string $value A decimal_dot formatted string
	 *
	 * @return true|false True on valid or false on invalid
	 */
	private function validate_range( $value ) {

		if ( ! GFCommon::is_numeric( $value, 'decimal_dot' ) ) {
			return false;
		}

		$numeric_min = $this->numberFormat == 'decimal_comma' ? GFCommon::clean_number( $this->rangeMin, 'decimal_comma' ) : $this->rangeMin;
		$numeric_max = $this->numberFormat == 'decimal_comma' ? GFCommon::clean_number( $this->rangeMax, 'decimal_comma' ) : $this->rangeMax;

		if ( ( is_numeric( $numeric_min ) && $value < $numeric_min ) ||
		     ( is_numeric( $numeric_max ) && $value > $numeric_max )
		) {
			return false;
		} else {
			return true;
		}
	}

	public function get_range_message() {
		$min     = $this->rangeMin;
		$max     = $this->rangeMax;

		$numeric_min = $min;
		$numeric_max = $max;

		if ( $this->numberFormat == 'decimal_comma' ){
			$numeric_min = empty( $min ) ? '' : GFCommon::clean_number( $min, 'decimal_comma', '');
			$numeric_max = empty( $max ) ? '' : GFCommon::clean_number( $max, 'decimal_comma', '');
		}

		$message = '';

		if ( is_numeric( $numeric_min ) && is_numeric( $numeric_max ) ) {
			$message = sprintf( esc_html__( 'Please enter a number from %s to %s.', 'gravityforms' ), "<strong>$min</strong>", "<strong>$max</strong>" );
		} elseif ( is_numeric( $numeric_min ) ) {
			$message = sprintf( esc_html__( 'Please enter a number greater than or equal to %s.', 'gravityforms' ), "<strong>$min</strong>" );
		} elseif ( is_numeric( $numeric_max ) ) {
			$message = sprintf( esc_html__( 'Please enter a number less than or equal to %s.', 'gravityforms' ), "<strong>$max</strong>" );
		} elseif ( $this->failed_validation && $this->isRequired ) {
			$message = ''; // Required validation will take care of adding the message here.
		} elseif ( $this->failed_validation ) {
			$message = esc_html__( 'Please enter a valid number.', 'gravityforms' );
		}

		return $message;
	}

	public function get_field_input( $form, $value = '', $entry = null ) {
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();

		$form_id  = $form['id'];
		$id       = intval( $this->id );
		$field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

		$size          = $this->size;
		$disabled_text = $is_form_editor ? "disabled='disabled'" : '';
		$class_suffix  = $is_entry_detail ? '_admin' : '';
		$class         = $size . $class_suffix;
		$class         = esc_attr( $class );

		$instruction = '';
		$read_only   = '';

		if ( ! $is_entry_detail && ! $is_form_editor ) {

			if ( $this->has_calculation() ) {

				// calculation-enabled fields should be read only
				$read_only = 'readonly="readonly"';

			} else {

				$message          = $this->get_range_message();
				$validation_class = $this->failed_validation ? 'validation_message' : '';

				if ( ! $this->failed_validation && ! empty( $message ) && empty( $this->errorMessage ) ) {
					$instruction = "<div class='instruction $validation_class' id='gfield_instruction_{$this->formId}_{$this->id}'>" . $message . '</div>';
				}
			}
		} elseif ( rgget('view') == 'entry' ) {
			$value = GFCommon::format_number( $value, $this->numberFormat, rgar( $entry, 'currency' ) );
		}

		$is_html5        = RGFormsModel::is_html5_enabled();
		$html_input_type = $is_html5 && ! $this->has_calculation() && ( $this->numberFormat != 'currency' && $this->numberFormat != 'decimal_comma' ) ? 'number' : 'text'; // chrome does not allow number fields to have commas, calculations and currency values display numbers with commas
		$step_attr       = $is_html5 ? "step='any'" : '';

		$min = $this->rangeMin;
		$max = $this->rangeMax;

		$min_attr = $is_html5 && is_numeric( $min ) ? "min='{$min}'" : '';
		$max_attr = $is_html5 && is_numeric( $max ) ? "max='{$max}'" : '';

		$include_thousands_sep = apply_filters( 'gform_include_thousands_sep_pre_format_number', $html_input_type == 'text', $this );
		$value                 = GFCommon::format_number( $value, $this->numberFormat, rgar( $entry, 'currency' ), $include_thousands_sep );

		$placeholder_attribute  = $this->get_field_placeholder_attribute();
		$required_attribute     = $this->isRequired ? 'aria-required="true"' : '';
		$invalid_attribute      = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';

		$range_message          = $this->get_range_message();
		$describedby_extra_id   = empty( $range_message ) ? array() : array( "gfield_instruction_{$this->formId}_{$this->id}" );
		$aria_describedby       = $this->get_aria_describedby( $describedby_extra_id );

		$autocomplete_attribute = $this->enableAutocomplete ? $this->get_field_autocomplete_attribute() : '';

		$tabindex = $this->get_tabindex();

		$input = sprintf( "<div class='ginput_container ginput_container_number'><input name='input_%d' id='%s' type='{$html_input_type}' {$step_attr} {$min_attr} {$max_attr} value='%s' class='%s' {$tabindex} {$read_only} %s %s %s %s %s %s/>%s</div>", $id, $field_id, esc_attr( $value ), esc_attr( $class ), $disabled_text, $placeholder_attribute, $required_attribute, $invalid_attribute, $aria_describedby, $autocomplete_attribute, $instruction );
		return $input;
	}

	public function get_value_entry_list( $value, $entry, $field_id, $columns, $form ) {
		$include_thousands_sep = apply_filters( 'gform_include_thousands_sep_pre_format_number', true, $this );

		return GFCommon::format_number( $value, $this->numberFormat, rgar( $entry, 'currency' ), $include_thousands_sep );
	}

	public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
		$include_thousands_sep = apply_filters( 'gform_include_thousands_sep_pre_format_number', $use_text, $this );

		return GFCommon::format_number( $value, $this->numberFormat, $currency, $include_thousands_sep );
	}

	/**
	 * Gets merge tag values.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @uses GFCommon::format_number()
	 *
	 * @param array|string $value      The value of the input.
	 * @param string       $input_id   The input ID to use.
	 * @param array        $entry      The Entry Object.
	 * @param array        $form       The Form Object
	 * @param string       $modifier   The modifier passed.
	 * @param array|string $raw_value  The raw value of the input.
	 * @param bool         $url_encode If the result should be URL encoded.
	 * @param bool         $esc_html   If the HTML should be escaped.
	 * @param string       $format     The format that the value should be.
	 * @param bool         $nl2br      If the nl2br function should be used.
	 *
	 * @return string The processed merge tag.
	 */
	public function get_value_merge_tag( $value, $input_id, $entry, $form, $modifier, $raw_value, $url_encode, $esc_html, $format, $nl2br ) {
		$include_thousands_sep = ! in_array( 'value', $this->get_modifiers() );

		/**
		 * Filters if the thousands separator should be used when displaying the a number field result.
		 *
		 * @since 1.9.5
		 *
		 * @param bool            $include_thousands_sep If the modifier passed in the merge tag is not 'value', false. Otherwise, true.
		 * @param GF_Field_Number $this                  An instance of this class.
		 */
		$include_thousands_sep = apply_filters( 'gform_include_thousands_sep_pre_format_number', $include_thousands_sep, $this );

		$formatted_value = GFCommon::format_number( $value, $this->numberFormat, rgar( $entry, 'currency' ), $include_thousands_sep );

		return $url_encode ? urlencode( $formatted_value ) : $formatted_value;
	}

	public function get_value_save_entry( $value, $form, $input_name, $lead_id, $lead ) {
		if ( $this->has_calculation() ) {
			if ( empty( $lead ) ) {
				$lead = GFFormsModel::get_lead( $lead_id );
			}

			$value = GFCommon::calculate( $this, $form, $lead );

			if ( $this->numberFormat !== 'currency' ) {
				$value = GFCommon::round_number( $value, $this->calculationRounding );
			}

			// Return the value as a string when it is zero and a calc so that the "==" comparison done when checking if the field has changed isn't treated as false.
			if ( $value == 0 ) {
				$value = '0';
			}
		} else {
			$value = $this->clean_number( GFCommon::maybe_add_leading_zero( $value ) );
		}

		return $this->sanitize_entry_value( $value, $form['id'] );
	}

	public function sanitize_settings() {
		parent::sanitize_settings();
		$this->enableCalculation = (bool) $this->enableCalculation;

		if ( ! in_array( $this->numberFormat, array( 'currency', 'decimal_comma', 'decimal_dot' ) ) ) {
			$this->numberFormat = GFCommon::is_currency_decimal_dot() ? 'decimal_dot' : 'decimal_comma';
		}

		$this->rangeMin = $this->clean_number( $this->rangeMin );
		$this->rangeMax = $this->clean_number( $this->rangeMax );

		if ( $this->numberFormat == 'decimal_comma' ) {
			$this->rangeMin = GFCommon::format_number( $this->rangeMin, 'decimal_comma' );
			$this->rangeMax = GFCommon::format_number( $this->rangeMax, 'decimal_comma' );
		}
	}

	public function clean_number( $value ) {

		if ( $this->numberFormat == 'currency' ) {
			return GFCommon::to_number( $value );
		} else {
			return GFCommon::clean_number( $value, $this->numberFormat );
		}
	}
}

GF_Fields::register( new GF_Field_Number() );
