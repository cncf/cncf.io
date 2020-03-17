<div class="tool-box bg-white p-20p uipe-view custab">
    <h3 class="title wf-title"><?php _e('Step 1: Filter data for export', 'wf_customer_import_export'); ?></h3>
    <p>Use the filter options from below for a selective export of users. You can preview the selected users in the RHS.</p>
    <div class="lpdiv">
        <form id="lpform" action="<?php echo admin_url('admin.php?'); ?>" method="GET">
            <input type="hidden" name="page" value="hf_wordpress_customer_im_ex">
            <input type="hidden" name="section" value="export">
            <h4 class="title wf-title wf-sb-title"><?php _e('Filters', 'wf_customer_import_export'); ?></h4>
            <table id="wftable">
                <tr>
                    <th>
                        <label class="wf-lbl" for="v_offset"><?php _e('Offset', 'wf_customer_import_export'); ?>
                            <div class="woocommerce-help-tip wf-dvl">
                                <span class="tooltiptext"><?php _e('The number of users to skip before returning', 'wf_customer_import_export') ?></span>
                            </div>
                        </label>                           
                    </th>
                    <td>
                        <input type="text" name="offset" value="<?php echo!empty($_GET['offset']) ? intval($_GET['offset']) : ''; ?>" id="v_offset" placeholder="<?php _e('0', 'wf_customer_import_export'); ?>" class="input-text"/>
                    </td>
                </tr>            
                <tr>
                    <th>
                        <label class="wf-lbl" for="v_limit"><?php _e('Limit', 'wf_customer_import_export'); ?>
                            <div class="woocommerce-help-tip wf-dvl">
                                <span class="tooltiptext"><?php _e('The number of users to return', 'wf_customer_import_export') ?></span>
                            </div>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="limit" value="<?php echo!empty($_GET['limit']) ? intval($_GET['limit']) : ''; ?>" id="v_limit" placeholder="<?php _e('Unlimited', 'wf_customer_import_export'); ?>" class="input-text" />
                    </td>
                </tr>
                <tr>
                    <th>
                        <label class="wf-lbl" for="v_user_roles"><?php _e('User Roles', 'wf_customer_import_export'); ?>
                            <div class="woocommerce-help-tip wf-dvl">
                                <span class="tooltiptext"><?php _e('Users with these roles will be exported', 'wf_customer_import_export') ?></span>
                            </div>
                        </label>
                    </th>
                    <td>

                        <select id="v_user_roles" name="user_roles[]" data-placeholder="<?php _e('All Roles', 'wf_customer_import_export'); ?>"  class="wc-enhanced-select" multiple="multiple">

                            <?php
                            global $wp_roles;
                            foreach ($wp_roles->role_names as $role => $name) {
                                if (!empty($_GET['user_roles']) && in_array($role, $_GET['user_roles'])) {
                                    echo '<option value="' . esc_attr($role) . '" selected >' . $name . '</option>';
                                } else {
                                    echo '<option value="' . esc_attr($role) . '">' . $name . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <?php if (class_exists('WooCommerce') && WC()->version > '2.7') { ?>
                    <tr>
                        <th>
                            <label class="wf-lbl" for="v_user_email"><?php _e('User Email', 'wf_customer_import_export'); ?>
                                <div class="woocommerce-help-tip wf-dvl">
                                    <span class="tooltiptext"><?php _e('Users with these user emails will be exported', 'wf_customer_import_export') ?></span>
                                </div>
                            </label>
                        </th>
                        <td>
                            <select class="wc-customer-search" name="user_email[]" id="v_user_email" data-placeholder="<?php _e('All users', 'wf_customer_import_export'); ?>" multiple="multiple">
                                <?php
                                if (!empty($_GET['user_email'])) {
                                    foreach ($_GET['user_email'] as $user_id) {
                                        $user = get_user_by('id', absint($user_id));
                                        $user_string = sprintf(
                                                /* translators: 1: user display name 2: user ID 3: user email */
                                                esc_html__('%1$s', 'wf_customer_import_export'), $user->user_email
                                        );
                                        echo '<option value="' . esc_attr($user_id) . '" selected=' . "selected" . '>' . wp_kses_post($user_string) . '<option>';
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>
                        <label class="wf-lbl" for="u_start_date"><?php _e('From Date', 'wf_customer_import_export'); ?>
                            <div class="woocommerce-help-tip wf-dvl">
                                <span class="tooltiptext"><?php _e('Format: YYYY-MM-DD. Pick a start user registration date to limit the results.', 'wf_customer_import_export') ?></span>
                            </div>
                        </label>
                    </th>
                    <td>
                        <input id="u_start_date" value="<?php echo!empty($_GET['fromdate']) ? ($_GET['fromdate']) : ''; ?>" type="text" name="fromdate" class="input-text"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label class="wf-lbl" for="u_end_date"><?php _e('To Date', 'wf_customer_import_export'); ?>
                            <div class="woocommerce-help-tip wf-dvl">
                                <span class="tooltiptext"><?php _e('Format: YYYY-MM-DD. Pick an end user registration date to limit the results.', 'wf_customer_import_export') ?></span>
                            </div>
                        </label>
                    </th>
                    <td>
                        <input id="u_end_date" value="<?php echo!empty($_GET['todate']) ? ($_GET['todate']) : ''; ?>" type="text" name="todate" class="input-text"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label class="wf-lbl" for="v_user_order_by"><?php _e('Sort Columns', 'wf_customer_import_export'); ?>
                            <div class="woocommerce-help-tip wf-dvl">
                                <span class="tooltiptext"><?php _e('Sort by : ID ,user_registered ,user_email ,user_login ,user_nicename ,etc..', 'wf_customer_import_export') ?></span>
                            </div>
                        </label>
                    </th>
                    <td>

                        <?php
                        $sortcolumn = array('ID', 'user_registered', 'user_email', 'user_login', 'user_nicename');
                        $sort_meta_column = array('first_name', 'last_name', 'wc_last_active');
                        ?>
                        <select id="v_user_order_by" name="sortcolumn[]" data-placeholder="<?php _e('ID , user_email', 'wf_customer_import_export'); ?>" class="wc-enhanced-select" >
                          <option></option>
                            <optgroup label="User Field" id="user_field">
                                <?php
                                foreach ($sortcolumn as $type_name) {
                                    if (!empty($_GET['sortcolumn']) && in_array($type_name, $_GET['sortcolumn'])) {
                                        echo '<option value="' . $type_name . '" selected>' . ucwords($type_name) . '</option>';
                                    } else {
                                        echo '<option value="' . $type_name . '">' . ucwords($type_name) . '</option>';
                                    }
                                }
                                ?>
                            </optgroup>
                            <optgroup label="User Meta" id="meta_field">
                                <?php
                                foreach ($sort_meta_column as $type_name) {
                                    if (!empty($_GET['sortcolumn']) && in_array($type_name, $_GET['sortcolumn'])) {
                                        echo '<option value="' . $type_name . '" selected>' . ucwords($type_name) . '</option>';
                                    } else {
                                        echo '<option value="' . $type_name . '">' . ucwords($type_name) . '</option>';
                                    }
                                }
                                ?>

                            </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label class="wf-lbl" for="v_user_sort_order"><?php _e('Sorting Order', 'wf_customer_import_export'); ?>
                            <div class="woocommerce-help-tip wf-dvl">
                                <span class="tooltiptext"><?php _e('Sorted by : Ascending or Descending', 'wf_customer_import_export') ?></span>
                            </div>
                        </label>
                    </th>
                    <td>
                        <input type="radio" id="asc_ord" name="sort_ord" value="ASC" checked >
                        <label for="asc_ord">Asc</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="desc_ord" name="sort_ord" value="DESC" <?php if (isset($_GET['sort_ord']) && $_GET['sort_ord'] == 'DESC') { ?> checked <?php } ?> >
                        <label for="desc_ord">Desc</label>
                    </td>
                </tr>
            </table>
            <div id="leebtn">
                <button type="submit" class="button button-primary lftbtn"><?php _e('Apply Filter', 'wf_customer_import_export'); ?></button>
            </div>

            <div id="reebtn">
                <a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=export'); ?>" class="rgtbtn" style="text-decoration:none;"><span class="dashicons dashicons-image-rotate"></span><?php _e(' Reset', 'wf_customer_import_export'); ?></a>
            </div>
            <div class="clear"></div>
            <!-- </form> -->
        </form>
    </div>
    <div class="rpdiv">
        <div id="icon-users" class="icon32"><br/></div>

        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="wf-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <input type="hidden" name="section" value="export">
            <input type="hidden" name="offset" value="<?php echo!empty($_GET['offset']) ? intval($_GET['offset']) : ''; ?>" />
            <input type="hidden" name="limit" value="<?php echo!empty($_GET['limit']) ? intval($_GET['limit']) : ''; ?>" />
            <input type="hidden" name="fromdate" value="<?php echo!empty($_GET['fromdate']) ? ($_GET['fromdate']) : ''; ?>" />
            <input type="hidden" name="todate" value="<?php echo!empty($_GET['todate']) ? ($_GET['todate']) : ''; ?>" />
            <input type="hidden" name="sortby" value="<?php echo!empty($_GET['sortby']) ? ($_GET['sortby']) : ''; ?>" />
            <input type="hidden" name="sort_order" value="<?php echo!empty($_GET['sort_order']) ? ($_GET['sort_order']) : ''; ?>" />
            <?php
            if (!empty($_GET['user_roles'])) {
                foreach ($_GET['user_roles'] as $value) {
                    echo '<input type="hidden" name="user_roles[]" value="' . $value . '">';
                }
            }
            if (!empty($_GET['user_email'])) {
                foreach ($_GET['user_email'] as $id) {
                    echo '<input type="hidden" name="user_email[]" value="' . $id . '">';
                }
            }
            ?>
            <!-- Now we can render the completed list table -->
            <?php $wfListTable->display() ?>
        </form>

    </div>
    <div class="clear"></div>
    <div class="epdiv">
        <a id="map-and-transform" class="cbutton button button-primary"><?php _e('Step 2: Map and transform >>', 'wf_customer_import_export'); ?></a>
    </div>

</div>

<?php if (!class_exists('WooCommerce')) { ?>
    <script>
        jQuery(document).ready(function () {
            jQuery('.wc-enhanced-select').select2();
        });
    </script>
<?php } ?>
<script>
    jQuery(document).ready(function ($) {
        $("#cancelbtn").click(function () {
            $(location).attr('href', '<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=export'); ?>')
        });
        $("#map-and-transform").click(function () {
            var sort_order = $("input:radio[name=sort_ord]:checked").val();
            if ($('#v_user_email').val()) {
                var path = '&offset=' + $('#v_offset').val() + '&limit=' + $('#v_limit').val() + '&fromdate=' + $('#u_start_date').val() + '&todate=' + $('#u_end_date').val() + '&user_roles=' + $('#v_user_roles').val() + '&user_email=' + $('#v_user_email').val() + '&sortby=' + $('#v_user_order_by').val() + '&sort_order=' + sort_order;
            } else {
                var path = '&offset=' + $('#v_offset').val() + '&limit=' + $('#v_limit').val() + '&fromdate=' + $('#u_start_date').val() + '&todate=' + $('#u_end_date').val() + '&user_roles=' + $('#v_user_roles').val() + '&sortby=' + $('#v_user_order_by').val() + '&sort_order=' + sort_order;
            }

            $('#map-and-transform').attr('href', '<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=export&action=map-and-transform'); ?>' + path);

        });
    });

    
</script>
