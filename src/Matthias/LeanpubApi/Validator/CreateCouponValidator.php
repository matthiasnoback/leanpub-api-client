<?php

namespace Matthias\LeanpubApi\Validator;

use Assert\Assertion;
use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Dto\DtoInterface;
use Matthias\LeanpubApi\Validator\Exception\BadRequestException;

class CreateCouponValidator implements DtoValidatorInterface
{
    /**
     * @param CreateCoupon $createCoupon
     */
    public function validate(DtoInterface $createCoupon)
    {
        Assertion::isInstanceOf($createCoupon, 'Matthias\LeanpubApi\Dto\CreateCoupon');

        if (count($createCoupon->getPackageDiscounts()) === 0) {
            throw new BadRequestException('Coupon should have at least one package discount, one of which can be for the "book" package');
        }
    }
}
