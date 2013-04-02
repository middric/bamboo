<?php

/**
 * BBC_Service_Bamboo_Flagpole
 *
 * Provides access to a platform flagpole
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 * @author Jak Spalding <jak.spalding@bbc.co.uk>
 */
abstract class BBC_Service_Bamboo_Flagpole
{
    /**
     * Should be overridden
     */
    const FLAGPOLE = null;

    protected static $_instance;

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            $className = get_called_class();
            self::$_instance = new $className();
        }
        return self::$_instance;
    }

    public function getStatus($throwException = false) {
        if (array_key_exists($this->getFlagpoleName(), $_SERVER)) {
            return mb_strtoupper($_SERVER[$this->getFlagpoleName()]);
        }
        if ($throwException) {
            throw new BBC_Service_Bamboo_Exception_FlagpoleNotFound(self::FLAGPOLE);
        }
        return false;
    }

    public function isGreen($throwException = false) {
        return ($this->getStatus($throwException) == "GREEN");
    }

    public function isOrange($throwException = false) {
        return ($this->getStatus($throwException) == "ORANGE");
    }

    public function isRed($throwException = false) {
        return ($this->getStatus($throwException) == "RED");
    }

    private function getFlagpoleName() {
        return 'HTTP_X_FLAGPOLE_' . self::FLAGPOLE;
    }
}