<?php

/**
 * BBC_Service_Bamboo_Log
 *
 * A class representing a logger
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author Luke Sands <luke.sands@bbc.co.uk>
 * @author Jak Spalding <jak.spalding@bbc.co.uk>
 */
class BBC_Service_Bamboo_Log
{

    /**
     * Default log level
     */
    const DEFAULT_LOG_LEVEL = Zend_Log::DEBUG;

    /**
     * @var Zend_Log
     */
    protected static $_logger = null;

    /**
     * Set the logger to use
     * @param Zend_Log $logger The logger instance to use
     */
    public static function setLogger(Zend_Log $logger) {
        self::$_logger = $logger;
    }

    /**
     * Return the instance of the logger currently used
     * @return Zend_Log Logger instance
     */
    public static function getLogger() {
        return self::$_logger;
    }

    /**
     * Combine function arguments to form a message, sprintf-style
     *
     * @param  array $args Arguments in the form of an array
     * @return string      The sprintf'd result
     */
    public static function _getMessage($args) {
        $var = array_shift($args);
        return vsprintf($var, $args);
    }

    /**
     * Log a given message with a given level
     */
    protected function _log($message, $level) {
        $logger = self::getLogger();
        if ($logger) {
            self::getLogger()->log($message, $level);
        }
    }

    /**
     * Log a given message, wrapping around sprintf
     * for readability
     */
    public static function log() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, self::DEFAULT_LOG_LEVEL);
    }

    /**
     * Send an emergency message
     */
    public static function emerg() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, Zend_Log::EMERG);
    }

    /**
     * Send an alert message
     */
    public static function alert() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, Zend_Log::ALERT);
    }

    /**
     * Send an critical message
     */
    public static function crit() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, Zend_Log::CRIT);
    }

    /**
     * Send an error message
     */
    public static function err() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, Zend_Log::ERR);
    }

    /**
     * Send an warning message
     */
    public static function warn() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, Zend_Log::WARN);
    }

    /**
     * Send an notice message
     */
    public static function notice() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, Zend_Log::NOTICE);
    }

    /**
     * Send an informational message
     */
    public static function info() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, Zend_Log::INFO);
    }

    /**
     * Send an debug message
     */
    public static function debug() {
        $message = self::_getMessage(func_get_args());
        self::_log($message, Zend_Log::DEBUG);
    }
}