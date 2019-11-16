<?php
?>
<table id="gfp_dynamic_choices_source_salesforce_settings_container" class="gfp_dynamic_choices_source_settings_container"
       style="display:none;">
    <tbody>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_salesforce_object" class="inline">
				<?php _e( 'Object', 'gravityplus-dynamic-population-salesforce' ) ?>
            </label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_salesforce_object" class="gfp_dynamic_choices_source_setting">
                <option value="">-- <?php _e( 'Select object', 'gravityplus-dynamic-population-salesforce' ) ?> --</option>
	            <?php foreach ( $sobjects as $sobject ) { ?>
                    <option value="<?php echo $sobject['value']; ?>"><?php echo $sobject['label']; ?></option>
	            <?php } ?>
            </select>
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>
            <label for="gfp_dynamic_choices_source_salesforce_object_field" class="inline">
                <?php _e( 'Field', 'gravityplus-dynamic-population-salesforce' ) ?>
            </label>
        </td>
        <td>
            <select id="gfp_dynamic_choices_source_salesforce_object_field" class="gfp_dynamic_choices_source_setting">
                <!-- Will be dynamically populated based on organization choice -->
            </select></td>
    </tr>
    
    <tr></tr>
    </tbody>
</table>