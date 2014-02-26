<?php

namespace Matthias\LeanpubApi\Call;

use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Serializer\DtoSerializerInterface;
use Matthias\LeanpubApi\Validator\DtoValidatorInterface;

class CreateCouponCallFactory
{
    private $validator;
    private $serializer;

    public function __construct(DtoValidatorInterface $validator, DtoSerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @param string $bookSlug
     */
    public function create($bookSlug, CreateCoupon $createCoupon)
    {
        return new CreateCouponCall($this->validator, $this->serializer, $bookSlug, $createCoupon, 'json');
    }
}
