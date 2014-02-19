<?php

namespace Matthias\LeanpubApi;

use Matthias\LeanpubApi\Call\ListAllSalesCallFactory;
use Matthias\LeanpubApi\Client\ClientInterface;
use Matthias\LeanpubApi\Dto\IndividualPurchases;

class IndividualPurchasesIterator implements \RecursiveIterator
{
    private $apiClient;
    private $listAllSalesCallFactory;
    private $bookSlug;

    private $page;

    /**
     * @var IndividualPurchases
     */
    private $purchaseItemsDto;

    private $resultFetchedForPage;

    public function __construct(ClientInterface $apiClient, ListAllSalesCallFactory $listAllSalesCallFactory, $bookSlug)
    {
        $this->apiClient = $apiClient;
        $this->bookSlug = $bookSlug;
        $this->listAllSalesCallFactory = $listAllSalesCallFactory;
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
    }

    public function valid()
    {
        if ($this->resultFetchedForPage === null || $this->resultFetchedForPage < $this->current()) {
            $apiCall = $this->listAllSalesCallFactory->create($this->bookSlug, $this->current(), 'json');
            $this->purchaseItemsDto = $this->apiClient->callApi($apiCall);
            $this->resultFetchedForPage = $this->page;
        }

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
