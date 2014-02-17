<?php

namespace Matthias\LeanpubApi\Serializer;

use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Dto\PackageDiscount;

class CreateCouponDtoSerializer
{
    public function serialize(CreateCoupon $coupon)
    {
        return json_encode(array(
            'coupon_code' => $coupon->getCouponCode(),
            'package_discounts_attributes' => array_map(array($this, 'serializePackageDiscount'), $coupon->getPackageDiscounts()),
            'start_date' => CouponDate::fromDateTime($coupon->getStartDate()),
            'end_date' => CouponDate::fromDateTime($coupon->getEndDate()),
            'max_uses' => $coupon->getMaxUses(),
            'note' => $coupon->getNote(),
            'suspended' => $coupon->isSuspended(),
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
