<?php

/**
 * BBC_Service_Bamboo_Client_Fail
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2012 BBC (http://www.bbc.co.uk)
 * @author Rich Middleditch <richard.middleditch1@bbc.co.uk>
 */
class BBC_Service_Bamboo_Client_Fail
    extends BBC_Service_Bamboo_Client_HttpMulti
{

    /**
     *  @param array of string $keywords
     *
     */
    public function __construct(array $keywords) {
        $this->_keywords = $keywords;
    }

    /**
     * Throws an exception if a request URL has a substring which matches any of the stored keywords
     *
     * @param array $requests
     * @return array
     */
    public function get($path, array $params = array()) {

        foreach ($this->_keywords as $keyword) {
            if ($this->_matchesKeyword($keyword, $path)) {
                throw new BBC_Service_Matchstick_Exception_InternalServerError(
                    "[TEST] _fail query string match - failed on purpose."
                );
            }
        }
        $response = parent::get($path, $params);
        return $response;
    }

    private function _matchesKeyword($keyword, $requestUrl) {
        return (($keyword === "*") || (mb_strstr($requestUrl, $keyword) !== false));
    }