<?php

namespace Matthias\LeanpubApi;

use Matthias\LeanpubApi\Call\CreateCouponCall;
use Matthias\LeanpubApi\Call\ListAllSalesCall;
use Matthias\LeanpubApi\Client\ClientInterface;
use Matthias\LeanpubApi\Call\ListCouponsCall;
use Matthias\LeanpubApi\Dto\CouponCollection;
use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Dto\Purchase;

class LeanpubApi
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return CouponCollection
     */
    public function listCoupons($bookSlug)
    {
        return $this->client->callApi(new ListCouponsCall($bookSlug));
    }

    public function listIndividualPurchases($bookSlug, $page = 1)
    {
        return $this->client->callApi(new ListAllSalesCall($bookSlug, $page));
    }

    /**
     * @return Purchase[]
     */
    public function getAllIndividualPurchases($bookSlug)
    {
        return new \RecursiveIteratorIterator(new IndividualPurchasesIterator($this->client, $bookSlug));
    }

    public function createCoupon($bookSlug, CreateCoupon $coupon)
    {
        return $this->client->callApi(new CreateCouponCall($bookSlug, $coupon));
    }
}
