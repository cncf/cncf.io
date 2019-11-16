<?php
?>
<table id="gfp_dynamic_choices_source_posts_settings_container" class="gfp_dynamic_choices_source_settings_container"
       style="display:none;">
    <tbody>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_post_type" class="inline">
			    <?php _e( 'Post Type', 'gravityplus-dynamic-population' ) ?>
			    <?php gform_tooltip( 'form_field_post_type' ) ?>
            </label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_post_type" class="gfp_dynamic_choices_source_setting">
                <option value="">-- <?php _e( 'Select post type', 'gravityplus-dynamic-population' ) ?> --</option>
                <option value="all"><?php echo $all_option_label ?></option>
                <?php foreach ( $post_types as $post_type_name ) { ?>
                    <option value="<?php echo $post_type_name ?>"><?php echo $post_type_name ?></option>
			    <?php } ?>
            </select>
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_posts_taxonomy" class="inline">
                <?php _e( 'Taxonomy Type', 'gravityplus-dynamic-population' ) ?>
                <?php gform_tooltip( 'form_field_taxonomy' ) ?>
            </label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_posts_taxonomy" class="gfp_dynamic_choices_source_setting">
                <option value="">-- <?php _e( 'Select taxonomy type', 'gravityplus-dynamic-population' ) ?> --</option>
                <option value="all"><?php echo $all_option_label ?></option>

                <?php foreach ( $taxonomies as $taxonomy_name => $taxonomy_info ) { ?>
                <option value="<?php echo $taxonomy_name ?>"><?php echo $taxonomy_info->labels->name ?></option>
	            <?php } ?>
            </select>
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_posts_taxonomy_term" class="inline">
			    <?php _e( 'Taxonomy', 'gravityplus-dynamic-population' ) ?>
            </label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_posts_taxonomy_term" class="gfp_dynamic_choices_source_setting">
                <!-- Will be dynamically populated based on taxonomy choice -->
            </select></td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_posts_label" class="inline">
                <?php _e( 'Choice Label', 'gravityplus-dynamic-population' ) ?></label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_posts_label" class="gfp_dynamic_choices_source_setting">
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
            <label for="gfp_dynamic_choices_source_posts_value" class="inline">
			    <?php _e( 'Choice Value', 'gravityplus-dynamic-population' ) ?></label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_posts_value" class="gfp_dynamic_choices_source_setting">
                <option value="">-- <?php _e( 'Select value', 'gravityplus-dynamic-population' ) ?> --</option>

			    <?php foreach ( $choice_value_options as $option_key => $option_label ) { ?>
                    <option value="<?php echo $option_key ?>"><?php echo $option_label ?></option>
			    <?php } ?>
            </select></td>
    </tr>
    <tr></tr>
    </tbody>
</table>