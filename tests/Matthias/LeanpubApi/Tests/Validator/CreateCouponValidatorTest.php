<?php

namespace Matthias\LeanpubApi\Tests\Validator;

use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Dto\PackageDiscount;
use Matthias\LeanpubApi\Validator\CreateCouponValidator;

class CreateCouponValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateCouponValidator
     */
    private $createCouponValidator;

    protected function setUp()
    {
        $this->createCouponValidator = new CreateCouponValidator();
    }

    /**
     * @test
     */
    public function it_fails_when_dto_is_not_create_coupon_dto()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->createCouponValidator->validate($this->getMock('Matthias\LeanpubApi\Dto\DtoInterface'));
    }

    /**
     * @test
     */
    public function it_fails_when_coupon_has_no_package_discounts()
    {
        $createCoupon = new CreateCoupon('coupon-code', new \DateTime());

        $this->setExpectedException('Matthias\LeanpubApi\Validator\Exception\BadRequestException');

        $this->createCouponValidator->validate($createCoupon);
    }

    /**
     * @test
     */
    public function it_does_nothing_when_coupon_is_valid()
    {
        $createCoupon = new CreateCoupon('coupon-code', new \DateTime());
        $createCoupon->addPackageDiscount(new PackageDiscount('package', 10));

        $this->createCouponValidator->validate($createCoupon);
    }
}
