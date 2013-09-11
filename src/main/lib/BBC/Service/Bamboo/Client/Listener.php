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
     * Log end time
     *
     * @param void
     * @access public
     * @return void
     */
    public function onExecutionEnd($request) {
        $handle = $request->getResource('curlHandle');
        $info = curl_getinfo($handle);
        $totalTime = $info['total_time'];
        $startTime = $info['starttransfer_time'];
        $total = $totalTime - $startTime;

        $this->_total = $total;
        $this->_uri = $request->getUri();

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
        //NOTE: Fix unit test and move lib/BBC/Tviplayer/Util.php into sharedlib
        //BBC_Tviplayer_Monitoring_StatsD::timing("ibl_feed.$this->_path", $this->_total);
        return;
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

}
