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
    protected $_paths = array();

    /**
     *  Accepted file types
     */
    protected $_types = array(
        "json" => "application/json",
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
            if ($this->_matchesKeyword($keyword, $path)) {
                if (count($this->_paths)) {
                    $response = $this->_getFakeResponseForRequest($path, $params);
                    $this->handleErrors($response);
                    return $response;
                } else {
                    throw new BBC_Service_Bamboo_Exception_NoFixturePathSet(
                        "No paths to bamboo fixtures have been set!"
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
    private function _getFakeResponseForRequest($path, $params) {

        $baseNames = array(
            // Add the whole URL as the first base name to look for.
            preg_replace("/\W+/", "_", $path)
        );

        foreach ($baseNames as $baseName) {
            foreach ($this->_paths as $fileLocation) {
                foreach ($this->_types as $extension => $type) {
                    $fileName = $fileLocation . '/' . $baseName . '.' . $extension;

                    if (file_exists($fileName)) {
                        $m = __CLASS__ . ": using the file [" . $fileName . "]";
                        $response = Zend_Http_Response::fromString(file_get_contents($fileName));
                        return $response;
                    }
                }
            }
        }

        $error = "Could not find these files for given URL - '". $path ."'\n";
        foreach ($baseNames as $baseName) {
            $error .= $baseName. ".json" . "\n";
        }
        $error .= "\nin these locations: \n";
        foreach ($this->_paths as $fileLocation) {
            $error .= $fileLocation . "\n";
        }

        throw new Exception($error, 1);
    }

    private function _matchesKeyword($keyword, $requestUrl) {
        return (($keyword === "*") || (mb_strstr($requestUrl, $keyword) !== false));
    }

}