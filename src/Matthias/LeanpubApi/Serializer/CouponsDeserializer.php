<?php

namespace Matthias\LeanpubApi\Serializer;

use Assert\Assertion;
use Matthias\LeanpubApi\Dto\Coupon;
use Matthias\LeanpubApi\Dto\CouponCollection;
use Matthias\LeanpubApi\Dto\PackageDiscount;

class CouponsDeserializer implements DtoDeserializerInterface
{
    public function deserialize($rawData, $format)
    {
        Assertion::same('json', $format, 'No other format is supported');

        $coupons = json_decode($rawData, true);

        $dto = new CouponCollection();

        foreach ($coupons as $couponArray) {
            $dto->addCoupon($this->createCouponFromArray($couponArray));
        }

        return $dto;
    }

    private function createCouponFromArray(array $couponArray)
    {
        $coupon = new Coupon();

        $coupon->setCouponCode($couponArray['coupon_code']);
        $coupon->setCreatedAt(JsonDate::toDateTime($couponArray['created_at']));

        foreach ($couponArray['package_discounts'] as $packageDiscountArray) {
            $coupon->addPackageDiscount($this->createPackageDiscountFromArray($packageDiscountArray));
        }

        $coupon->setEndDate(CouponDate::toDateTime($couponArray['end_date']));
        $coupon->setNumUses($couponArray['max_uses']);
        $coupon->setNote($couponArray['note']);
        $coupon->setNumUses($couponArray['num_uses']);
        $coupon->setStartDate(CouponDate::toDateTime($couponArray['start_date']));
        $coupon->setSuspended($couponArray['suspended']);
        $coupon->setUpdatedAt(JsonDate::toDateTime($couponArray['updated_at']));
        $coupon->setBookId($couponArray['book_id']);

        return $coupon;
    }

    private function createPackageDiscountFromArray($packageDiscountArray)
    {
        return new PackageDiscount(
            $packageDiscountArray['package_slug'],
            $packageDiscountArray['discounted_price']
        );
    }
}
