<?php

namespace Matthias\LeanpubApi\Call;

use Matthias\LeanpubApi\Client\Exception\RequestFailedException;
use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Serializer\CreateCouponDtoSerializer;

class CreateCouponCall extends AbstractCall
{
    private $coupon;

    public function __construct($bookSlug, CreateCoupon $coupon)
    {
        $this->setBookSlug($bookSlug);
        $this->coupon = $coupon;
    }

    public function getMethod()
    {
        return 'POST';
    }

    public function getPath()
    {
        return sprintf('/%s/coupons.json', $this->bookSlug);
    }

    public function getHeaders()
    {
        return array('Content-Type' => 'application/json');
    }

    public function getBody()
    {
        $serializer = new CreateCouponDtoSerializer();

        return $serializer->serialize($this->coupon);
    }

    public function createResponseDto($responseBody)
    {
        $decodedResponse = json_decode($responseBody, true);

        if (!isset($decodedResponse['success']) || !$decodedResponse['success']) {
            throw new RequestFailedException(sprintf(
                'Expected successful response, got "%s"',
                $responseBody
            ));
        }

        return true;
    }
}
