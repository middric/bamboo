<?php
/**
 * BBC_Service_Bamboo_ResponseArrayObject
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_ResponseArrayObject Extends ArrayObject
{

	/* @return if array is empty
	 */
	function isEmpty() 
	{
		if ($this->count() === 0 ) {
			return true;
		}
		return false;
	}
}