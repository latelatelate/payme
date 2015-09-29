<?php namespace NM\Payme\Collection;

use NM\Payme\Domain\Item;

class LineItems implements \Countable
{
    private $items;

    /**
     * Grab item from collection by ID
     * @param $itemNumberToGet
     * @return null
     */
    public function getItem($itemNumberToGet)
    {
        if (isset($this->items[$itemNumberToGet])) {
            return $this->items[$itemNumberToGet];
        }

        return null;
    }

    /**
     * Add item to collection
     * @param Item $item
     * @return int
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this->count();
    }

    /**
     * Remove Item from collection
     * @param Item $itemToRemove
     * @return int
     */
    public function removeItem(Item $itemToRemove)
    {
        foreach ($this->items as $key => $item) {
            /** @var Item $item */
            if ($item->getAuthorAndTitle() === $itemToRemove->getAuthorAndTitle()) {
                unset($this->items[$key]);
            }
        }

        return $this->count();
    }

    /**
     * Return count of collection
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

}