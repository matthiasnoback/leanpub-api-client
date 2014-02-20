<?php

namespace Matthias\LeanpubApi\Tests\Dto;

use Matthias\LeanpubApi\Dto\Coupon;
use Matthias\LeanpubApi\Dto\Coupons;

class CouponsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Coupons
     */
    private $coupons;

    protected function setUp()
    {
        $this->coupons = new Coupons();
    }

    /**
     * @test
     */
    public function it_knows_if_a_coupon_with_a_given_coupon_code_exists()
    {
        $coupon = new Coupon();
        $coupon->setCouponCode('coupon-code');

        $this->coupons->addCoupon($coupon);

        $this->assertTrue($this->coupons->exists('coupon-code'));
        $this->assertFalse($this->coupons->exists('non-existing-coupon-code'));
    }

    /**
     * @test
     */
    public function it_knows_how_many_coupons_it_contains()
    {
        $coupon1 = new Coupon();
        $coupon1->setCouponCode('coupon-code-1');
        $this->coupons->addCoupon($coupon1);

        $coupon2 = new Coupon();
        $coupon2->setCouponCode('coupon-code-2');
        $this->coupons->addCoupon($coupon2);

        $this->assertCount(2, $this->coupons);
    }

    /**
     * @test
     */
    public function it_is_iterable()
    {
        $coupon1 = new Coupon();
        $coupon1->setCouponCode('coupon-code-1');
        $this->coupons->addCoupon($coupon1);

        $coupon2 = new Coupon();
        $coupon2->setCouponCode('coupon-code-2');
        $this->coupons->addCoupon($coupon2);

        $this->assertSame(
            array('coupon-code-1' => $coupon1, 'coupon-code-2' => $coupon2),
            iterator_to_array($this->coupons)
        );
    }
}
