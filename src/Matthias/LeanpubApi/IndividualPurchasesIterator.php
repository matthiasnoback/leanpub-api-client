<?php

namespace Matthias\LeanpubApi;

use Matthias\LeanpubApi\Call\ListAllSalesCall;
use Matthias\LeanpubApi\Client\ClientInterface;
use Matthias\LeanpubApi\Dto\IndividualPurchases;

class IndividualPurchasesIterator implements \RecursiveIterator
{
    private $page;
    private $apiClient;
    private $bookSlug;

    /**
     * @var IndividualPurchases
     */
    private $purchaseItemsDto;

    public function __construct(ClientInterface $apiClient, $bookSlug)
    {
        $this->apiClient = $apiClient;
        $this->bookSlug = $bookSlug;
    }

    public function current()
    {
        return $this->page;
    }

    public function next()
    {
        $this->page++;
    }

    public function key()
    {
        return null;
    }

    public function valid()
    {
        $this->purchaseItemsDto = $this->apiClient->callApi(new ListAllSalesCall($this->bookSlug, $this->page));

        return count($this->purchaseItemsDto) > 0;
    }

    public function rewind()
    {
        $this->page = 1;
    }

    public function hasChildren()
    {
        return count($this->purchaseItemsDto) > 0;
    }

    public function getChildren()
    {
        return $this->purchaseItemsDto;
    }
}
