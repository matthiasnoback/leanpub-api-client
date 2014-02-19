<?php

namespace Matthias\LeanpubApi\Tests\Serializer;

use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Dto\PackageDiscount;
use Matthias\LeanpubApi\Serializer\CreateCouponSerializer;

class CreateCouponSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateCouponSerializer
     */
    private $serializer;

    protected function setUp()
    {
        $this->serializer = new CreateCouponSerializer();
    }

    /**
     * @test
     */
    public function it_fails_when_dto_is_not_a_create_coupon_instance()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->serializer->serialize($this->getMock('Matthias\LeanpubApi\Dto\DtoInterface'), 'json');
    }

    /**
     * @test
     */
    public function it_fails_when_format_is_not_json()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->serializer->serialize($this->getMock('Matthias\LeanpubApi\Dto\DtoInterface'), 'xml');
    }

    /**
     * @test
     */
    public function it_serializes_a_coupon_to_the_expected_json_format()
    {
        $start = new \DateTime('2014-02-16');
        $end = null;
        $coupon = new CreateCoupon('1234', $start);
        $coupon->setMaxUses(10);
        $coupon->setNote('Sample coupon');
        $coupon->setSuspended(true);

        $packageDiscount = new PackageDiscount('a-year-with-symfony', 10);
        $coupon->addPackageDiscount($packageDiscount);

        $this->assertSame(
             '{"coupon_code":"1234","package_discounts_attributes":[{"package_slug":"a-year-with-symfony","discounted_price":10}],"start_date":"2014-02-16","end_date":null,"max_uses":10,"note":"Sample coupon","suspended":true}',
            $this->serializer->serialize($coupon, 'json')
        );
    }
}
