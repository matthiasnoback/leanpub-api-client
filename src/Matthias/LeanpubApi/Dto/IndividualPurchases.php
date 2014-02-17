<?php

namespace Matthias\LeanpubApi\Dto;

class IndividualPurchases implements \RecursiveIterator, \Countable
{
    private $purchases = array();
    private $index;

    public function addPurchase(Purchase $purchase)
    {
        $this->purchases[] = $purchase;
    }

    public function getPurchases()
    {
        return $this->purchases;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->purchases);
    }

    public function count()
    {
        return count($this->purchases);
    }

    public function current()
    {
        return $this->purchases[$this->index];
    }

    public function next()
    {
        $this->index++;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return isset($this->purchases[$this->index]);
    }

    public function rewind()
    {
        $this->index = 0;
    }

    public function hasChildren()
    {
        return false;
    }

    public function getChildren()
    {

    }
}
