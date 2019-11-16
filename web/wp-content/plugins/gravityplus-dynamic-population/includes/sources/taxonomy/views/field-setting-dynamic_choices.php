<?php
?>
<table id="gfp_dynamic_choices_source_taxonomy_settings_container" class="gfp_dynamic_choices_source_settings_container"
       style="display:none;">
    <tbody>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_taxonomy_name" class="inline">
                <?php _e( 'Taxonomy', 'gravityplus-dynamic-population' ) ?>
                <?php gform_tooltip( 'form_field_taxonomy_name' ) ?>
            </label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_taxonomy_name" class="gfp_dynamic_choices_source_setting">
                <option value="">-- <?php _e( 'Select name', 'gravityplus-dynamic-population' ) ?> --</option>

                <?php foreach ( $taxonomies as $taxonomy_name => $taxonomy_info ) { ?>
                <option value="<?php echo $taxonomy_name ?>"><?php echo $taxonomy_info->labels->name ?></option>
	            <?php } ?>
            </select>
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_taxonomy_label" class="inline">
                <?php _e( 'Choice Label', 'gravityplus-dynamic-population' ) ?></label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_taxonomy_label" class="gfp_dynamic_choices_source_setting">
                <option value="">-- <?php _e( 'Select label', 'gravityplus-dynamic-population' ) ?> --</option>

                <?php foreach ( $choice_label_options as $option_key => $option_label ) { ?>
                    <option value="<?php echo $option_key ?>"><?php echo $option_label ?></option>
	            <?php }

	            unset( $option_key, $option_label )?>
            </select></td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_taxonomy_value" class="inline">
			    <?php _e( 'Choice Value', 'gravityplus-dynamic-population' ) ?></label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_taxonomy_value" class="gfp_dynamic_choices_source_setting">
                <option value="">-- <?php _e( 'Select value', 'gravityplus-dynamic-population' ) ?> --</option>

			    <?php foreach ( $choice_value_options as $option_key => $option_label ) { ?>
                    <option value="<?php echo $option_key ?>"><?php echo $option_label ?></option>
			    <?php } ?>
            </select></td>
    </tr>
    <tr></tr>
    </tbody>
</table>