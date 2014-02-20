<?php

namespace Matthias\LeanpubApi\Tests\Serializer;

use Matthias\LeanpubApi\Dto\Coupon;
use Matthias\LeanpubApi\Dto\CouponCollection;
use Matthias\LeanpubApi\Dto\PackageDiscount;
use Matthias\LeanpubApi\Serializer\CouponsDeserializer;

class CouponsDeserializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CouponsDeserializer
     */
    private $couponsDeserializer;

    protected function setUp()
    {
        $this->couponsDeserializer = new CouponsDeserializer();
    }

    /**
     * @test
     */
    public function it_fails_when_format_is_not_json()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $this->couponsDeserializer->deserialize('body', 'xml');
    }

    /**
     * @test
     */
    public function it_deserializes_a_collection_of_coupons()
    {
        $responseBody = <<<EOF
[
  {
    "coupon_code": "NOT_A_REAL_COUPON",
    "created_at": "2013-04-17T22:12:58Z",
    "package_discounts": [
      {
        "package_slug": "book",
        "discounted_price": 2.0
      },
      {
        "package_slug": "teamedition",
        "discounted_price": 4.0
      }
    ],
    "end_date": "2016-05-17",
    "max_uses": null,
    "note": "This is not a real coupon",
    "num_uses": 12,
    "start_date": "2013-04-17",
    "suspended": false,
    "updated_at": "2013-04-17T23:12:58Z",
    "book_id": 123
  }
]
EOF;

        $actualCollection = $this->couponsDeserializer->deserialize($responseBody, 'json');
        $this->assertCount(1, $actualCollection);

        $actualCoupons = $actualCollection->getCoupons();
        $actualCoupon = reset($actualCoupons);
        /* @var $actualCoupon Coupon */

        $this->assertSame('NOT_A_REAL_COUPON', $actualCoupon ->getCouponCode());
        $this->assertSame(false, $actualCoupon ->isSuspended());
        $this->assertEquals(new \DateTime('2013-04-17'), $actualCoupon ->getStartDate());
        $this->assertEquals(new \DateTime('2016-05-17'), $actualCoupon ->getEndDate());
        $this->assertSame(123, $actualCoupon ->getBookId());
        $this->assertEquals(new \DateTime('2013-04-17T22:12:58Z'), $actualCoupon ->getCreatedAt());
        $this->assertEquals(new \DateTime('2013-04-17T23:12:58Z'), $actualCoupon ->getUpdatedAt());
        $this->assertSame(null, $actualCoupon ->getMaxUses());
        $this->assertSame(12, $actualCoupon ->getNumUses());
        $this->assertSame('This is not a real coupon', $actualCoupon ->getNote());
        $packageDiscounts = $actualCoupon->getPackageDiscounts();
        $this->assertCount(2, $packageDiscounts);
        $this->assertSame('book', $packageDiscounts[0]->getPackageSlug());
        $this->assertEquals(2, $packageDiscounts[0]->getDiscountedPrice());
        $this->assertSame('teamedition', $packageDiscounts[1]->getPackageSlug());
        $this->assertEquals(4, $packageDiscounts[1]->getDiscountedPrice());
    }
}
