<?php

/**
 * BBC_Service_Bamboo_Cache
 *
 * @category BBC
 * @copyright BBC 2013
 * @package BBC_Service_Bamboo
 * @author Jak Spalding <jak.spalding@bbc.co.uk>
 */
class BBC_Service_Bamboo_Cache
{
    protected $_defaultLifetime = 300;
    protected $_cache = null;

    public function __construct($config, Zend_Cache_Core $cache = null) {
        if (!is_null($cache)) {
            $this->setCache($cache);
        }
        $this->setDefaultLifetime($config->lifetime);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($feedName, $params) {
        $key = $this->_createKey($feedName, $params);
        $data = $this->getCache()->load($key);
        if (!$data) {
            BBC_Service_Bamboo_Monitoring_Counter::increment(BBC_Service_Bamboo_Monitoring_Counter::CACHE_MISS);
            BBC_Service_Bamboo_Log::info("Cache miss: " . $key);
        } else {
            BBC_Service_Bamboo_Log::info("Cache hit: " . $key);
        }
        return $data;
    }

    /**
     * @param $feedName
     * @param $params
     * @param $contents
     * @param $lifetime
     * @internal param $key
     * @return boolean
     */
    public function save($feedName, $params, $contents, $lifetime = null) {
        $key = $this->_createKey($feedName, $params);
        BBC_Service_Bamboo_Log::info("Cache save: " . $key);
        $lifetime = ($lifetime == null ? $this->getDefaultLifetime() : $lifetime);
        return $this->getCache()->save($contents, $key, array(), $lifetime);
    }

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

    public function setDefaultLifetime($seconds) {
        $this->_defaultLifetime = $seconds;
    }

    public function getDefaultLifetime() {
        return $this->_defaultLifetime;
    }

    private function _createKey($feedName, $params) {
        $cacheKey = $feedName;
        foreach ($params as $key => $value) {
            $cacheKey .= $key . $value;
        }
        $cacheKey = preg_replace("/[^a-z0-9]/ui", "_", $cacheKey);
        return $cacheKey;
    }
}
