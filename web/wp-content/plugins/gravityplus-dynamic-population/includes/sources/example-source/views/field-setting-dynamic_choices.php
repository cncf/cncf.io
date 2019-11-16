<?php
?>
<table id="gfp_dynamic_choices_source_example_settings_container" class="gfp_dynamic_choices_source_settings_container"
       style="display:none;">
    <tbody>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_example_something" class="inline">
                <?php _e( 'Something', 'gravityplus-dynamic-population' ) ?>
                <?php gform_tooltip( 'form_field_example_something' ) ?>
            </label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_example_something" class="gfp_dynamic_choices_source_setting">
                <option value="">-- <?php _e( 'Select something', 'gravityplus-dynamic-population' ) ?> --</option>
                <option value="option1"><?php _e( 'Option 1', 'gravityplus-dynamic-population' ) ?></option>
                <option value="option2"><?php _e( 'Option 2', 'gravityplus-dynamic-population' ) ?></option>
            </select>
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_example_something_dependent" class="inline">
                <?php _e( 'Something (Dependent)', 'gravityplus-dynamic-population' ) ?>
            </label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_example_something_dependent" class="gfp_dynamic_choices_source_setting" disabled>
                <!-- Will be dynamically populated based on something choice -->
            </select>
        </td>
    </tr>
    <tr></tr>
    </tbody>
</table>