<?php

namespace Matthias\LeanpubApi;

use Matthias\LeanpubApi\Call\CreateCouponCallFactory;
use Matthias\LeanpubApi\Call\ListAllSalesCallFactory;
use Matthias\LeanpubApi\Call\ListCouponsCallFactory;
use Matthias\LeanpubApi\Client\ClientInterface;
use Matthias\LeanpubApi\Serializer\CouponsDeserializer;
use Matthias\LeanpubApi\Serializer\CreateCouponSerializer;
use Matthias\LeanpubApi\Serializer\IndividualPurchasesDeserializer;
use Matthias\LeanpubApi\Validator\CreateCouponValidator;

class LeanpubApiFactory
{
    private $apiClient;

    public function __construct(ClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function create()
    {
        $createCouponCallFactory = new CreateCouponCallFactory(new CreateCouponValidator(), new CreateCouponSerializer());

        $listAllSalesCallFactory = new ListAllSalesCallFactory(new IndividualPurchasesDeserializer());

        $listCouponsCallFactory = new ListCouponsCallFactory(new CouponsDeserializer());

        return new LeanpubApi(
            $this->apiClient,
            $createCouponCallFactory,
            $listAllSalesCallFactory,
            $listCouponsCallFactory
        );
    }
}
