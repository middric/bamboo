<?php

/**
 * BBC_Service_Bamboo_Cache
 *
 * @copyright BBC 2013
 * @package BBC_Service_Bamboo
 * @author Jak Spalding <jak.spalding@bbc.co.uk>
 */
class BBC_Service_Bamboo_Cache
{
    protected $_cache = null;

    public function setCache(Zend_Cache_Core $cache) {
        $this->_cache = $cache;
    }

    public function getCache() {
        if ($this->_cache == null) {
            $cache = BBC_Webapp_Base::getInstance()->getContentCache();
            if ($cache) {
                $this->_cache = $cache;
            }
        }
        return $this->_cache;
    }
}