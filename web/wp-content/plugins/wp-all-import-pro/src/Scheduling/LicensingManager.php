<?php

namespace Wpai\Scheduling;

/**
 * Class LicensingManager
 * @package Wpai\Scheduling
 */
class LicensingManager
{
    /**
     * @var bool
     */
    private $options = false;

    /**
     * @param $licenseKey
     * @param $productName
     * @return bool
     */
    public function checkLicense($licenseKey, $productName)
    {

        if ($productName !== false) {
            // data to send in our API request
            $api_params = array(
                'edd_action' => 'activate_license',
                'license' => \PMXI_Plugin::decode($licenseKey),
                'item_name' => urlencode($productName) // the name of our product in EDD
            );

            // Call the custom API.
            $response = wp_remote_get(
                add_query_arg(
                    $api_params,
                    $this->getInfoApiUrl()
                ),
                array(
                    'timeout' => 15,
                    'sslverify' => false
                )
            );

            // make sure the response came back okay
            if (is_wp_error($response)){
                return false;
            }

            $responseData = \json_decode($response['body'], true);

            if(is_null($responseData)) {
                return false;
            } else {
                return $responseData['success'];
            }
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getLicense()
    {
        $options = $this->getOptions();
        return $options['license'];
    }

    /**
     * @return mixed
     */
    public function getInfoApiUrl()
    {
        $options = $this->getOptions();
        return $options['info_api_url'];
    }

    /**
     * @return bool|mixed
     */
    private function getOptions()
    {
        // Cache the options
        if(!$this->options) {
            $this->options = \PMXI_Plugin::getInstance()->getOption();
        }

        return $this->options;
    }
}