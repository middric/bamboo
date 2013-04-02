<?php

/**
 * BBC_Service_Bamboo_Client
 *
 * Client class for iBL
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author Jak Spalding
 */
class BBC_Service_Bamboo_Client_HttpMulti
    implements BBC_Service_Bamboo_Client_Interface
{

    const SUFFIX = '.json';

    /**
     * @var Zend_Config
     */
    protected $_config;
    /**
     * The HTTP client to use (if any)
     * @var BBC_Http_Multi_Client
     */
    protected $_httpClient;

    /**
     * HTTP Headers for the request
     *
     * @var array
     */
    protected $_headers = array();

    /**
     * Status codes and their corresponding exceptions
     *
     * @var array
     */
    protected $_exceptions = array(
        400 => 'BadRequest',
        403 => 'Unauthorised',
        404 => 'NotFound',
        405 => 'MethodNotAllowed',
        406 => 'NotAcceptable',
        500 => 'InternalServerError'
    );

    /**
     * @param $config Zend_Config configuration for the client
     */
    public function __construct($config) {
        $this->_config = $config;
        $this->setHeader('User-Agent', $this->_config->useragent);
    }

    /**
     *
     * @param $path
     * @param array $params
     * @return array
     */
    public function get($path, array $params = array()) {
        $url = $this->_buildURL($path, $params);
        BBC_Service_Bamboo_Log::debug("Requesting $url");
        $options = array(
            'headers' => $this->getHeaders()
        );
        $response = null;
        $client = $this->getHttpClient();
        $self = $this;
        $client->get($url, $options)->then(
            function ($myResponse) use (&$response, &$self) {
                $self->_handleErrors($myResponse);
                $response = $myResponse;
            }
        )->end();
        $client->run();

        return $response;
    }

    private function _handleErrors($response) {
        // Handle the response if it represents an error
        if ($response->isError()) {
            // Set the status code based on the HTTP status code of the response
            $requestStatus = $response->getStatus();
            // Retrieve the custom error nitro provides
            $iblErrorMessage = $this->_getIblError($response);
            $errorMessage = sprintf(
                "Error Code %s: %s",
                $requestStatus,
                $iblErrorMessage
            );
            //
            // Iterate through our predetermined exceptions, and throw the one
            // that matches the response status code
            foreach ($this->_exceptions as $exceptionStatus => $exceptionName) {
                if ($requestStatus == $exceptionStatus) {
                    $exceptionName = 'BBC_Service_Bamboo_Exception_' . $exceptionName;
                    throw new $exceptionName($errorMessage);
                }
            }
            // If we get here, then it's not a predetermined exception, throw it any way
            throw new BBC_Service_Bamboo_Exception(
                sprintf('An unknown iBL error occurred: [%s]', $errorMessage),
                $requestStatus
            );
        } // end if ($rawResponse->isError())

        // Return the response
        return $response;
    }

    private function _getIblError($response) {
        $body = $response->getBody();
        if (!$body) {
            return "No body content";
        }
        $json = json_decode($body);
        if (!$json) {
            return "Unable to parse body content";
        }
        if (!is_null($json->ibl) && !is_null($json->ibl->error) && !is_null($json->ibl->error->details)) {
            if (!is_null($json->ibl->error->id)) {
                return sprintf("[%s] %s", $json->ibl->error->id, $json->ibl->error->details);
            }
            return $json->ibl->error->details;
        }
        return "Unable to retrieve error details.";
    }

    /**
     * Allow setting of the HTTP client, for testing purposes
     *
     * @param BBC_Http_Multi_Client $client
     */
    public function setHttpClient(BBC_Http_Multi_Client $client) {
        $this->_httpClient = $client;
    }

    /**
     * Returns a new http client, or one previously set by setHttpClient()
     *
     * @return BBC_Http_Multi_Client
     */
    public function getHttpClient() {
        // If a client has previously been set, return that.
        if (isset($this->_httpClient)) {
            return $this->_httpClient;
        }

        // Set the http multi client content cache property if required
        if ($this->_config->contentCaching == true) {
            BBC_Http_Multi_Client_Factory::setCache(
                BBC_Webapp_Base::getInstance()->getContentCache()
            );
        }
        // Create a new http multi client from the factory
        $httpClient = BBC_Http_Multi_Client_Factory::build();
        // Set the max execution time
        $httpClient->setExecutionTimeout(
            $this->_config->timeout
        );

        return $httpClient;
    }

    public function setHost($host) {
        $this->_host = $host;
    }

    public function setBaseURL($baseURL) {
        $this->_baseURL = $baseURL;
    }

    public function setHeader($name, $value) {
        $this->_headers[$name] = $value;
    }

    public function getHeaders() {
        return $this->_headers;
    }

    private function _buildURL($path, array $params) {
        $queryString = http_build_query($params);
        $url = $this->_host . $this->_baseURL . $path . self::SUFFIX . '?' . $queryString;
        if(!filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_PATH_REQUIRED | FILTER_FLAG_QUERY_REQUIRED)) {
            throw new BBC_Service_Bamboo_Exception_BadRequest("iBL URL is bad: $url");
        }
        return $url;
    }
}