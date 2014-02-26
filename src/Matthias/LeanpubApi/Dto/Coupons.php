<?php

namespace Matthias\LeanpubApi\Dto;

class Coupons implements \IteratorAggregate, \Countable
{
    private $coupons = array();

    public function addCoupon(Coupon $coupon)
    {
        $this->coupons[$coupon->getCouponCode()] = $coupon;
    }

    public function has($couponCode)
    {
        return isset($this->coupons[$couponCode]);
    }

    public function getCoupons()
    {
        return $this->coupons;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->coupons);
    }

    public function count()
    {
        return count($this->coupons);
    }
}
