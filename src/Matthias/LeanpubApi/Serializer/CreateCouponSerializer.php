<?php

namespace Matthias\LeanpubApi\Serializer;

use Assert\Assertion;
use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Dto\DtoInterface;
use Matthias\LeanpubApi\Dto\PackageDiscount;

class CreateCouponSerializer implements DtoSerializerInterface
{
    /**
     * @param CreateCoupon $createCoupon
     * @return string
     */
    public function serialize(DtoInterface $createCoupon, $format)
    {
        Assertion::same($format, 'json');
        Assertion::isInstanceOf($createCoupon, 'Matthias\LeanpubApi\Dto\CreateCoupon');

        return json_encode(array(
            'coupon_code' => $createCoupon->getCouponCode(),
            'package_discounts_attributes' => array_map(array($this, 'serializePackageDiscount'), $createCoupon->getPackageDiscounts()),
            'start_date' => CouponDate::fromDateTime($createCoupon->getStartDate()),
            'end_date' => CouponDate::fromDateTime($createCoupon->getEndDate()),
            'max_uses' => $createCoupon->getMaxUses(),
            'note' => $createCoupon->getNote(),
            'suspended' => $createCoupon->isSuspended(),
        ));
    }

    private function serializePackageDiscount(PackageDiscount $packageDiscount)
    {
        return array(
            'package_slug' => $packageDiscount->getPackageSlug(),
            'discounted_price' => $packageDiscount->getDiscountedPrice()
        );
    }
}
