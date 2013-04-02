<?php

/**
 * BBC_Service_Bamboo_Monitoring_Counter
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 * @author Jak Spalding <jak.spalding@bbc.co.uk>
 */
class BBC_Service_Bamboo_Monitoring_Counter
{

    /**
     * counter names
     */
    const CACHE_MISS = 'BambooCacheMiss';

    /**
     * Provide Singleton access to a counter object
     *
     * @var BBC_Monitoring_Counter[]
     */
    private static $_instance = array();

    /**
     * Singleton access method
     *
     * @param string $counterName
     *
     * @return BBC_Monitoring_Counter
     */
    public static function getInstance($counterName) {
        if (!isset(self::$_instance[$counterName])) {
            $counter = BBC_Monitoring_Counter::factory($counterName);
            self::$_instance[$counterName] = $counter;
        }
        return self::$_instance[$counterName];
    }

    /**
     * Increment the specified counter
     *
     * @param string $counterName A class constant
     * @return bool
     */
    public static function increment($counterName) {
        BBC_Service_Bamboo_Log::info(__METHOD__ . "(" . json_encode($counterName) . ")");
        return self::getInstance($counterName)->increment();
    }
}