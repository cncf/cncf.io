<?php
/**
 * WordPress Importer class for managing the import process of a CSV file
 *
 * @package WordPress
 * @subpackage Importer
 */
if (!class_exists('WP_Importer'))
    return;

class WF_CustomerImpExpCsv_Customer_Import extends WP_Importer {

    var $id;
    var $file_url;
    var $delimiter;
    var $send_mail;
    var $profile;
    var $merge_empty_cells;
    var $processed_terms = array();
    var $processed_posts = array();
    var $merged = 0;
    var $skipped = 0;
    var $imported = 0;
    var $errored = 0;
    // Results
    var $import_results = array();
    var $log = false;

    /**
     * Constructor
     */
    public function __construct() {

        // Check that the class exists before trying to use it
        if (function_exists('WC')) {
		if(WC()->version < '3.0')
		{
                $this->log = new WC_Logger();
		}
		else
		{
                $this->log = wc_get_logger();
            }
        }

        $this->user_base_fields = array(
            'ID' => 'ID',
            'user_login' => 'user_login',
            'user_pass' => 'user_pass',
            'user_nicename' => 'user_nicename',
            'user_email' => 'user_email',
            'user_url' => 'user_url',
            'user_registered' => 'user_registered',
            'display_name' => 'display_name',
            'user_status' => 'user_status',
            'roles' => 'roles'
        );
        $this->import_page = 'wordpress_hf_user_csv';
        $this->file_url_import_enabled = apply_filters('woocommerce_csv_user_file_url_import_enabled', true);

        global $wpdb;
        $meta_keys = $wpdb->get_col("SELECT distinct(meta_key) FROM $wpdb->usermeta");

        foreach ($meta_keys as $meta_key) {
            $this->user_meta_fields[$meta_key] = $meta_key;
        }
    }

	public function hf_log_data_change ($content = 'user-csv-import',$data='')
	{
        if (function_exists('WC')) {
		if (WC()->version < '2.7.0')
		{
                $this->log->add($content, $data);
		}else
		{
                $context = array('source' => $content);
                $this->log->log("debug", $data, $context);
            }
        }
    }

    /**
     * Registered callback function for the WordPress Importer
     *
     * Manages the three separate stages of the CSV import process
     */
    public function dispatch() {

        global $woocommerce, $wpdb;

        if (!empty($_POST['delimiter'])) {
            $this->delimiter = stripslashes(trim($_POST['delimiter']));
        } else if (!empty($_GET['delimiter'])) {
            $this->delimiter = stripslashes(trim($_GET['delimiter']));
        }

        if (!$this->delimiter)
            $this->delimiter = ',';


        $this->send_mail = !empty($_POST['send_mail']) ? 1 : 0;


        if (!empty($_POST['profile'])) {
            $this->profile = stripslashes(trim($_POST['profile']));
        } else if (!empty($_GET['profile'])) {
            $this->profile = stripslashes(trim($_GET['profile']));
        }
        if (!$this->profile)
            $this->profile = '';

        if (!empty($_POST['merge_empty_cells']) || !empty($_GET['merge_empty_cells'])) {
            $this->merge_empty_cells = 1;
        } else {
            $this->merge_empty_cells = 0;
        }

        $step = empty($_GET['step']) ? 0 : (int) $_GET['step'];

        switch ($step) {
            case 0 :
                $this->header();
                $this->greet();
                break;
            case 1 :
                $this->header();
                if (!WF_Customer_Import_Export_CSV::hf_user_permission()) {
                    wp_die(__('Access Denied', 'wf_customer_import_export'));
                }
                check_admin_referer('import-upload');

                if (!empty($_GET['file_url']))
                    $this->file_url = esc_attr($_GET['file_url']);
                if (!empty($_GET['file_id']))
                    $this->id = $_GET['file_id'];

                if (!empty($_GET['clearmapping']) || $this->handle_upload())
                    $this->import_options();
                else
                    _e('Error with handle_upload!', 'wf_customer_import_export');
                break;
            case 2 :
                $this->header();
                if (!WF_Customer_Import_Export_CSV::hf_user_permission()) {
                    wp_die(__('Access Denied', 'wf_customer_import_export'));
                }
                check_admin_referer('import-woocommerce');

                $this->id = (int) $_POST['import_id'];

                if ($this->file_url_import_enabled)
                    $this->file_url = esc_attr($_POST['import_url']);

                if ($this->id)
                    $file = get_attached_file($this->id);
                else if ($this->file_url_import_enabled)
                    $file = $this->file_url;

                $file = str_replace("\\", "/", $file);

                if ($file) {
                    ?>
                    <table id="import-progress" class="widefat_importer widefat">
                        <thead>
                            <tr>
                                <th class="status">&nbsp;</th>
                                <th class="row"><?php _e('Row', 'wf_customer_import_export'); ?></th>
                                <th><?php _e('User ID', 'wf_customer_import_export'); ?></th>
                                <th><?php _e('User Status', 'wf_customer_import_export'); ?></th>
                                <th class="reason"><?php _e('Status Msg', 'wf_customer_import_export'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="importer-loading">
                                <td colspan="5"></td>         </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                        if (! window.console) { window.console = function(){}; }

                                                var processed_terms = [];
                                        var processed_posts = [];
                    var i = 1;
                    var done_count = 0;

                    function import_rows(start_pos, end_pos) {
                                        var data = {
                                        action:    'user_csv_import_request',
                                        file:       '<?php echo addslashes($file); ?>',
                                                mapping:    '<?php echo json_encode($_POST['map_from']); ?>',
                                                profile:    '<?php echo $this->profile; ?>',
                                                eval_field: '<?php echo stripslashes(json_encode(($_POST['eval_field']), JSON_HEX_APOS)) ?>',
                                delimiter:  '<?php echo $this->delimiter; ?>',
                                                send_mail:  '<?php echo $this->send_mail; ?>',
                                                merge_empty_cells: '<?php echo $this->merge_empty_cells; ?>',
                                                start_pos:  start_pos,
                                                end_pos:    end_pos,
                                                wt_nonce:   '<?php echo wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ?>'
                        };
                                        data.eval_field = $.parseJSON(data.eval_field);
                        return $.ajax({
                                        url:        '<?php echo add_query_arg(array('import_page' => $this->import_page, 'step' => '3', 'use_same_password' => !empty($_GET['use_same_password']) ? '1' : '0', 'insert_with_id' => !empty($_GET['insert_with_id']) ? '1' : '0', 'merge' => !empty($_GET['merge']) ? '1' : '0', 'merge_with' => $_GET['merge_with']), admin_url('admin-ajax.php')); ?>',
                                data:       data,
                                                type:       'POST',
                                                success:    function(response) {
                                                if (response) {
                                try {
                                                // Get the valid JSON only from the returned string
                                                if (response.indexOf("<!--WC_START-->") >= 0)
                                                        response = response.split("<!--WC_START-->")[1]; // Strip off before after WC_START

                                                if (response.indexOf("<!--WC_END-->") >= 0)
                                                        response = response.split("<!--WC_END-->")[0]; // Strip off anything after WC_END

                                                // Parse
                                                var results = $.parseJSON(response);
                                                if (results.error) {
                                                $('#import-progress tbody').append('<tr id="row-' + i + '" class="error"><td class="status" colspan="5">' + results.error + '</td></tr>');
                                                                            i++;
                                                                            } else if (results.import_results && $(results.import_results).size() > 0) {
                                                                            $.each(results.processed_terms, function(index, value) {
                                                                            processed_terms.push(value);
                                                                            });
                                                                            $.each(results.processed_posts, function(index, value) {
                                                                            processed_posts.push(value);
                                                                            });
                                                                            $(results.import_results).each(function(index, row) {
                                                                            $('#import-progress tbody').append('<tr id="row-' + i + '" class="' + row['status'] + '"><td><mark class="result" title="' + row['status'] + '">' + row['status'] + '</mark></td><td class="row">' + i + '</td><td>' + row['user_id'] + '</td><td>' + row['post_id'] + ' - ' + row['post_title'] + '</td><td class="reason">' + row['reason'] + '</td></tr>');
                                                                                                        i++;
                                                                                                        });
                                                                                                        }
                                                                                                        } catch (err) {}
                                                                                                        } else {
                                                                                                        $('#import-progress tbody').append('<tr class="error"><td class="status" colspan="5">' +     '<?php _e('AJAX Error', 'wf_customer_import_export'); ?>' + '</td></tr>');
                                                                                                                                    }

                                                                                                                                    var w = $(window);
                                                                                                                                    var row = $("#row-" + (i - 1));
                                                                                                                                    if (row.length) {
                                                                                                                                    w.scrollTop(row.offset().top - (w.height() / 2));
                                                                                                                                    }
                                                                                                                                    done_count++;
                                                                                                                                    $('body').trigger('user_csv_import_request_complete');
                                                                                                                                    },
                                error:  function (jqXHR, httpStatusMessage, customErrorMessage) {
                    import_rows(start_pos, end_pos);
                    } 
                    });
                    }

                    var rows = [];
                    <?php
                    $limit = apply_filters('woocommerce_csv_import_limit_per_request', 10);
                    $enc = mb_detect_encoding($file, 'UTF-8, ISO-8859-1', true);
                    if ($enc)
                        setlocale(LC_ALL, 'en_US.' . $enc);
                    @ini_set('auto_detect_line_endings', true);

                    $count = 0;
                    $previous_position = 0;
                    $position = 0;
                    $import_count = 0;

// Get CSV positions
                    if (( $handle = fopen($file, "r") ) !== FALSE) {

                        while (( $postmeta = fgetcsv($handle, 0, $this->delimiter) ) !== FALSE) {
                            $count++;

                            if ($count >= $limit) {
                                $previous_position = $position;
                                $position = ftell($handle);
                                $count = 0;
                                $import_count ++;

// Import rows between $previous_position $position
                                ?>rows.push([ <?php echo $previous_position; ?>, <?php echo $position; ?> ]); <?php
                            }
                        }

// Remainder
                        if ($count > 0) {
                            ?>rows.push([ <?php echo $position; ?>, '' ]); <?php
                            $import_count ++;
                        }

                        fclose($handle);
                    }
                    ?>

                    var data = rows.shift();
                    var regen_count = 0;
                    import_rows( data[0], data[1] );

                    $('body').on( 'user_csv_import_request_complete', function() {
                    if ( done_count == <?php echo $import_count; ?> ) {
                    import_done();
                    } else {
                    // Call next request
                    data = rows.shift();
                    import_rows( data[0], data[1] );
                    }
                    } );

                    function import_done() {
                    var data = {
                    action: 'user_csv_import_request',
                    file: '<?php echo $file; ?>',
                    processed_terms: processed_terms,
                    processed_posts: processed_posts,
                    wt_nonce:   '<?php echo wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ?>'
                    };

                    $.ajax({
                    url: '<?php echo add_query_arg(array('import_page' => $this->import_page, 'step' => '4', 'merge' => !empty($_GET['merge']) ? 1 : 0), admin_url('admin-ajax.php')); ?>',
                    data:       data,
                    type:       'POST',
                    success:    function( response ) {
                    console.log( response );
                    $('#import-progress tbody').append( '<tr class="complete"><td colspan="5">' + response + '</td></tr>' );
                    $('.importer-loading').hide();
                    }
                    });
                    }
                    });
                    </script>
                    <?php
                } else {
                    echo '<p class="error">' . __('Error finding uploaded file!', 'wf_customer_import_export') . '</p>';
                }
                break;
            case 3 :

                // Check access 
                $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
                if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !WF_Customer_Import_Export_CSV::hf_user_permission()) {
                    wp_die(__('Access Denied', 'wf_customer_import_export'));
                }
                $file      = stripslashes( $_POST['file'] ); // Validating given path is valid path, not a URL
                if (filter_var($file, FILTER_VALIDATE_URL)) {
                    die();
                }
                
                add_filter('http_request_timeout', array($this, 'bump_request_timeout'));

                if (function_exists('gc_enable'))
                    gc_enable();

                @set_time_limit(0);
                @ob_flush();
                @flush();
                $wpdb->hide_errors();

                $mapping = json_decode(stripslashes($_POST['mapping']), true);
                $profile = isset($_POST['profile']) ? $_POST['profile'] : '';
                $eval_field = $_POST['eval_field'];
                $start_pos = isset($_POST['start_pos']) ? absint($_POST['start_pos']) : 0;
                $end_pos = isset($_POST['end_pos']) ? absint($_POST['end_pos']) : '';

//                if ($profile !== '') {
//                    $profile_array = get_option('wf_user_csv_imp_exp_mapping');
//                    $profile_array[$profile] = array($mapping, $eval_field);
//                    update_option('wf_user_csv_imp_exp_mapping', $profile_array);
//                }

                $position = $this->import_start($file, $mapping, $start_pos, $end_pos, $eval_field);
                $this->import();
                $this->import_end();

                $results = array();
                $results['import_results'] = $this->import_results;
                $results['processed_terms'] = $this->processed_terms;
                $results['processed_posts'] = $this->processed_posts;

                echo "<!--WC_START-->";
                echo json_encode($results);
                echo "<!--WC_END-->";
                exit;
                break;
            case 4 :                
                // Check access 
                $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
                if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !WF_Customer_Import_Export_CSV::hf_user_permission()) {
                    wp_die(__('Access Denied', 'wf_customer_import_export'));
                }                
                $file = stripslashes($_POST['file']);                
                add_filter('http_request_timeout', array($this, 'bump_request_timeout'));

                if (function_exists('gc_enable'))
                    gc_enable();

                @set_time_limit(0);
                @ob_flush();
                @flush();
                $wpdb->hide_errors();

                $this->processed_terms = isset($_POST['processed_terms']) ? $_POST['processed_terms'] : array();
                $this->processed_posts = isset($_POST['processed_posts']) ? $_POST['processed_posts'] : array();

                if (apply_filters('wt_import_processed_userid_save_flag', false)) {    //delete user not in csv
                    //get csv user
                    $csv_user = get_option('wt_cust_csv_imp_exp_processed_user_ids');
                    //get all users
                    /* $users = get_users( array( 'fields' => array( 'ID' ) ) );
                      $json  = json_encode($users);
                      $all_usre_id= json_decode($json, true);
                      foreach ($all_usre_id as $ids) {
                      $all_usre_ids[]=$ids['ID'];
                      } */

                    global $wpdb;
                    $all_usre_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users");

                    //get administrator user
                    /*  $admin_users=get_users( array( 'role' => 'administrator' ));
                      foreach ( $admin_users as $admin ) {
                      $administrator[]= $admin->ID ;
                      } */
                    $administrator = $wpdb->get_col("SELECT u.ID FROM $wpdb->users u INNER JOIN $wpdb->usermeta m ON m.user_id = u.ID WHERE m.meta_key = '{$wpdb->prefix}capabilities' AND m.meta_value LIKE '%administrator%' ORDER BY u.user_registered ");
                    $current_user = get_current_user_id();
                    $current_user_id[] = $current_user;
                    $insert_users = array_merge($csv_user, $administrator, $current_user_id);
                    $insert_users = array_unique($insert_users);
                    $delete_users = array_diff($all_usre_ids, $insert_users);

                    foreach ($delete_users as $delete) {
                        wp_delete_user($delete);
                    }

                    delete_option('wt_cust_csv_imp_exp_processed_user_ids');
                }



                _e('Step 1...', 'wf_customer_import_export') . ' ';

                wp_defer_term_counting(true);
                wp_defer_comment_counting(true);

                _e('Step 2...', 'wf_customer_import_export') . ' ';

                echo 'Step 3...' . ' '; // Easter egg

                _e('Finalizing...', 'wf_customer_import_export') . ' ';

                // SUCCESS
                _e('Finished. Import complete.', 'wf_customer_import_export');

                $this->import_end();

                if(in_array(pathinfo($file, PATHINFO_EXTENSION),array('txt','csv'))){
                    unlink($file); // deleting temparary file from meadia library by path
                }
                exit;
                break;
        }

        $this->footer();
    }

    /**
     * format_data_from_csv
     */
    public function format_data_from_csv($data, $enc) {
        return ( $enc == 'UTF-8' ) ? $data : utf8_encode($data);
    }

    /**
     * Display pre-import options
     */
    public function import_options() {
        $j = 0;

        if ($this->id)
            $file = get_attached_file($this->id);
        else if ($this->file_url_import_enabled)
            $file = $this->file_url;
        else
            return;

        // Set locale
        $enc = mb_detect_encoding($file, 'UTF-8, ISO-8859-1', true);
        if ($enc)
            setlocale(LC_ALL, 'en_US.' . $enc);
        @ini_set('auto_detect_line_endings', true);

        // Get headers
        if (( $handle = fopen($file, "r") ) !== FALSE) {
            $row = $raw_headers = array();
            $header = fgetcsv($handle, 0, $this->delimiter);
            while (( $postmeta = fgetcsv($handle, 0, $this->delimiter) ) !== FALSE) {
                foreach ($header as $key => $heading) {
                    if (!$heading)
                        continue;
                    $s_heading = $heading;
                    $row[$s_heading] = ( isset($postmeta[$key]) ) ? $this->format_data_from_csv($postmeta[$key], $enc) : '';
                    $raw_headers[$s_heading] = $heading;
                }
                break;
            }
            fclose($handle);
        }

        $mapping_from_db = get_option('wf_user_csv_imp_exp_mapping');

        if ($this->profile !== '' && !empty($_GET['clearmapping'])) {
            unset($mapping_from_db[$this->profile]);
            update_option('wf_user_csv_imp_exp_mapping', $mapping_from_db);
            $this->profile = '';
        }
        if ($this->profile !== '')
            $mapping_from_db = $mapping_from_db[$this->profile];

        $saved_mapping = null;
        $saved_evaluation = null;
        if ($mapping_from_db && is_array($mapping_from_db) && count($mapping_from_db) == 2 && empty($_GET['clearmapping'])) {
            $reset_action = 'admin.php?clearmapping=1&amp;profile=' . $this->profile . '&amp;import=' . $this->import_page . '&amp;step=1&amp;file_url=' . $this->file_url . '&amp;delimiter=' . $this->delimiter . '&amp;merge_empty_cells=' . $this->merge_empty_cells . '&amp;send_mail=' . $this->send_mail . '&amp;file_id=' . $this->id . '';
            $reset_action = esc_attr(wp_nonce_url($reset_action, 'import-upload'));
            $saved_mapping = $mapping_from_db[0];
            $saved_evaluation = $mapping_from_db[1];
        }

        $merge = (!empty($_POST['merge']) && $_POST['merge']) ? 1 : 0;
        $merge_with = (!empty($_POST['merge_with']) && $_POST['merge_with']) ? $_POST['merge_with'] : 'email';
        $insert_with_id = (!empty($_POST['insert_with_id']) && $_POST['insert_with_id']) ? 1 : 0;
        $use_same_password = (!empty($_POST['use_same_password']) && $_POST['use_same_password']) ? 1 : 0;
        
        include( 'views/html-wf-import-options.php' );
    }

    /**
     * The main controller for the actual import stage.
     */
    public function import() {
        global $woocommerce, $wpdb;

        wp_suspend_cache_invalidation(true);
        if ($this->log) {
            $this->hf_log_data_change('user-csv-import', '---');
            $this->hf_log_data_change('user-csv-import', __('Processing users.', 'wf_customer_import_export'));
        }
        $merging = 1;
        $record_offset = 0;

        $i = 0;
        foreach ($this->parsed_data as $key => &$item) {
            $user = $this->parser->parse_users($item, $this->raw_headers, $merging, $record_offset);
            if (!is_wp_error($user))
                $this->process_users($user['user'][0], $this->raw_headers, $item);
            else
                $this->add_import_result('failed', $user->get_error_message(), 'Not parsed', json_encode($item), '-');

            unset($item, $user);
            $i++;
        }
        if ($this->log)
            $this->hf_log_data_change('user-csv-import', __('Finished processing Users.', 'wf_customer_import_export'));
        wp_suspend_cache_invalidation(false);
    }

    /**
     * Parses the CSV file and prepares us for the task of processing parsed data
     *
     * @param string $file Path to the CSV file for importing
     */
    public function import_start($file, $mapping, $start_pos, $end_pos, $eval_field) {
        if (function_exists('WC')) {
            $memory = size_format((WC()->version < '2.7.0') ? woocommerce_let_to_num(ini_get('memory_limit')) : wc_let_to_num(ini_get('memory_limit')));
            $wp_memory = size_format((WC()->version < '2.7.0') ? woocommerce_let_to_num(WP_MEMORY_LIMIT) : wc_let_to_num(WP_MEMORY_LIMIT));
        } else {
            $memory = size_format($this->wf_let_to_num(ini_get('memory_limit')));
            $wp_memory = size_format($this->wf_let_to_num(WP_MEMORY_LIMIT));
        }
        if ($this->log) {
            $this->hf_log_data_change('user-csv-import', '---[ New Import ] PHP Memory: ' . $memory . ', WP Memory: ' . $wp_memory);
            $this->hf_log_data_change('user-csv-import', __('Parsing users CSV.', 'wf_customer_import_export'));
        }
        $this->parser = new WF_CSV_Parser('user');
        list( $this->parsed_data, $this->raw_headers, $position ) = $this->parser->parse_data($file, $this->delimiter, $mapping, $start_pos, $end_pos, $eval_field);
        if ($this->log)
            $this->hf_log_data_change('user-csv-import', __('Finished parsing users CSV.', 'wf_customer_import_export'));
        unset($import_data);
        wp_defer_term_counting(true);
        wp_defer_comment_counting(true);
        return $position;
    }

    /**
     * Performs post-import cleanup of files and the cache
     */
    public function import_end() {
        //wp_cache_flush(); Stops output in some hosting environments
        foreach (get_taxonomies() as $tax) {
            delete_option("{$tax}_children");
            _get_term_hierarchy($tax);
        }
        wp_defer_term_counting(false);
        wp_defer_comment_counting(false);
        do_action('import_end');
    }

    /**
     * Handles the CSV upload and initial parsing of the file to prepare for
     * displaying author import options
     *
     * @return bool False if error uploading or invalid file, true otherwise
     */
    public function handle_upload() {
        if ($this->handle_ftp()) {
            return true;
        }
        if (empty($_POST['file_url'])) {
            $file = wp_import_handle_upload();
            if (isset($file['error'])) {
                echo '<p><strong>' . __('Sorry, there has been an error.', 'wf_customer_import_export') . '</strong><br />';
                echo esc_html($file['error']) . '</p>';
                return false;
            }
            $this->id = (int) $file['id'];
            return true;
        } else {
            if (file_exists(ABSPATH . $_POST['file_url'])) {
                $this->file_url = esc_attr($_POST['file_url']);
                return true;
            } else {
                echo '<p><strong>' . __('Sorry, there has been an error.', 'wf_customer_import_export') . '</strong></p>';
                return false;
            }
        }
        return false;
    }

    /**
     * Create new posts based on import information
     */
    private function process_users($post, $check_raw_headers, $parsed_item) {
        $this->user_meta_fields = $check_raw_headers;
        // filter 
        foreach ($check_raw_headers as $key => $value) {
            if (strstr($key, 'meta:')) {
                unset($this->user_meta_fields[$key]);
                $key_val = $key;
                $key = trim(str_replace('meta:', '', $key));
//                if ($this->user_meta_fields[$key])
//                    continue;
                $this->user_meta_fields[$key] = $key_val;
            }
        }

        global $wpdb;
        $this->imported = $this->merged = 0;
        $merging = (!empty($_GET['merge'])) ? 1 : 0;
        $merge_with = (!empty($_GET['merge_with'])) ? $_GET['merge_with'] : 'email';
        $insert_with_id = (!empty($_GET['insert_with_id'])) ? 1 : 0;
        $use_same_password = (!empty($_GET['use_same_password'])) ? 1 : 0;
        
        $roles = array();
        $roles['roles'] = $post['user_details']['roles'];
        $roles = apply_filters('hf_customer_csv_exclude_admin', $roles);
        if (empty($roles)) {
            $this->add_import_result('skipped', __('Admin User Import skipped', 'wf_customer_import_export'), 1, 1, 1);
            unset($post);
            return;
        }
        // plan a dry run
        //$dry_run = isset( $_POST['dry_run'] ) && $_POST['dry_run'] ? true : false;
        $dry_run = 0; //mockup import and check weather the users can be imported without fail
//        if ($this->log) {
//            $this->hf_log_data_change('user-csv-import', '---');
//            $this->hf_log_data_change('user-csv-import', __('Processing users.', 'wf_customer_import_export'));
//        }
        $create_user_without_email = apply_filters('wt_create_user_without_email', FALSE);   // create user without email address
        if (empty($post['user_details']['user_email']) && $create_user_without_email === FALSE) {
            $this->add_import_result('skipped', __('Cannot insert user without email', 'wf_customer_import_export'), 1, 1, 1);
            unset($post);
            return;
        } elseif (!is_email($post['user_details']['user_email']) && $create_user_without_email === FALSE) {
            $this->add_import_result('skipped', __('skipped: Email is not valid.', 'wf_customer_import_export'), 1, $post['user_details']['user_email'], 1);
            unset($post);
            return;
        }

        //merge with user_id instead of email
        if ($merging && $merge_with == 'id') {
            $user_id = !empty($post['user_details']['ID']) && $post['user_details']['ID'] ? $post['user_details']['ID'] : 'Id_not_exist';
            if ($user_id == 'Id_not_exist') {
                if ($this->log)
                    $this->hf_log_data_change('user-csv-import', sprintf(__('User could not be update without ID.', 'wf_customer_import_export')));
                $this->add_import_result('skipped', __('User could not be update without ID.', 'wf_customer_import_export'), '', 'skipped');
                unset($post);
                return;
            }else {
                $user_id_for_existance_chk = get_userdata($user_id);
                if ($user_id_for_existance_chk) {
                    $get_user_data = get_user_by('id', $user_id);
                    $get_user_email = $get_user_data->user_email;
                }

                if ($user_id_for_existance_chk === false && $merge_with == 'id') {
                    $user_id = false;
                }
                if ($user_id_for_existance_chk && $get_user_email != $post['user_details']['user_email'] && email_exists($post['user_details']['user_email'])) {

                    $usr_msg = 'User with the same email id already exists';
                    $user_info = get_userdata($user_id);
                    $user_string = sprintf('<a href="%s">%s</a>', get_edit_user_link($user_id), $user_info->first_name);
                    $this->add_import_result('skipped', __($usr_msg, 'wf_customer_import_export'), $user_id, $user_string, $user_id);
                    if ($this->log)
                        $this->hf_log_data_change('user-csv-import', sprintf(__('> &#8220;%s&#8221;' . $usr_msg, 'wf_customer_import_export'), $user_id), true);
                    unset($post);
                    return;
                }
            }
        }else {
            $user_id = $this->hf_check_customer($post);
        }

        if (apply_filters('wt_import_processed_userid_save_flag', false) && $user_id != false) {
            $this->save_processed_user_id_in_db((int) $user_id);
        }

        //  user exists when importing &  merge not ticked
        $new_added = false;

        if (!$merging && $user_id) {
            $usr_msg = 'User with same email already exists.';
            $user_info = get_userdata($user_id);
            $user_string = sprintf('<a href="%s">%s</a>', get_edit_user_link($user_id), $user_info->first_name);
            $this->add_import_result('skipped', __($usr_msg, 'wf_customer_import_export'), $user_id, $user_string, $user_id);
            if ($this->log)
                $this->hf_log_data_change('user-csv-import', sprintf(__('> &#8220;%s&#8221;' . $usr_msg, 'wf_customer_import_export'), $user_id), true);
            unset($post);
            return;
        } elseif ($user_id && $merging) {
            $current_user = get_current_user_id();
            if ($current_user == $user_id) {
                $usr_msg = 'Current user is skipped.';
                $user_info = get_userdata($user_id);
                $user_string = sprintf('<a href="%s">%s</a>', get_edit_user_link($user_id), $user_info->first_name);
                $this->add_import_result('skipped', __($usr_msg, 'wf_customer_import_export'), $user_id, $user_string, $user_id);
                if ($this->log)
                    $this->hf_log_data_change('user-csv-import', sprintf(__('> &#8220;%s&#8221;' . $usr_msg, 'wf_customer_import_export'), $user_id), true);
                unset($post);
                return;
            }
            $user_id = $this->hf_update_customer($user_id, $post, $this->send_mail);
        } else {

            if ($insert_with_id == 1) {
                $cust_id = !empty($post['user_details']['ID']) && $post['user_details']['ID'] ? $post['user_details']['ID'] : '';
                $cust_id_existance_chk = get_userdata($cust_id);

                if ($cust_id == '') {
                    $usr_msg = 'User could not be created without ID.';
                    $user_info = get_userdata($cust_id);
                    $user_string = sprintf('<a href="%s">%s</a>', get_edit_user_link($cust_id), $user_info->first_name);
                    $this->add_import_result('skipped', __($usr_msg, 'wf_customer_import_export'), $cust_id, $user_string, $cust_id);
                    if ($this->log)
                        $this->hf_log_data_change('user-csv-import', sprintf(__('> &#8220;%s&#8221;' . $usr_msg, 'wf_customer_import_export'), $cust_id), true);
                    unset($post);
                    return;
                   
                }elseif ($cust_id_existance_chk) {
                    $usr_msg = 'User with the same ID already exists';
                    $user_info = get_userdata($cust_id);
                    $user_string = sprintf('<a href="%s">%s</a>', get_edit_user_link($cust_id), $user_info->first_name);
                    $this->add_import_result('skipped', __($usr_msg, 'wf_customer_import_export'), $cust_id, $user_string, $cust_id);
                    if ($this->log)
                        $this->hf_log_data_change('user-csv-import', sprintf(__('> &#8220;%s&#8221;' . $usr_msg, 'wf_customer_import_export'), $cust_id), true);
                    unset($post);
                    return;
                    
                }
                       
            }
            $user_id = $this->hf_create_customer($post, $this->send_mail);
            $new_added = true;
            if (is_wp_error($user_id)) {
                $this->errored++;
                $this->add_import_result('failed', __($user_id->get_error_message(), 'wf_customer_import_export'), 0, 'failed', 1);
                if ($this->log)
                    $this->hf_log_data_change('user-csv-import', sprintf(__('> Error inserting %s: %s', 'wf_customer_import_export'), 1, $user_id->get_error_message()), true);
                $skipped++;
                unset($post);
                return;
            } elseif (empty($user_id)) {
                $this->errored++;
                if ($this->log)
                    $this->hf_log_data_change('user-csv-import', sprintf(__('An error occurred with the customer information provided.', 'wf_customer_import_export')));
                $this->add_import_result('skipped', __('An error occurred with the customer information provided.', 'wf_customer_import_export'), 0, 'failed', 1);
                $skipped++;
                unset($post);
                return;
            }
        }

        if ($merging && !$new_added)
            $out_msg = 'User updated successfully.';
        else
            $out_msg = 'User imported successfully';



        if (apply_filters('wt_import_processed_userid_save_flag', false)) {
            $this->save_processed_user_id_in_db((int) $user_id);
        }

        $user_info = get_userdata($user_id);
        $user_string = sprintf('<a href="%s">%s</a>', get_edit_user_link($user_id), $user_info->first_name);
        $this->add_import_result('imported', __($out_msg, 'wf_customer_import_export'), $user_id, $user_string, $user_id);
        if ($this->log)
            $this->hf_log_data_change('user-csv-import', sprintf(__('> &#8220;%s&#8221;' . $out_msg, 'wf_customer_import_export'), $user_id), true);
        $this->imported++;
        if ($this->log) {
            $this->hf_log_data_change('user-csv-import', sprintf(__('> Finished importing user %s', 'wf_customer_import_export'), $dry_run ? "" : $user_id ));
        }
        do_action('wt_customer_csv_import_data', $parsed_item, $user_id);
        unset($post);
    }

    public function hf_check_customer($data) {
        $customer_email = (!empty($data['user_details']['user_email']) ) ? $data['user_details']['user_email'] : '';
//        $username = (!empty($data['user_details']['user_login']) ) ? $data['user_details']['user_login'] : '';
//        $customer_id = (!empty($data['user_details']['customer_id']) ) ? $data['user_details']['customer_id'] : '';
        $found_customer = false;
        if (!empty($customer_email)) {
            if (is_email($customer_email) && false !== email_exists($customer_email)) {
                $found_customer = email_exists($customer_email);
            }
//            elseif (!empty($username) && false !== username_exists($username)) {
//                $found_customer = username_exists($username);
//            }
        }
        return $found_customer;
    }

    public function hf_create_customer($data, $email_customer) {
        $customer_email = (!empty($data['user_details']['user_email']) ) ? $data['user_details']['user_email'] : '';
        $username = (!empty($data['user_details']['user_login']) ) ? $data['user_details']['user_login'] : '';
        $customer_id = (!empty($data['user_details']['customer_id']) ) ? $data['user_details']['customer_id'] : '';
        $insertion_id = (!empty($data['user_details']['ID']) ) ? $data['user_details']['ID'] : '';
        $insert_with_id = (!empty($_GET['insert_with_id'])) ? 1 : 0;
        $use_same_password = (!empty($_GET['use_same_password']) && $_GET['use_same_password']) ? 1 : 0;
               
        if (!empty($data['user_details']['user_pass'])) {
//            $password = (strlen($data['user_details']['user_pass']) == 34 ) ? $data['user_details']['user_pass'] : wp_hash_password($data['user_details']['user_pass']);
            $password = ($use_same_password) ? $data['user_details']['user_pass'] : wp_hash_password($data['user_details']['user_pass']);
            $password_generated = false;
        } else {
            $password = wp_generate_password(12, true);
            $password_generated = true;
        }
        $found_customer = false;
        $create_user_without_email = apply_filters('wt_create_user_without_email', FALSE);   // create user without email address
        if (is_email($customer_email) || $create_user_without_email === TRUE) {
            $maybe_username = $username;
            // Not in test mode, create a user account for this email
            if (empty($username)) {
                $maybe_username = explode('@', $customer_email);
                $maybe_username = sanitize_user($maybe_username[0]);
            }
            $counter = 1;
            $username = $maybe_username;
            while (username_exists($username)) {
                $username = $maybe_username . $counter;
                $counter++;
            }
            if ($insert_with_id == 1) {
                global $wpdb;
                $id_insertion = true;
                if ($insertion_id != '') {
                    $insertion_id = (int) $insertion_id;
                    $username = sanitize_user($username);
                    $customer_email = sanitize_email($customer_email);
                    $password = wp_hash_password($password);
                    $result = $wpdb->insert($wpdb->users, array('ID' => $insertion_id, 'user_login' => $username, 'user_email' => $customer_email, 'user_pass' => $password));
                    if ($result) {
                        $found_customer = $insertion_id;
                    }
                }
            } else {
                $found_customer = wp_create_user($username, $password, $customer_email);
            }
            $user_data = array('ID' => $found_customer, 'user_login' => $username, 'user_email' => $customer_email);
            if (!$password_generated) {
                $user_data['user_pass'] = $password;
            }

            wp_insert_user($user_data);
            if (!is_wp_error($found_customer)) {
                $wp_user_object = new WP_User($found_customer);
                 if ( ! function_exists( 'get_editable_roles' ) ) {
                    require_once ABSPATH . 'wp-admin/includes/user.php';
                }
                $roles = get_editable_roles();
                $new_roles_str = str_replace(' ', '', $data['user_details']['roles']);
                $new_roles = explode(',', $new_roles_str);
                $new_roles = array_intersect($new_roles, array_keys($roles));
                $roles_to_remove = array();
                $user_roles = array_intersect(array_values($wp_user_object->roles), array_keys($roles));
                if (!$new_roles) {
                    // If there are no roles, delete all of the user's roles
                    $roles_to_remove = $user_roles;
                } else {
                    $roles_to_remove = array_diff($user_roles, $new_roles);
                }
                if (!empty($new_roles)) {
                    foreach ($roles_to_remove as $_role) {
                        $wp_user_object->remove_role($_role);   //remove the default role before adding new roles
                    }
                    // Make sure that we don't call $wp_user_object->add_role() any more than it's necessary
                    $_new_roles = array_diff($new_roles, array_intersect(array_values($wp_user_object->roles), array_keys($roles)));
                    foreach ($_new_roles as $_role) {
                        $wp_user_object->add_role($_role);
                    }
                }
                $meta_array = array();
                foreach ($data['user_meta'] as $meta) {
                    $meta_array[$meta['key']] = $meta['value'];
                }

                $user_nicename = (!empty($data['user_details']['user_nicename'])) ? $data['user_details']['user_nicename'] : '';
                $website = (!empty($data['user_details']['user_url'])) ? $data['user_details']['user_url'] : '';
                $user_registered = (!empty($data['user_details']['user_registered'])) ? $data['user_details']['user_registered'] : '';
                $display_name = (!empty($data['user_details']['display_name'])) ? $data['user_details']['display_name'] : '';
                $first_name = (!empty($data['user_details']['first_name'])) ? $data['user_details']['first_name'] : '';
                $last_name = (!empty($data['user_details']['last_name'])) ? $data['user_details']['last_name'] : '';
                $user_status = (!empty($data['user_details']['user_status'])) ? $data['user_details']['user_status'] : '';
                wp_update_user(array(
                    'ID' => $found_customer,
                    'user_nicename' => $user_nicename,
                    'user_url' => $website,
                    'user_registered' => $user_registered,
                    'display_name' => $display_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'user_status' => $user_status,
                        )
                );

                //unset($this->user_meta_fields['role']);
                // update user meta data
                foreach ($this->user_meta_fields as $key => $meta) {
                    if (($key == 'wp_capabilities') || (in_array($key, $this->user_base_fields))) {
                        continue;
                    }
                    $key = trim(str_replace('meta:', '', $key));
//                    $meta = trim(str_replace('meta:', '', $meta));
                    $meta_value = (!empty($meta_array[$key]) ) ? maybe_unserialize($meta_array[$key]) : '';
                    update_user_meta($found_customer, $key, $meta_value);
                }

                // $this->hf_make_user_active($found_customer);
                // send user registration email if admin as chosen to do so
                if ($email_customer && function_exists('wp_new_user_notification')) {
                    $blog_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                    $to = $customer_email;
                    $subject = "Your " . $blog_name . " account has been created!";
//                    if ((strlen($password) == 34 && strlen($data['user_details']['user_pass']) == 34)) {

                    if (strlen($password) == 34 && $use_same_password) {
                                                
                        $body = "Hi $first_name,

Thanks for creating an account on " . $blog_name . ". Your username is $username. You can access your account area to view orders, change your password.

We look forward to seeing you soon.

" . $blog_name;
                    } elseif (!empty($data['user_details']['user_pass']) && !$use_same_password) {
                        $new_password = $data['user_details']['user_pass'];
                        $body = "Hi $first_name,

Thanks for creating an account on " . $blog_name . ". Your username is $username. You can access your account area to view orders, change your password.

Your password has been generated: $new_password

We look forward to seeing you soon.

" . $blog_name;
                    } else {
                        $body = "Hi $first_name,

Thanks for creating an account on " . $blog_name . ". Your username is $username. You can access your account area to view orders, change your password.

Your password has been generated: $password

We look forward to seeing you soon.

" . $blog_name;
                    }
                    $headers = '';
                    //$headers[] = 'From: ' . $blog_name;
                    $mail_attrs['to'] = $to;
                    $mail_attrs['subject'] = $subject;
                    $mail_attrs['body'] = $body;
                    $mail_attrs['headers'] = $headers;
                    $mail_attrs['password'] = (isset($new_password)) ? $new_password : $password;
                    $mail_attrs['user_current_roles'] = $user_roles;
                    $mail_attrs['user_new_roles'] = $new_roles;
                    $mail_attrs['user_id'] = $found_customer;
                    $mail_attrs['mail_already_sent'] = FALSE;
                    $mail_template = get_option('wt_' . WT_CUSTOMER_IMP_EXP_ID . '_mail_option', null);
                    if($mail_template['enable_email_templates'] == 1){
                        $fetch_user = get_user_by( 'email', $mail_attrs['to'] );
                        $mail_attrs['headers'] ='Content-Type: text/html; charset=UTF-8';
                        $mail_attrs['subject'] = $mail_template['subject_mail'];
                        $blog_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                        $mail_body = $mail_template['body_mail'];
			$mail_body = str_replace( "###EMAIL###", $mail_attrs['to'], $mail_body );
                        $mail_body = str_replace( "###USERNAME###", $fetch_user->user_login, $mail_body );
			$mail_body = str_replace( "###DISPLAYNAME###", $fetch_user->display_name , $mail_body );
//                        $mail_body = str_replace( "###NICENAME###", $fetch_user->user_nicename , $mail_body );
                        $mail_body = str_replace( "###PASSWORD###", $mail_attrs['password'] , $mail_body );
                        $mail_body = str_replace('###SITENAME###', $blog_name, $mail_body);
                        $mail_body = str_replace('###SITEURL###', home_url(), $mail_body);
                        $mail_body = str_replace('###LOGINURL###', wp_login_url(), $mail_body );
			$mail_body = str_replace("###LOSTPASSWORDURL###", wp_lostpassword_url(), $mail_body );
                        $mail_attrs['body'] = $mail_body;
                    }
                    $mail_attrs = apply_filters('wt_user_registration_email', $mail_attrs); //this filter can use for alter mail as well as send mail with other third party plugins

                    if (!isset($mail_attrs['mail_already_sent']) || $mail_attrs['mail_already_sent'] == FALSE) {// this parameter used for determine whether the email already sent or not by any Custom mail
                        wp_mail($mail_attrs['to'], $mail_attrs['subject'], $mail_attrs['body'], $mail_attrs['headers']);
                    }
//                        $previous_option = get_option('woocommerce_registration_generate_password');
                    // force the option value so that the password will appear in the email
//                        update_option('woocommerce_registration_generate_password', 'yes');
//                        do_action('woocommerce_created_customer', $found_customer, array('user_pass' => $password), true);
//                        update_option('woocommerce_registration_generate_password', $previous_option);
                }
                
            }
        } else {
            $found_customer = new WP_Error('hf_invalid_customer', sprintf(__('User could not be created without Email.', 'wf_customer_import_export'), $customer_id));
        }
        return apply_filters('xa_user_impexp_alter_user_meta', $found_customer, $this->user_meta_fields, $meta_array);
    }

    public function hf_update_customer($found_customer, $data, $email_customer) {
        $customer_email = (!empty($data['user_details']['user_email']) ) ? $data['user_details']['user_email'] : '';
        $meta_array = array();
        if (!empty($customer_email)) {
            if ($found_customer) {
                $wp_user_object = new WP_User($found_customer);
                $roles = get_editable_roles();
                $new_roles_str = str_replace(' ', '', $data['user_details']['roles']);
                $new_roles = explode(',', $new_roles_str);
                $new_roles = array_intersect($new_roles, array_keys($roles));
                $roles_to_remove = array();
                $user_roles = array_intersect(array_values($wp_user_object->roles), array_keys($roles));
                if (!$new_roles) {
                    // If there are no roles, delete all of the user's roles
                    $roles_to_remove = $user_roles;
                } else {
                    $roles_to_remove = array_diff($user_roles, $new_roles);
                }
                if (!empty($new_roles)) {
                    foreach ($roles_to_remove as $_role) {
                        $wp_user_object->remove_role($_role);   //remove the default role before adding new roles
                    }
                    // Make sure that we don't call $wp_user_object->add_role() any more than it's necessary
                    $_new_roles = array_diff($new_roles, array_intersect(array_values($wp_user_object->roles), array_keys($roles)));
                    foreach ($_new_roles as $_role) {
                        $wp_user_object->add_role($_role);
                    }
                }

                foreach ($data['user_meta'] as $meta) {
                    $meta_array[$meta['key']] = $meta['value'];
                }
                // update user meta data
                foreach ($this->user_meta_fields as $key => $meta) {
                    if (($key == 'wp_capabilities') || (in_array($key, $this->user_base_fields))) {
                        continue;
                    }
                    $key = trim(str_replace('meta:', '', $key));
//                    $meta = trim(str_replace('meta:', '', $meta));
                    $meta_value = (!empty($meta_array[$key]) ) ? maybe_unserialize($meta_array[$key]) : '';
                    update_user_meta($found_customer, $key, $meta_value);
                }

                $user_data = array(
                    'ID' => $found_customer
                );
                if (isset($data['user_details']['user_nicename'])) {
                    $user_data['user_nicename'] = $data['user_details']['user_nicename'];
                }

                //added when implement merge with user id use for update email
                if (isset($data['user_details']['user_email'])) {
                    if ($wp_user_object->user_email != $data['user_details']['user_email']) {
                        $email_updated = true;
                    }
                    $user_data['user_email'] = $data['user_details']['user_email'];
                }
                if (isset($data['user_details']['user_url'])) {
                    $user_data['user_url'] = $data['user_details']['user_url'];
                }
                if (isset($data['user_details']['user_registered'])) {
                    $user_data['user_registered'] = $data['user_details']['user_registered'];
                }
                if (isset($data['user_details']['user_pass'])) {
                    $user_data['user_pass'] = $data['user_details']['user_pass'];
                }
                if (isset($data['user_details']['display_name'])) {
                    $user_data['display_name'] = $data['user_details']['display_name'];
                }
                if (isset($data['user_details']['first_name'])) {
                    $user_data['first_name'] = $data['user_details']['first_name'];
                }
                if (isset($data['user_details']['last_name'])) {
                    $user_data['last_name'] = $data['user_details']['last_name'];
                }
                if (isset($data['user_details']['user_status'])) {
                    $user_data['user_status'] = $data['user_details']['user_status'];
                }
                add_filter('send_password_change_email', '__return_false'); // for preventing sending password change notification mail on by wp_update_user.
                if (sizeof($user_data) > 1) {
                    $chk = wp_update_user($user_data);
                }
                // send user registration email if admin as chosen to do so
                if ($email_customer && function_exists('wp_new_user_notification') && isset($user_data['user_pass'])) {
                    //added when implement merge with user id use to get to email id
                    $mail_sent_email = ( $email_updated ) ? $customer_email : $wp_user_object->user_email;
                    unset($email_updated);
                    $blog_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                    /* translators: Do not translate USERNAME, ADMIN_EMAIL, EMAIL, SITENAME, SITEURL: those are placeholders. */
                    $pass_change_text = __('Hi ###USERNAME###,

                This notice confirms that your password was changed on ###SITENAME### to ###PASSWORD###.


                This email has been sent to ###EMAIL###

                Regards,
                All at ###SITENAME###
                ###SITEURL###');
                    $mail_attrs = array(
                        'to' => $mail_sent_email,
                        /* translators: User password change notification email subject. 1: Site name */
                        'subject' => __('[%s] Notice of Password Change'),
                        'message' => $pass_change_text,
                        'headers' => '',
                    );
                    $mail_attrs['message'] = str_replace('###USERNAME###', $wp_user_object->user_login, $mail_attrs['message']);
                    $mail_attrs['message'] = str_replace('###EMAIL###', $wp_user_object->user_email, $mail_attrs['message']);
                    $mail_attrs['message'] = str_replace('###SITENAME###', $blog_name, $mail_attrs['message']);
                    $mail_attrs['message'] = str_replace('###SITEURL###', home_url(), $mail_attrs['message']);
                    $mail_attrs['message'] = str_replace('###PASSWORD###', $user_data['user_pass'], $mail_attrs['message']);
                    $mail_attrs['user_current_roles'] = $user_roles;
                    $mail_attrs['user_new_roles'] = $new_roles;
                    $mail_attrs['user_id'] = $found_customer;
                    $mail_attrs['password'] = $user_data['user_pass'];
                    $mail_attrs['mail_already_sent'] = FALSE;
                    $mail_template = get_option('wt_' . WT_CUSTOMER_IMP_EXP_ID . '_mail_option', null);
                    if($mail_template['enable_update_mail_template'] == 1){
                        $mail_attrs['headers'] ='Content-Type: text/html; charset=UTF-8';
                        $mail_attrs['subject'] = $mail_template['subject_mail_update'];
                        $mail_body_update = $mail_template['body_mail_update'];
                        $mail_body_update = str_replace( "###EMAIL###", $wp_user_object->user_email, $mail_body_update );
                        $mail_body_update = str_replace( "###USERNAME###", $wp_user_object->user_login, $mail_body_update );
			$mail_body_update = str_replace( "###DISPLAYNAME###", $wp_user_object->display_name , $mail_body_update );
//                        $mail_body = str_replace( "###NICENAME###", $fetch_user->user_nicename , $mail_body_update );
                        $mail_body_update = str_replace( "###PASSWORD###", $mail_attrs['password'] , $mail_body_update );
                        $mail_body_update = str_replace('###SITENAME###', $blog_name, $mail_body_update);
                        $mail_body_update = str_replace('###SITEURL###', home_url(), $mail_body_update);
                        $mail_body_update = str_replace('###LOGINURL###', wp_login_url(), $mail_body_update );
			$mail_body_update = str_replace("###LOSTPASSWORDURL###", wp_lostpassword_url(), $mail_body_update );
                        
                        $mail_attrs['message'] = $mail_body_update;
                    }
                    $mail_attrs = apply_filters('wt_user_password_change_email', $mail_attrs); // this filter can use for alter mail as well as send mail with other third party plugins
                    if (!isset($mail_attrs['mail_already_sent']) || $mail_attrs['mail_already_sent'] == FALSE) { // this parameter used for determine whether the email already sent or not by any Custom mail
                        wp_mail($mail_attrs['to'], sprintf($mail_attrs['subject'], $blog_name), $mail_attrs['message'], $mail_attrs['headers']);
                    }
//                    $previous_option = get_option('woocommerce_registration_generate_password');
                    // force the option value so that the password will appear in the email
//                    update_option('woocommerce_registration_generate_password', 'yes');
//                    do_action('woocommerce_created_customer', $found_customer, array('user_pass' => $password), true);
//                    update_option('woocommerce_registration_generate_password', $previous_option);
                }
            } else {
                $found_customer = new WP_Error('hf_invalid_customer', sprintf(__('User could not be found with given Email or username.', 'wf_customer_import_export'), $customer_email));
            }
        } else {
            //$found_customer = new WP_Error('hf_invalid_customer', sprintf(__('User could not be found with given Email.', 'wf_customer_import_export'), $customer_email));
        }
        return apply_filters('xa_user_impexp_alter_user_meta', $found_customer, $this->user_meta_fields, $meta_array);
    }

    /**
     * Log a row's import status
     */
    protected function add_import_result($status, $reason, $post_id = '', $post_title = '', $user_id = '') {
        $this->import_results[] = array(
            'post_title' => $post_title,
            'post_id' => $post_id,
            'user_id' => $user_id,
            'status' => $status,
            'reason' => $reason
        );
    }

    /**
     * Decide what the maximum file size for downloaded attachments is.
     * Default is 0 (unlimited), can be filtered via import_attachment_size_limit
     *
     * @return int Maximum attachment file size to import
     */
    public function max_attachment_size() {
        return apply_filters('import_attachment_size_limit', 0);
    }

    //handle FTP section
    private function handle_ftp() {
        $usr_enable_ftp_ie = !empty($_POST['method']) ? $_POST['method'] : '';
        if ($usr_enable_ftp_ie != 'ftp')
            return false;

        $ftp_server = !empty($_POST['ftp_server']) ? $_POST['ftp_server'] : '';
        $ftp_server_path = !empty($_POST['ftp_server_path']) ? $_POST['ftp_server_path'] : '';
        $ftp_user = !empty($_POST['ftp_user']) ? $_POST['ftp_user'] : '';
        $ftp_password = !empty($_POST['ftp_password']) ? $_POST['ftp_password'] : '';
        $ftp_port = !empty($_POST['ftp_port']) ? $_POST['ftp_port'] : 21;
        $use_ftps = !empty($_POST['use_ftps']) ? true : false;
        $use_pasv = !empty($_POST['use_pasv']) ? true : false;
        $is_sftp  = !empty($_POST['is_sftp']) ? true : false;

        $wp_upload_dir = wp_upload_dir();
        $local_file = $wp_upload_dir['path'] . '/temp-import.csv';
        $server_file = $ftp_server_path;

        // if have SFTP Add-on for Import Export for WooCommerce 
        if (class_exists('class_wf_sftp_import_export') && $is_sftp === true) {
            $sftp_import = new class_wf_sftp_import_export();
            if (!$sftp_import->connect($ftp_server, $ftp_user, $ftp_password, $ftp_port)) {
                $error_message = "Not able to connect to the server please check <b>FTP Server Host / IP</b> and <b>Port number</b>. \n";
            }
            if (empty($server_file)) {
                $error_message = "Please Completely fill the FTP Details. \n";
            } else {
                $file_contents = $sftp_import->get_contents($server_file);
                if (!empty($file_contents)) {
                    file_put_contents($local_file, $file_contents);
                    $error_message = "";
                    $success = true;
                } else {
                    $error_message = "Failed to Download Specified file in FTP Server File Path.<br/><br/><b>Possible Reasons</b><br/><b>1.</b> File path may be invalid.<br/><b>2.</b> Maybe File / Folder Permission missing for specified file or folder in path.<br/><b>3.</b> Write permission may be missing for upload folder.\n";
                }
            }
        } else {

            $ftp_conn = $use_ftps ? @ftp_ssl_connect($ftp_server, $ftp_port) : @ftp_connect($ftp_server, $ftp_port);
            $error_message = "";
            $success = false;
            if ($ftp_conn == false) {
                $error_message = "<br /><b>Could not connect to the Server</b><br /><br />"
                        . "Possible reasons :<br />"
                        . "1. Server host name /IP (<b>$ftp_server</b>) may be wrong.<br />"
                        . "2. Port number (<b>$ftp_port</b>) may be wrong.<br />"
                        . "3. Maybe Timeout.";
            }

            if (empty($error_message)) {
                if (@ftp_login($ftp_conn, $ftp_user, $ftp_password) == false) {
                    $error_message = "<br /><b>Connected to the server but Could not login.</b><br /><br />"
                            . "Possible reasons : <br />"
                            . "1. FTP User name (<b>$ftp_user</b>) may be wrong.<br />"
                            . "2. FTP Password (<b>$ftp_password</b>) may be wrong.<br />"
                            . "3. If User name and Password both are correct then try with or without use FTPS option.";
                }
            }
            if (empty($error_message)) {
                if ($use_pasv)
                    ftp_pasv($ftp_conn, TRUE);
                if (@ftp_get($ftp_conn, $local_file, $server_file, FTP_BINARY)) {
                    $error_message = "";
                    $success = true;
                } else {
                    $server_file_permission = ftp_rawlist($ftp_conn, $server_file);
                    $server_file_permission = isset($server_file_permission[0]) ? $server_file_permission[0] : 'Failed to get Server file details';
                    $local_file_permission = decoct(@fileperms($local_file) & 0777);
                    $error_message = "<br /><br /><b>Something Went Wrong while getting the remote file into local</b><br /><br />"
                            . "1. Local File Permission : $local_file_permission ($local_file).<br />"
                            . "2. Server File Details : $server_file_permission ($server_file).<br>\n";
                }
            }

            if ($ftp_conn)
                ftp_close($ftp_conn);
        }

        if ($success) {
            $this->file_url = $local_file;
        } else {
            die($error_message);
        }
        return true;
    }

    // Display import page title
    public function header() {
        echo '<div><div class="icon32" id="icon-woocommerce-importer"><br></div>';
        $tab = 'expimp';
        include_once(dirname(__FILE__) . '/../views/html-wf-common-header.php');
        $section = !empty($_GET['section']) ? $_GET['section'] : "import";
        ?>
        <ul class="subsubsub" style="margin-left: 15px;">
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=quick') ?>" class="<?php if($section == "quick"){ echo "current"; } ?>"><?php _e('Quick Export', 'wf_customer_import_export'); ?></a> | </li>
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=export') ?>" class="<?php if($section == "export"){ echo "current"; } ?>"><?php _e('Export', 'wf_customer_import_export'); ?></a> | </li>
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=import') ?>" class="<?php if($section == "import"){ echo "current"; } ?>"><?php _e('Import', 'wf_customer_import_export'); ?></a></li>
        </ul><br/>
        <?php
    }

    // Close div.wrap
    public function footer() {
        echo '</div>';
    }

    /**
     * Display introductory text and file upload form
     */
    public function greet() {
        $action = 'admin.php?import=wordpress_hf_user_csv&amp;step=1&amp;merge=' . (!empty($_GET['merge']) ? 1 : 0 );
        $bytes = apply_filters('import_upload_size_limit', wp_max_upload_size());
        $size = size_format($bytes);
        $upload_dir = wp_upload_dir();
        $ftp_settings = get_option('hf_user_importer_ftp');
        include( 'views/html-wf-import-greeting.php' );
    }

    /**
     * Added to http_request_timeout filter to force timeout at 60 seconds during import
     * @return int 60
     */
    public function bump_request_timeout($val) {
        return 60;
    }

    public function wf_let_to_num($size) {
        $l = substr($size, -1);
        $ret = substr($size, 0, -1);
        switch (strtoupper($l)) {
            case 'P':
                $ret *= 1024;
            case 'T':
                $ret *= 1024;
            case 'G':
                $ret *= 1024;
            case 'M':
                $ret *= 1024;
            case 'K':
                $ret *= 1024;
        }
        return $ret;
    }

    /**
     * Function to save the user ids which are already processed.
     */
    public function save_processed_user_id_in_db($post_id = 0) {

        $processed_ids_in_db = get_option('wt_cust_csv_imp_exp_processed_user_ids'); // get saved product ids 
        if (!is_array($processed_ids_in_db) && empty($processed_ids_in_db)) {
            $processed_ids_in_db = array();
        }
        $processed_ids_in_db[] = $post_id;
        $processed_ids_in_db = array_unique($processed_ids_in_db);
        update_option('wt_cust_csv_imp_exp_processed_user_ids', $processed_ids_in_db); // append product ids to existign or new delete que           
        unset($processed_ids_in_db);
    }
}
