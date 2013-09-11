<?php
/**
 * BBC_Service_Bamboo_Client_HttpMultiClient
 *
 * Http Multi Client intended for Bamboo, includes listener
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author Craig Taub
 */
class BBC_Service_Bamboo_Client_HttpMultiClient extends BBC_Http_Multi_Client
{
    /**
     * GET request to the supplied URL with Listener
     *
     * @param string $uri URL to GET request to
     * @param string $path name of the path
     * @param array $options to configure the request
     * @access public
     * @return BBC_Promise
     */
    public function getWithListener($uri, BBC_Service_Bamboo_Client_Listener $listener, $options = array()) {

    $clientRequest = BBC_Http_Multi_Client_Request_Factory::build(
        $uri,
        BBC_Http_Multi_Client_Request::METHOD_GET,
        $options
    );
    $clientRequest->addListener($listener);

    return $this->request($clientRequest);

    }


}