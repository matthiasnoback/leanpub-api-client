<?php
declare(strict_types=1);

namespace LeanpubApi\Coupons;

final class PackageDiscount
{
    private string $packageSlug;
    private float $discountedPrice;

    public function __construct(
        string $packageSlug,
        float $discountedPrice
    ) {
        $this->packageSlug = $packageSlug;
        $this->discountedPrice = $discountedPrice;
    }

    /**
     * @return array<string,mixed>
     */
    public function asArray(): array
    {
        return [
            'package_slug' => $this->packageSlug,
            'discounted_price' => $this->discountedPrice
        ];
    }
}
