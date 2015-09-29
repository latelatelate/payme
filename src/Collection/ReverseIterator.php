<?php

namespace NM\Payme\Collection;

use NM\Payme\Collection\LineItems;

class ReverseIterator
{
    /**
     * @var ItemList
     */
    private $itemList;

    /**
     * @var int
     */
    protected $currentItem = 0;

    public function __construct(LineItems $itemList)
    {
        $this->itemList = $itemList;
        $this->currentItem = $this->itemList->count() - 1;
    }

    /**
     * Return the current item
     * @link http://php.net/manual/en/iterator.current.php
     * @return Item Can return any type.
     */
    public function current()
    {
        return $this->itemList->getItem($this->currentItem);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->currentItem--;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->currentItem;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *       Returns true on success or false on failure.
     */
    public function valid()
    {
        return null !== $this->itemList->getItem($this->currentItem);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->currentItem = $this->itemList->count() - 1;
    }
}