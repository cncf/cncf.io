<?php

namespace Wpai\Scheduling\Interval;

/**
 * Class ScheduleTime
 * @package Wpai\Scheduling\Interval
 */
class ScheduleTime
{
    /**
     * @var
     */
    private $times;

    /**
     * @var
     */
    private $monthly;
    /**
     * @var
     */
    private $timezone;

    /**
     * ScheduleTime constructor.
     * @param $times
     * @param $monthly
     * @param $timezone
     */
    public function __construct($times, $monthly, $timezone)
    {
        $this->times = $times;
        $this->monthly = $monthly;
        $this->timezone = $timezone;
    }

    /**
     * @return array
     */
    public function getTime()
    {
        $response = array();

        foreach ($this->times as $time) {
            $response[] = array(
                'day' => $time['day'],
                'hour' => $time['hour'],
                'min' => $time['min']
            );
        }

        return $response;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return mixed
     */
    public function isMonthly()
    {
        return $this->monthly;
    }
}