<?php

/**
 * BBC_Service_Bamboo_Configuration
 *
 * A service class for iBL
 *
 * @category BBC
 * @package BBC_Service
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author Jak Spalding <jak.spalding@bbc.co.uk>
 */
class BBC_Service_Bamboo_Configuration
{

    /**
     * The service configuration
     *
     * @var stdClass $_configuration
     */
    protected $_configuration = null;

    public function __construct(array $params = array()) {
        // Load the internal configuration from our ini
        $defaultConfiguration = $this->_getDefaultConfiguration();
        // Create a Zend_Config from our parameters
        $runtimeParameters = new Zend_Config($params);
        // Merge the runtime parameters with the default parameters, runtime
        // parameters should take priority
        $configuration = $defaultConfiguration->merge($runtimeParameters);
        $this->setConfiguration($configuration);
    }

    /**
     * Sets the configuration
     *
     * @param stdClass $configuration
     */
    public function setConfiguration($configuration) {
        $this->_configuration = $configuration;
    }

    /**
     * Returns the configuration
     */
    public function getConfiguration() {
        if ($this->_configuration == null) {
            $this->setConfiguration($this->_getDefaultConfiguration());
        }
        return $this->_configuration;
    }

    /**
     * Returns the default configuration for Matchstick
     *
     * @return mixed
     */
    protected function _getDefaultConfiguration() {
        $configLoader = new BBC_Config_Loader_Ini(PAL_ENV);
        $configLoader->setCache(BBC_Service_Broker::getCache());
        $configLoader->loadModuleConfig('BBC/Service/Bamboo/conf/bamboo', false);
        return $configLoader->getConfig();
    }

}