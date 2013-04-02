<?php

/**
 * BBC_Service_Bamboo_Exception
 *
 * A class representing a generic Bamboo exception
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author
 */
class BBC_Service_Bamboo_Exception extends BBC_Service_Exception
{
    protected $_defaultCode = 500;

    public function __construct($message, $code = null, $previous = null) {
        if ($code == null) {
            $code = $this->_defaultCode;
        }
        parent::__construct($message, $code, $previous);
    }
}