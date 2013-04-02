<?php

/**
 * BBC_Service_Bamboo_List
 *
 * An array of objects, with pagination properties
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author Jak Spalding <jak.spalding@bbc.co.uk>
 */
class BBC_Service_Bamboo_List
    implements Countable, ArrayAccess, Iterator
{

    /**
     * Factory method for creating an List
     * @param  int $page
     * @param  int $pageSize
     * @param  int $totalCount
     * @param  array $items
     * @return BBC_Service_Bamboo_List
     */
    public static function createList($page, $pageSize, $totalCount, array $items) {
        $instance = new self();
        $instance->setPage($page);
        $instance->setPageSize($pageSize);
        $instance->setTotalCount($totalCount);
        $instance->setItems($items);
        return $instance;
    }

    protected $_items = array();

    protected $_page = null;

    protected $_pageSize = null;

    protected $_totalCount = 0;

    protected $_iteratorPosition = 0;

    public function getPage() {
        return $this->_page;
    }

    public function getPageSize() {
        return $this->_pageSize;
    }

    public function getTotalCount() {
        return $this->_totalCount;
    }

    public function getItems() {
        return $this->_items;
    }

    public function setPage($page) {
        $this->_page = $page;
    }

    public function setPageSize($size) {
        $this->_pageSize = $size;
    }

    public function setTotalCount($count) {
        $this->_totalCount = $count;
    }

    public function setItems(array $entities) {
        foreach ($entities as $entity) {
            if (!$entity instanceof BBC_Service_Bamboo_Entity) {
                throw InvalidArgumentException('Must be of type BBC_Service_Bamboo_Entity');
            }
        }
        $this->_items = $entities;
    }

    /**
     * For the Countable interface, allows count(this object)
     * @return int count of items in list
     */
    public function count() {
        return count($this->_items);
    }

    /**
     * For the ArrayAccess interface
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset) {
        return isset($this->_items[$offset]);
    }

    /**
     * For the ArrayAccess interface
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return $this->_items[$offset];
    }

    /**
     * For the ArrayAccess interface
     * @param  [type] $offset [description]
     * @param  [type] $value  [description]
     * @return [type]         [description]
     */
    public function offsetSet($offset, $value) {
        if (!$value instanceof BBC_Service_Bamboo_Entity) {
            throw new InvalidArgumentException('Must be of type BBC_Service_Bamboo_Entity');
        }
        $this->_items[$offset] = $value;
    }

    /**
     * For the ArrayAccess interface
     * @param  mixed $offset
     */
    public function offsetUnset($offset) {
        unset($this->_items[$offset]);
    }

    /**
     * For the Iterator interface
     * Resets the iterator
     */
    public function rewind() {
        $this->_iteratorPosition = 0;
    }

    /**
     * For the Iterator interface
     * Returns the current item
     * @return var
     */
    public function current() {
        return $this->_items[$this->_iteratorPosition];
    }

    /**
     * For the Iterator interface
     * Returns the key for the current item
     * @return int
     */
    public function key() {
        return $this->_iteratorPosition;
    }

    /**
     * For the Iterator interface
     * Progresses the iterator to the next position
     */
    public function next() {
        ++$this->_iteratorPosition;
    }

    /**
     * For the Iterator interface
     * Returns whether the current iterator position reflects a valid property
     * @return boolean
     */
    public function valid() {
        return isset($this->_items[$this->_iteratorPosition]);
    }
}