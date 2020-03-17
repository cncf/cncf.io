<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class WF_CustomerImpExpCsv_Cron {

    public $settings;

    public function __construct() {
        add_filter('cron_schedules', array($this, 'wf_auto_export_schedule'));
        add_action('init', array($this, 'wf_new_scheduled_export_user'));
        add_action('hf_customer_im_ex_auto_export_user', array($this, 'wf_scheduled_export_user'));
        $this->settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
        $this->exports_enabled = FALSE;
        if (isset($this->settings['usr_auto_export']) && ($this->settings['usr_auto_export'] === TRUE))
            $this->exports_enabled = TRUE;
        }

    public function wf_auto_export_schedule($schedules) {

        if ($this->exports_enabled) {
            $export_interval = $this->settings['usr_auto_export_interval'];
            if ($export_interval) {
                $schedules['usr_export_interval'] = array(
                    'interval' => (int) $export_interval * 60,
                    'display' => sprintf(__('Every %d minutes', 'wf_customer_import_export'), (int) $export_interval)
                );
            }
        }
        return $schedules;
    }

    public function wf_new_scheduled_export_user() {

        if ($this->exports_enabled) {

            if (!wp_next_scheduled('hf_customer_im_ex_auto_export_user')) {
                $start_time = $this->settings['usr_auto_export_start_time'];
                $current_time = current_time('timestamp');                
                if ($start_time) {
                    if ($current_time > strtotime('today ' . $start_time,$current_time)) {
                        $start_timestamp = strtotime('tomorrow ' . $start_time, $current_time) - ( get_option('gmt_offset') * HOUR_IN_SECONDS );
                    } else {
                        $start_timestamp = strtotime('today ' . $start_time, $current_time) - ( get_option('gmt_offset') * HOUR_IN_SECONDS );
                    }
                } else {
                    $export_interval = $this->settings['usr_auto_export_interval'];
                    $start_timestamp = strtotime("now +{$export_interval} minutes");
                }
                wp_schedule_event($start_timestamp, 'usr_export_interval', 'hf_customer_im_ex_auto_export_user');
            }
        }
    }

    public function wf_scheduled_export_user() {
        if (isset($this->settings['usr_auto_export_user_roles'])) {
            $_POST['user_roles'] = $this->settings['usr_auto_export_user_roles'];
        }
        if (isset($this->settings['usr_auto_export_limit'])) {
            $_POST['limit'] = $this->settings['usr_auto_export_limit'];
        }
        if (isset($this->settings['usr_auto_export_offset'])) {
            $_POST['offset'] = $this->settings['usr_auto_export_offset'];
        }
        if (isset($this->settings['usr_auto_user_ids'])) {
            $_POST['user_ids'] = $this->settings['usr_auto_user_ids'];
        }
        if (isset($this->settings['usr_auto_export_start_date'])) {
            $_POST['start_date'] = $this->settings['usr_auto_export_start_date'];
        }
        if (isset($this->settings['usr_auto_export_end_date'])) {
            $_POST['end_date'] = $this->settings['usr_auto_export_end_date'];
        }
        if (isset($this->settings['usr_auto_delimiter'])) {
            $_POST['delimiter'] = $this->settings['usr_auto_delimiter'];
        }
          if (isset($this->settings['user_auto_export_profile']) && !empty($this->settings['user_auto_export_profile'])) {
            $_POST['user_auto_export_profile'] = $this->settings['user_auto_export_profile'];
        } else {
            $_POST['user_auto_export_profile'] = '';
        }
        include_once( 'exporter/class-wf-customerimpexpcsv-exporter.php' );
        WF_CustomerImpExpCsv_Exporter::do_export();
    }

    public function clear_wf_scheduled_export_user() {
        wp_clear_scheduled_hook('hf_customer_im_ex_auto_export_user');
    }

}