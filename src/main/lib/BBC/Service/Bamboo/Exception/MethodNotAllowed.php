<?php

/**
 * BBC_Service_Bamboo_Exception_MethodNotAllowed
 *
 * A class representing a 405 Method Not Allowed error
 *
 * Returned if you issue an unsupported HTTP method, e.g. POST on most URIs, OPTIONS,HEAD everywhere
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2012 BBC (http://www.bbc.co.uk)
 * @author Jak Spalding <jak.spalding@bbc.co.uk>
 */
class BBC_Service_Bamboo_Exception_MethodNotAllowed extends BBC_Service_Bamboo_Exception
{
    protected $_defaultCode = 405;
}