<?php

/**
 * BBC_Service_Bamboo_Client_Fake
 *
 * Inserts fixture data in place of real requests
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2012 BBC (http://www.bbc.co.uk)
 * @author Rich Middleditch <richard.middleditch1@bbc.co.uk>
 */
class BBC_Service_Bamboo_Client_Fake
    extends BBC_Service_Bamboo_Client_HttpMulti
{
    /**
     *  Path on file system to fixtures
     */
    protected $_paths;

    /**
     *  Accepted file types
     */
    protected $_extension = 'json';

    /**
     * Default parameters we don't want in the fixture names
     */
    protected $_defaultParams = array(
        'per_page',
        'api_key',
        'rights',
        'availability',
        'lang',
        'sort',
        'sort_direction'
    );

    /**
     *  @param array of string $keywords
     *  @param array of string $paths
     */
    public function __construct($config, array $keywords, array $paths) {
        parent::__construct($config);
        $this->_keywords = $keywords;
        $this->_paths = $paths;
    }

    /**
     *  Creates and returns responses for given requests. If a request has as a substring
     *  any of the keywords set in this class then faked responses will attempt to be
     *  created and returned instead
     *
     *  @param array $requests
     *  @return array
     */
    public function get($path, array $params = array()) {
        foreach ($this->_keywords as $keyword) {
            if ($this->_matchesKeyword($keyword[0], $path)) {
                if (!empty($this->_paths[0])) {
                    $suffix = !empty($keyword[1]) ? "_{$keyword[1]}" : '';
                    $response = $this->_getFakeResponseForRequest($path, $params, $suffix);
                    $this->handleErrors($response);
                    return $response;
                } else {
                    throw new BBC_Service_Bamboo_Exception_NoFixturePathSet(
                        "No path to bamboo fixtures has been set!"
                    );
                }
            }
        }
        $response = parent::get($path, $params);
        return $response;
    }

    /**
     * Takes a request and returns a faked response containing fixture data
     */
    private function _getFakeResponseForRequest($path, $params, $suffix="") {

        $baseName = preg_replace("/\W+/", "_", $path.$suffix);

        // Remove default parameters from the query string
        foreach ($this->_defaultParams as $parameter) {
            if (array_key_exists($parameter, $params)) {
                unset($params[$parameter]);
            }
        }
        if (!empty($params)) {
            // build any key/values we have back into a HTTP query
            // Then lowercase & strip out any characters that might cause us headaches
            $queryString = '' .
                preg_replace('/\W+/', '_', mb_strtolower(http_build_query($params)));
        } else {
            $queryString = '';
        }

        $fileName = $this->_buildFilename($this->_paths[0], $baseName, $queryString, $this->_extension);

        if (file_exists($fileName)) {
            BBC_Service_Bamboo_Log::info(__CLASS__ . ": using the file [" . $fileName . "]");
            $response = Zend_Http_Response::fromString(file_get_contents($fileName));
            return $response;
        }

        $error = "\nCould not find fixture for feed - '". $path ."'\n\nExpected:\n";
        $error .= $fileName ."\n\n";

        throw new BBC_Service_Bamboo_Exception_FixtureNotFound($error, 1);
    }

    private function _matchesKeyword($keyword, $requestUrl) {
        return (($keyword === "*") || (mb_strstr($requestUrl, $keyword) !== false));
    }

    private function _buildFilename($location, $baseName, $queryString, $extension) {
        $fileName = $location . $baseName;
        if ($queryString) {
            $fileName .= "_$queryString";
        }
        $fileName .= ".$extension";
        return $fileName;
    }

}
