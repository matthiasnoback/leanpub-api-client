<?php
declare(strict_types=1);

namespace LeanpubApi\Coupons;

interface Coupons
{
    public function createCoupon(CreateCoupon $createCoupon): void;
}
