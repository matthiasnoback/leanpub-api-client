<?php

namespace Matthias\LeanpubApi\Dto;

use Assert\Assertion;

class PackageDiscount
{
    private $packageSlug;
    private $discountedPrice;

    /**
     * @param string $packageSlug
     * @param float $discountedPrice
     */
    public function __construct($packageSlug, $discountedPrice)
    {
        $this->setPackageSlug($packageSlug);
        $this->setDiscountedPrice($discountedPrice);
    }

    /**
     * @param string $packageSlug
     */
    private function setPackageSlug($packageSlug)
    {
        Assertion::notEmpty($packageSlug, 'Package slug should not be empty');

        $this->packageSlug = $packageSlug;
    }

    /**
     * @param float $discountedPrice
     */
    private function setDiscountedPrice($discountedPrice)
    {
        Assertion::numeric($discountedPrice, 'Discounted price should be numeric');

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
