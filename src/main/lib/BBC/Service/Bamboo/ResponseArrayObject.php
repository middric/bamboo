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
class BBC_Service_Bamboo_ResponseArrayObject extends ArrayObject
{
    public function isEmpty() {
        return !$this->hasResults();
    }

    public function hasResults() {
        return $this->count() > 0;
    }

    public function getElementCount() {
        if (isset($this->count)) {
            return $this->count;
        }
        return 0;
    }

}
