<?php

namespace Matthias\LeanpubApi\Dto;

class PackageDiscount
{
    private $packageSlug;
    private $discountedPrice;

    public function __construct($packageSlug, $discountedPrice)
    {
        $this->setPackageSlug($packageSlug);
        $this->setDiscountedPrice($discountedPrice);
    }

    private function setPackageSlug($packageSlug)
    {
        $this->packageSlug = $packageSlug;
    }

    private function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = (float) $discountedPrice;
    }

    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    public function getPackageSlug()
    {
        return $this->packageSlug;
    }
}
