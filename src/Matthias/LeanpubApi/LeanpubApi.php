<?php

namespace Matthias\LeanpubApi;

use Matthias\LeanpubApi\Call\CreateCouponCallFactory;
use Matthias\LeanpubApi\Call\ListAllSalesCallFactory;
use Matthias\LeanpubApi\Client\ClientInterface;
use Matthias\LeanpubApi\Dto\Coupons;
use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Dto\IndividualPurchases;
use Matthias\LeanpubApi\Dto\Purchase;
use Matthias\LeanpubApi\Call\ListCouponsCallFactory;

class LeanpubApi
{
    private $client;
    private $createCouponCallFactory;
    private $listAllSalesCallFactory;
    private $listCouponsCallFactory;

    public function __construct(
        ClientInterface $client,
        CreateCouponCallFactory $createCouponCallFactory,
        ListAllSalesCallFactory $listAllSalesCallFactory,
        ListCouponsCallFactory $listCouponsCallFactory
    ) {
        $this->client = $client;
        $this->createCouponCallFactory = $createCouponCallFactory;
        $this->listAllSalesCallFactory = $listAllSalesCallFactory;
        $this->listCouponsCallFactory = $listCouponsCallFactory;
    }

    /**
     * @param string $bookSlug
     * @return Coupons
     */
    public function listCoupons($bookSlug)
    {
        return $this->client->callApi($this->listCouponsCallFactory->create($bookSlug, 'json'));
    }

    /**
     * @param string $bookSlug
     * @param integer $page
     * @return IndividualPurchases
     */
    public function listIndividualPurchases($bookSlug, $page = 1)
    {
        return $this->client->callApi($this->listAllSalesCallFactory->create($bookSlug, $page, 'json'));
    }

    /**
     * @param string $bookSlug
     * @return Purchase[]
     */
    public function listAllIndividualPurchases($bookSlug)
    {
        return new \RecursiveIteratorIterator(new IndividualPurchasesIterator($this->client, $this->listAllSalesCallFactory, $bookSlug));
    }

    /**
     * @param string $bookSlug
     * @return boolean
     */
    public function createCoupon($bookSlug, CreateCoupon $coupon)
    {
        return $this->client->callApi($this->createCouponCallFactory->create($bookSlug, $coupon));
    }
}
