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
    "updated_at": "2013-04-17T22:12:58Z",
    "book_id": 123
  }
]
EOF;

        $couponCollection = new CouponCollection();
        $coupon = new Coupon();
        $coupon->setCouponCode('NOT_A_REAL_COUPON');
        $coupon->setSuspended(false);
        $coupon->setStartDate(new \DateTime('2013-04-17'));
        $coupon->setEndDate(new \DateTime('2016-05-17'));
        $coupon->setBookId(123);
        $coupon->setCreatedAt(new \DateTime('2013-04-17T22:12:58Z'));
        $coupon->setUpdatedAt(new \DateTime('2013-04-17T22:12:58Z'));
        $coupon->setMaxUses(null);
        $coupon->setNumUses(12);
        $coupon->setNote('This is not a real coupon');
        $coupon->addPackageDiscount(new PackageDiscount('book', 2));
        $coupon->addPackageDiscount(new PackageDiscount('teamedition', 4));
        $couponCollection->addCoupon($coupon);

        $actualCollection = $this->couponsDeserializer->deserialize($responseBody, 'json');

        $this->assertEquals($couponCollection, $actualCollection);
    }
}
