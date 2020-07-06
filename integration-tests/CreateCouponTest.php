<?php
declare(strict_types=1);

namespace IntegrationTests;

use DateTimeImmutable;
use LeanpubApi\Console\CouldNotCreateCoupon;
use LeanpubApi\Coupons\CreateCoupon;
use LeanpubApi\Coupons\PackageDiscount;

final class CreateCouponTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_can_create_a_new_coupon(): void
    {
        $this->leanpubApi->createCoupon(
            new CreateCoupon(
                'COUPON_CODE',
                [
                    new PackageDiscount('book', 10.00)
                ],
                new DateTimeImmutable('2020-01-01'),
                new DateTimeImmutable('2020-02-01'),
                1,
                'Note',
                false
            )
        );
    }

    /**
     * @test
     */
    public function it_fails_when_the_package_slug_is_unknown(): void
    {
        $this->expectException(CouldNotCreateCoupon::class);
        $this->expectExceptionMessage('unknown package slug');

        $this->leanpubApi->createCoupon(
            new CreateCoupon(
                'COUPON_CODE',
                [
                    new PackageDiscount('unknown_package_slug', 10.00)
                ],
                new DateTimeImmutable('2020-01-01'),
                new DateTimeImmutable('2020-02-01'),
                1,
                'Note',
                false
            )
        );
    }

    /**
     * @test
     */
    public function it_fails_when_the_coupon_code_has_been_used_before(): void
    {
        $this->expectException(CouldNotCreateCoupon::class);
        $this->expectExceptionMessage('coupon code');

        $this->leanpubApi->createCoupon(
            new CreateCoupon(
                'COUPON_CODE_USED_BEFORE',
                [
                    new PackageDiscount('book', 10.00)
                ],
                new DateTimeImmutable('2020-01-01'),
                new DateTimeImmutable('2020-02-01'),
                1,
                'Note',
                false
            )
        );
    }
}
