<?php

namespace Matthias\LeanpubApi\Call;

use Assert\Assertion;
use Matthias\LeanpubApi\Client\Exception\RequestFailedException;
use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Serializer\DtoSerializerInterface;
use Matthias\LeanpubApi\Validator\DtoValidatorInterface;

class CreateCouponCall extends AbstractCall
{
    private $validator;
    private $serializer;
    private $coupon;
    protected $bookSlug;

    /**
     * @param string $bookSlug
     * @param string $format
     */
    public function __construct(
        DtoValidatorInterface $validator,
        DtoSerializerInterface $serializer,
        $bookSlug,
        CreateCoupon $coupon,
        $format
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->setBookSlug($bookSlug);
        $this->coupon = $coupon;
        $this->setFormat($format);
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
        $this->validator->validate($this->coupon);

        return $this->serializer->serialize($this->coupon, $this->format);
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
