<?php

namespace Wpai\Scheduling;

use Wpai\Scheduling\Exception\SchedulingHttpException;

/**
 * Class SchedulingApi
 * @package Wpai\Scheduling
 */
class SchedulingApi
{
    const TIMEOUT = 30;

    /**
     * @var
     */
    private $apiUrl;

    /**
     * SchedulingApi constructor.
     * @param $apiUrl
     */
    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return bool
     */
    public function checkConnection()
    {

        if(is_multisite()) {
            $url = get_site_url(get_current_blog_id());
        } else {
            $url = get_site_url('admin-ajax.php');
        }

        $pingBackUrl = $this->getApiUrl('connection').'?url='.urlencode($url);


        $response = wp_remote_request(
            $pingBackUrl,
            array(
                'method' => 'GET',
                'timeout' => self::TIMEOUT
            )
        );

        if($response instanceof \WP_Error) {
            return false;
        }

        if ($response['response']['code'] == 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $elementId
     * @param $elementType
     * @return array|bool|mixed|null|object
     */
    public function getSchedules($elementId, $elementType)
    {
        $response = wp_remote_request(

            $this->getApiUrl('schedules?forElement='.$elementId.
                '&type=' . $elementType.
                '&endpoint='.urlencode(get_site_url())),
            array(
                'method' => 'GET',
                'headers' => $this->getHeaders(),
                'timeout' => self::TIMEOUT
            )
        );

        if($response instanceof \WP_Error) {
            return false;
        }

        return json_decode($response['body']);
    }

    /**
     * @param $scheduleId
     */
    public function getSchedule($scheduleId)
    {
        wp_remote_request(

            $this->getApiUrl('schedules/' . $scheduleId),
            array(
                'method' => 'GET',
                'headers' => $this->getHeaders(),
                'timeout' => self::TIMEOUT
            )
        );
    }

    /**
     * @param $scheduleData
     * @return array|\WP_Error
     * @throws \Wpai\Scheduling\Exception\SchedulingHttpException
     */
    public function createSchedule($scheduleData)
    {

        $response = wp_remote_request(
            $this->getApiUrl('schedules'),
            array(
                'method' => 'PUT',
                'headers' => $this->getHeaders(),
                'body' => json_encode($scheduleData),
                'timeout' => self::TIMEOUT
            )
        );

        if($response instanceof \WP_Error) {
            throw new SchedulingHttpException('There was a problem saving the schedule');
        }

        return $response;
    }

    /**
     * @param $scheduleId
     */
    public function deleteSchedule($scheduleId)
    {
        wp_remote_request(
            $this->getApiUrl('schedules/' . $scheduleId),
            array(
                'method' => 'DELETE',
                'headers' => $this->getHeaders(),
                'timeout' => self::TIMEOUT
            )
        );
    }

    /**
     * @param $scheduleId
     * @param $scheduleTime
     * @return array|\WP_Error
     * @throws \Wpai\Scheduling\Exception\SchedulingHttpException
     */
    public function updateSchedule($scheduleId, $scheduleTime)
    {

        $response = wp_remote_request(
            $this->getApiUrl('schedules/' . $scheduleId),
            array(
                'method' => 'POST',
                'headers' => $this->getHeaders(),
                'body' => json_encode($scheduleTime),
                'timeout' => self::TIMEOUT
            ));

        if($response instanceof \WP_Error) {
            throw new SchedulingHttpException('There was a problem saving the schedule');
        }

        return $response;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getHeaders()
    {

        $options = \PMXI_Plugin::getInstance()->getOption();

        if (!empty($options['scheduling_license'])) {
            return array(
                'Authorization' => 'License ' . \PMXI_Plugin::decode($options['scheduling_license'])
            );
        } else {
            //TODO: Throw custom exception
            throw new \Exception('No license present');
        }
    }

    /**
     * @return string
     */
    private function getApiUrl($resource)
    {
        return $this->apiUrl . '/' . $resource;
    }
}