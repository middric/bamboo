<?php

/**
 * BBC_Service_Bamboo_Exception_NotFound
 *
 * A class representing an not found exception
 *
 * Occurs when the requested resource was not found or is not accessible to the user.
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2012 BBC (http://www.bbc.co.uk)
 * @author Luke Sands <luke.sands@bbc.co.uk>
 */
class BBC_Service_Bamboo_Exception_NotFound extends BBC_Service_Bamboo_Exception
{
    protected $_defaultCode = 404;
}