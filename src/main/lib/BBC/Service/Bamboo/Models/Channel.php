<?php
/**
 * BBC_Service_Bamboo_Models_Channel
 *
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Matthew Williams <matthew.williams@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Channel extends BBC_Service_Bamboo_Models_Base
{
    public function getUnregionalisedID() {
        if (preg_match('/(bbc_[a-z]+)(_.+)/i', $this->_id, $matches)) {
            return $matches[1];
        }

        return $this->_id;
    }

    /**
     * Returns whether this channel is a children's channel
     * @return bool
     */
    public function isChildrens() {
        return $this->_id == 'cbbc' || $this->_id == 'cbeebies';
    }
}
