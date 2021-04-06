<?php

namespace Wpai\App\Controller;

use PMXI_Plugin;
use Wpai\App\Service\License\LicenseActivator;
use Wpai\Http\JsonResponse;
use Wpai\Scheduling\LicensingManager;

class SchedulingLicenseController
{
    /** @var  LicensingManager */
    private $licensingManager;

    /** @var LicenseActivator  */
    private $licensingActivator;

    private $slug = 'wp-all-import-pro';

    public function __construct()
    {
        $this->licensingManager = new LicensingManager();
        $this->licensingActivator = new LicenseActivator();
    }

    public function getSchedulingLicense()
    {
        $options = \PMXI_Plugin::getInstance()->getOption();

        if (empty($options['scheduling_license'])) {
            return false;
        }

        return new JsonResponse(
            array(
                'license' => $this->licensingManager->checkLicense($options['scheduling_license'], \PMXI_Plugin::getSchedulingName())
            )
        );
    }

    public function saveSchedulingLicenseAction()
    {
        $license = $_POST['license'];

        if($this->licensingManager->checkLicense($license, \PMXI_Plugin::getSchedulingName())){
            PMXI_Plugin::getInstance()->updateOption(array('scheduling_license' => $license));
            $post['license_status'] = $this->check_scheduling_license();
            $response = $this->activate_scheduling_licenses();

            return new JsonResponse(array('success' => true));
        } else {
            return new JsonResponse(array('success'=> false));
        }
    }

    /*
    *
    * Activate licenses for main plugin and all premium addons
    *
    */
    protected function activate_scheduling_licenses()
    {
        global $wpdb;

        delete_transient(PMXI_Plugin::$cache_key);

        $wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name = %s", $this->slug . '_' . PMXI_Plugin::$cache_key) );
        $wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name = %s", $this->slug . '_timeout_' . PMXI_Plugin::$cache_key) );

        delete_site_transient('update_plugins');

        // retrieve the license from the database
        return $this->licensingActivator->activateLicense(PMXI_Plugin::getSchedulingName(),\Wpai\App\Service\License\LicenseActivator::CONTEXT_SCHEDULING);
    }

    public function check_scheduling_license()
    {
        $options = PMXI_Plugin::getInstance()->getOption();

        global $wpdb;

        delete_transient(PMXI_Plugin::$cache_key);

        $wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name = %s", $this->slug . '_' . PMXI_Plugin::$cache_key) );
        $wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name = %s", $this->slug . '_timeout_' . PMXI_Plugin::$cache_key) );

        return $this->licensingActivator->checkLicense(PMXI_Plugin::getSchedulingName(), $options, LicenseActivator::CONTEXT_SCHEDULING);
    }
}