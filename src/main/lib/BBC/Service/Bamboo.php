<?php
/**
 * BBC_Service_Bamboo
 *
 * A service class for iBL
 *
 * @category BBC
 * @package BBC_Service
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author
 */

class BBC_Service_Bamboo implements BBC_Service_Interface
{
    /**
     * @var BBC_Service_Bamboo_Cache
     */
    protected $_cache;
    /**
     * @var BBC_Service_Bamboo_Configuration
     */
    protected $_configuration;
    /**
     * @var BBC_Service_Bamboo_Client
     */
    protected $_client;

    /**
     * Construct a new BBC_Service_Bamboo
     *
     * @param $text
     * @return void
     */
    public function __construct(array $params = array()) {
        $this->_configuration = new BBC_Service_Bamboo_Configuration($params);
        $this->_cache = new BBC_Service_Bamboo_Cache();
        $this->_client = new BBC_Service_Bamboo_Client($this->_configuration->getConfiguration()->httpmulti);
    }

    /**
     * Returns the name of the service
     *
     * @return string
     */
    public static function getName() {
        return 'bamboo';
    }

    /**
     * Returns the class version
     *
     * @return string
     */
    public static function getVersion() {
        return '0.0.1';
    }

    /**
     * Returns a NEW instance of the class
     * TODO: make singleton to reduce memory impact?
     * @param array $params  Parameters received from BBC_Service_Broker
     * @return BBC_Service_Bamboo
     */
    public static function getInstance(array $params = array()) {
        $calledClass = get_called_class();
        return new $calledClass($params);
    }

    public function getCategories(array $params = array()) {
        $response = $this->_client->get('categories', $params);
        $list = BBC_Service_Bamboo_Models_ListFactory::create($response);
        return $list;
        return 'http://open.test.bbc.co.uk/ibl/v1/stubs/categories';
    }
}
