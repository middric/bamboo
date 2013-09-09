<?php 
/**
 * BBC_Service_Bamboo_Client_Listener
 *
 * Client Listener class for iBL
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author Craig Taub
 */
class BBC_Service_Bamboo_Client_Listener extends BBC_Http_Multi_Listener
{

    /**
     * @var Params for config
     */
    private $_params = array();

    /**
     * @var BBC_Service_Bamboo_Configuration
     */
    private $_configuration;

    /**
     * @var BBC_Service_Bamboo_Cache
     */
    private $_cache;

    /**
     * @var Start time 
     */
    private $_start;

    /**
     * @var End Time
     */    
    private $_end;

    /**
     * @var Total time string/float
     */
    private $_total;

    /**
     * @var uri string of request
     */
    private $_uri;

    /**
     * @var path of request
     */
    private $_path; 

    /**
     * Initialise cache for storing stats
     *
     * @param $params array 
     * @access public
     * @return void
     */
    public function __construct($path) {
        $this->_path = preg_replace('/\//', '-', $path);
        $this->_configuration = new BBC_Service_Bamboo_Configuration($this->_params);
        $this->_cache = new BBC_Service_Bamboo_Cache($this->_configuration->getConfiguration()->cache);
        return;
    }

    /**
     * Default BBC Listener to add HAR Data to Curl Multi requests
     * start a timer for this request 
     *
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function onExecutionStart() {
        $this->_start = $this->_microtimeFloat();  
        return;
    }

    /**
     * Default BBC Listener to add HAR Data to Curl Multi requests
     * Log end time 
     *
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function onExecutionEnd($request) {
        //$curl = $subject->getResource('curlHandle');
        //do something with the curl handle
        $this->_end = $this->_microtimeFloat();  
        return;
    }

    /**
     * Calculate total time for this request and log it.
     *
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function onDestroy($request) {
        $this->_total = $this->_end - $this->_start;
        $this->_uri = $request->getUri();

        //log data
        $this->_logInStatsd();
        //$this->_logInCache();
        return;
    }	

    /**
     * Function to write data to statsd.
     * It should display within 10 seconds.
     *
     * @param void 
     * @access private
     * @return void
     */
    private function _logInStatsd() {
        //Example:
        //BBC_Tviplayer_Monitoring_StatsD::timing("page_components.$this->_module.$this->_name", $total * 1000);
        //$this->_feedName is unsafe
        BBC_Tviplayer_Monitoring_StatsD::timing("ibl_feed.$this->_path", $this->_total);
        return;
    }

    /**
     * Caculate ibl feed name. If there is an easier way to do this please implement.
     *
     * @param void 
     * @access private
     * @return string $uri
     */
    private function _feedName() {
        $uri = preg_replace('/http:\/\/d.bbc.co.uk\/tviplayer\/v1\/stubs\//', '', $this->_uri);
        $uri = preg_replace('/\.json\?api_key=a9svsu3j2tgva4pchjtux93y&rights=web/', '', $uri);
        $uri = preg_replace('/\//', '-', $uri);

        return $uri;
    }
    /**
     * Log data into cache.
     * Could potentially do something with $response item.
     *
     * @param void 
     * @access private
     * @return void
     */
    private function _logInCache() {
        $response = $this->_cache->get($this->_uri, $this->_params);
        if (!$response) {
            $this->_cache->save($uri, $this->_params, $this->_total);
        } 
        return;
    }


    /**
     * Function to calculate microtime float
     *
     * @param void 
     * @access private
     * @return float
     */
    private function _microtimeFloat() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * Return total
     *
     * @param void 
     * @access public
     * @return float
     */
    public function getTotal() { 
        return $this->_total;
    }

}