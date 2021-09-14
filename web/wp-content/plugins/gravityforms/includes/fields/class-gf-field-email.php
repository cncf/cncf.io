<?php

if ( ! class_exists( 'GFForms' ) ) {
	die();
}


class GF_Field_Email extends GF_Field {

	public $type = 'email';

	public function get_form_editor_field_title() {
		return esc_attr__( 'Email', 'gravityforms' );
	}

	/**
	 * Returns the field's form editor description.
	 *
	 * @since 2.5
	 *
	 * @return string
	 */
	public function get_form_editor_field_description() {
		return esc_attr__( 'Allows users to enter a valid email address.', 'gravityforms' );
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
		return 'gform-icon--mail';
	}

	function get_form_editor_field_settings() {
		return array(
			'conditional_logic_field_setting',
			'prepopulate_field_setting',
			'error_message_setting',
			'label_setting',
			'label_placement_setting',
			'email_confirm_setting',
			'admin_label_setting',
			'size_setting',
			'rules_setting',
			'visibility_setting',
			'duplicate_setting',
			'default_value_setting',
			'placeholder_setting',
			'description_setting',
			'css_class_setting',
			'autocomplete_setting',
		);
	}

	public function is_conditional_logic_supported() {
		return true;
	}

	public function get_entry_inputs() {
		return null;
	}

	/**
	 * Returns the HTML tag for the field container.
	 *
	 * @since 2.5
	 *
	 * @param array $form The current Form object.
	 *
	 * @return string
	 */
	public function get_field_container_tag( $form ) {

		if ( GFCommon::is_legacy_markup_enabled( $form ) || ! $this->emailConfirmEnabled ) {
			return parent::get_field_container_tag( $form );
		}

		return 'fieldset';

	}

	/**
	 * Whether this field expects an array during submission.
	 *
	 * @since 2.4
	 *
	 * @return bool
	 */
	public function is_value_submission_array() {
		return (bool) $this->emailConfirmEnabled ;
	}

	public function validate( $value, $form ) {
		$email = is_array( $value ) ? rgar( $value, 0 ) : $value; // Form objects created in 1.8 will supply a string as the value.
		$is_blank = rgblank( $value ) || ( is_array( $value ) && rgempty( array_filter( $value ) ) );

		if ( ! $is_blank && ! GFCommon::is_valid_email( $email ) ) {
			$this->failed_validation  = true;
			$this->validation_message = empty( $this->errorMessage ) ? esc_html__( 'The email address entered is invalid, please check the formatting (e.g. email@domain.com).', 'gravityforms' ) : $this->errorMessage;
		} elseif ( $this->emailConfirmEnabled && ! empty( $email ) ) {
			$confirm = is_array( $value ) ? rgar( $value, 1 ) : $this->get_input_value_submission( 'input_' . $this->id . '_2' );
			if ( $confirm != $email ) {
				$this->failed_validation  = true;
				$this->validation_message = esc_html__( 'Your emails do not match.', 'gravityforms' );
			}
		}
	}

	public function get_field_input( $form, $value = '', $entry = null ) {
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();

		if ( is_array( $value ) ) {
			$value = array_values( $value );
		}

		$form_id  = absint( $form['id'] );
		$id       = absint( $this->id );
		$field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";
		$form_id  = ( $is_entry_detail || $is_form_editor ) && empty( $form_id ) ? rgget( 'id' ) : $form_id;

		$size          = $this->size;
		$disabled_text = $is_form_editor ? "disabled='disabled'" : '';
		$class_suffix  = $is_entry_detail ? '_admin' : '';

		$class         = $this->emailConfirmEnabled ? '' : $size . $class_suffix; //Size only applies when confirmation is disabled
		$class         = esc_attr( $class );

		$form_sub_label_placement  = rgar( $form, 'subLabelPlacement' );
		$field_sub_label_placement = $this->subLabelPlacement;
		$is_sub_label_above        = $field_sub_label_placement == 'above' || ( empty( $field_sub_label_placement ) && $form_sub_label_placement == 'above' );
		$sub_label_class_attribute = $field_sub_label_placement == 'hidden_label' ? "class='hidden_sub_label screen-reader-text'" : '';

		$html_input_type = RGFormsModel::is_html5_enabled() ? 'email' : 'text';

		$required_attribute    = $this->isRequired ? 'aria-required="true"' : '';
		$invalid_attribute     = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';
		$aria_describedby      = $this->get_aria_describedby();

		$enter_email_field_input = GFFormsModel::get_input( $this, $this->id . '' );
		$confirm_field_input     = GFFormsModel::get_input( $this, $this->id . '.2' );

		$enter_email_label   = rgar( $enter_email_field_input, 'customLabel' ) != '' ? $enter_email_field_input['customLabel'] : esc_html__( 'Enter Email', 'gravityforms' );
		$enter_email_label   = gf_apply_filters( array( 'gform_email', $form_id ), $enter_email_label, $form_id );
		$confirm_email_label = rgar( $confirm_field_input, 'customLabel' ) != '' ? $confirm_field_input['customLabel'] : esc_html__( 'Confirm Email', 'gravityforms' );
		$confirm_email_label = gf_apply_filters( array( 'gform_email_confirm', $form_id ), $confirm_email_label, $form_id );

		$single_placeholder_attribute        = $this->get_field_placeholder_attribute();
		$enter_email_placeholder_attribute   = $this->get_input_placeholder_attribute( $enter_email_field_input );
		$confirm_email_placeholder_attribute = $this->get_input_placeholder_attribute( $confirm_field_input );

		$single_autocomplete_attribute        = $this->get_field_autocomplete_attribute();
		$enter_email_autocomplete_attribute   = $this->get_input_autocomplete_attribute( $enter_email_field_input );
		$confirm_email_autocomplete_attribute = $this->get_input_autocomplete_attribute( $confirm_field_input );

		if ( $is_form_editor ) {
			$single_style  = $this->emailConfirmEnabled ? "style='display:none;'" : '';
			$confirm_style = $this->emailConfirmEnabled ? '' : "style='display:none;'";

			if ( $is_sub_label_above ) {
				return "<div class='ginput_container ginput_container_email ginput_single_email' {$single_style}>
                            <input name='input_{$id}' type='{$html_input_type}' class='" . esc_attr( $class ) . "' disabled='disabled' {$single_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$single_autocomplete_attribute} />
                            <div class='gf_clear gf_clear_complex'></div>
                        </div>
                        <div class='ginput_complex ginput_container ginput_container_email ginput_confirm_email' {$confirm_style} id='{$field_id}_container'>
                            <span id='{$field_id}_1_container' class='ginput_left'>
                                <label for='{$field_id}' {$sub_label_class_attribute}>{$enter_email_label}</label>
                                <input class='{$class}' type='text' name='input_{$id}' id='{$field_id}' disabled='disabled' {$enter_email_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$enter_email_autocomplete_attribute} />
                            </span>
                            <span id='{$field_id}_2_container' class='ginput_right'>
                                <label for='{$field_id}_2' {$sub_label_class_attribute}>{$confirm_email_label}</label>
                                <input class='{$class}' type='text' name='input_{$id}_2' id='{$field_id}_2' disabled='disabled' {$confirm_email_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$confirm_email_autocomplete_attribute} />
                            </span>
                            <div class='gf_clear gf_clear_complex'></div>
                        </div>";
			} else {
				return "<div class='ginput_container ginput_container_email ginput_single_email' {$single_style}>
                            <input name='input_{$id}' type='{$html_input_type}' class='" . esc_attr( $class ) . "' disabled='disabled' {$single_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$single_autocomplete_attribute} />
                            <div class='gf_clear gf_clear_complex'></div>
                        </div>
                        <div class='ginput_complex ginput_container ginput_container_email ginput_confirm_email' {$confirm_style} id='{$field_id}_container'>
                            <span id='{$field_id}_1_container' class='ginput_left'>
                                <input class='{$class}' type='text' name='input_{$id}' id='{$field_id}' disabled='disabled' {$enter_email_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$enter_email_autocomplete_attribute} />
                                <label for='{$field_id}' {$sub_label_class_attribute}>{$enter_email_label}</label>
                            </span>
                            <span id='{$field_id}_2_container' class='ginput_right'>
                                <input class='{$class}' type='text' name='input_{$id}_2' id='{$field_id}_2' disabled='disabled' {$confirm_email_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$confirm_email_autocomplete_attribute} />
                                <label for='{$field_id}_2' {$sub_label_class_attribute}>{$confirm_email_label}</label>
                            </span>
                            <div class='gf_clear gf_clear_complex'></div>
                        </div>";
			}
		} else {

			if ( $this->emailConfirmEnabled && ! $is_entry_detail ) {
				$first_tabindex        = $this->get_tabindex();
				$last_tabindex         = $this->get_tabindex();
				$email_value           = is_array( $value ) ? rgar( $value, 0 ) : $value;
				$email_value = esc_attr( $email_value );
				$confirmation_value    = is_array( $value ) ? rgar( $value, 1 ) : rgpost( 'input_' . $this->id . '_2' );
				$confirmation_value = esc_attr( $confirmation_value );
				$confirmation_disabled = $is_entry_detail ? "disabled='disabled'" : $disabled_text;
				if ( $is_sub_label_above ) {
					return "<div class='ginput_complex ginput_container ginput_container_email' id='{$field_id}_container'>
                                <span id='{$field_id}_1_container' class='ginput_left'>
                                    <label for='{$field_id}'>" . $enter_email_label . "</label>
                                    <input class='{$class}' type='{$html_input_type}' name='input_{$id}' id='{$field_id}' value='{$email_value}' {$first_tabindex} {$disabled_text} {$enter_email_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$aria_describedby} {$enter_email_autocomplete_attribute}/>
                                </span>
                                <span id='{$field_id}_2_container' class='ginput_right'>
                                    <label for='{$field_id}_2' {$sub_label_class_attribute}>{$confirm_email_label}</label>
                                    <input class='{$class}' type='{$html_input_type}' name='input_{$id}_2' id='{$field_id}_2' value='{$confirmation_value}' {$last_tabindex} {$confirmation_disabled} {$confirm_email_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$aria_describedby} {$confirm_email_autocomplete_attribute}/>
                                </span>
                                <div class='gf_clear gf_clear_complex'></div>
                            </div>";
				} else {
					return "<div class='ginput_complex ginput_container ginput_container_email' id='{$field_id}_container'>
                                <span id='{$field_id}_1_container' class='ginput_left'>
                                    <input class='{$class}' type='{$html_input_type}' name='input_{$id}' id='{$field_id}' value='{$email_value}' {$first_tabindex} {$disabled_text} {$enter_email_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$aria_describedby} {$enter_email_autocomplete_attribute}/>
                                    <label for='{$field_id}' {$sub_label_class_attribute}>{$enter_email_label}</label>
                                </span>
                                <span id='{$field_id}_2_container' class='ginput_right'>
                                    <input class='{$class}' type='{$html_input_type}' name='input_{$id}_2' id='{$field_id}_2' value='{$confirmation_value}' {$last_tabindex} {$confirmation_disabled} {$confirm_email_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$aria_describedby} {$confirm_email_autocomplete_attribute}/>
                                    <label for='{$field_id}_2' {$sub_label_class_attribute}>{$confirm_email_label}</label>
                                </span>
                                <div class='gf_clear gf_clear_complex'></div>
                            </div>";
				}
			} else {
				$tabindex = $this->get_tabindex();
				$value    = esc_attr( $value );
				$class    = esc_attr( $class );

				return "<div class='ginput_container ginput_container_email'>
                            <input name='input_{$id}' id='{$field_id}' type='{$html_input_type}' value='$value' class='{$class}' {$tabindex} {$disabled_text} {$single_placeholder_attribute} {$required_attribute} {$invalid_attribute} {$aria_describedby} {$single_autocomplete_attribute}/>
                        </div>";
			}
		}
	}

	public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
		if ( GFCommon::is_valid_email( $value ) && $format == 'html'  ) {
			return sprintf( "<a href='mailto:%s'>%s</a>", esc_attr( $value ), esc_html( $value ) );
		}

		return esc_html( $value );
	}

	public function get_value_submission( $field_values, $get_from_post_global_var = true ) {

		if ( $this->emailConfirmEnabled && ! $this->is_entry_detail() && is_array( $this->inputs ) ) {
			$value[0] = $this->get_input_value_submission( 'input_' . $this->id, $this->inputName, $field_values, $get_from_post_global_var );
			$value[1] = $this->get_input_value_submission( 'input_' . $this->id . '_2', $this->inputName, $field_values, $get_from_post_global_var );
		} else {
			$value = $this->get_input_value_submission( 'input_' . $this->id, $this->inputName, $field_values, $get_from_post_global_var );
		}

		return $value;
	}

	/**
	 * Removes the "for" attribute in the field label when the confirmation input is enabled.
	 * Inputs are only allowed one label (a11y) and the inputs already have labels.
	 *
	 * @since  2.4
	 * @access public
	 *
	 * @param array $form The Form Object currently being processed.
	 *
	 * @return string
	 */
	public function get_first_input_id( $form ) {
		return $this->emailConfirmEnabled ? '' : parent::get_first_input_id( $form );
	}

	// # FIELD FILTER UI HELPERS ---------------------------------------------------------------------------------------

	/**
	 * Returns the filter operators for the current field.
	 *
	 * @since 2.4
	 *
	 * @return array
	 */
	public function get_filter_operators() {
		$operators   = parent::get_filter_operators();
		$operators[] = 'contains';

		return $operators;
	}
}

GF_Fields::register( new GF_Field_Email() );
