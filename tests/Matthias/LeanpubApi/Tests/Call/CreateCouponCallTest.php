<?php

namespace Matthias\LeanpubApi\Tests\Call;

use Matthias\LeanpubApi\Call\CreateCouponCall;
use Matthias\LeanpubApi\Dto\CreateCoupon;

class CreateCouponCallTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $validator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $serializer;

    /**
     * @var CreateCoupon
     */
    private $createCoupon;

    /**
     * @var CreateCouponCall
     */
    private $createCouponCall;

    protected function setUp()
    {
        $this->validator = $this->getMock('Matthias\LeanpubApi\Validator\DtoValidatorInterface');
        $this->serializer = $this->getMock('Matthias\LeanpubApi\Serializer\DtoSerializerInterface');
        $this->createCoupon = new CreateCoupon('coupon-code', new \DateTime());
        $this->createCouponCall = new CreateCouponCall($this->validator, $this->serializer, 'book-slug', $this->createCoupon, 'json');
    }

    /**
     * @test
     */
    public function its_method_is_post()
    {
        $this->assertSame('POST', $this->createCouponCall->getMethod());
    }

    /**
     * @test
     */
    public function it_has_content_type_json_header()
    {
        $this->assertSame(array('Content-Type' => 'application/json'), $this->createCouponCall->getHeaders());
    }

    /**
     * @test
     */
    public function it_has_a_validated_and_serialized_coupon_as_body()
    {
        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->with($this->createCoupon);

        $serializedCreateCoupon = '{serialized-create-coupon}';

        $this->serializer
            ->expects($this->once())
            ->method('serialize', 'json')
            ->with($this->createCoupon)
            ->will($this->returnValue($serializedCreateCoupon));

        $this->assertSame($serializedCreateCoupon, $this->createCouponCall->getBody());
    }

    /**
     * @test
     */
    public function its_path_is_book_slug_slash_coupons_dot_json()
    {
        $this->assertSame('/book-slug/coupons.json', $this->createCouponCall->getPath());
    }

    /**
     * @test
     */
    public function it_returns_true_if_response_body_has_success_flag()
    {
        $this->assertSame(true, $this->createCouponCall->createResponseDto('{"success":true}'));
    }

    /**
     * @test
     */
    public function it_fails_when_response_body_has_no_success_flag()
    {
        $this->setExpectedException('Matthias\LeanpubApi\Client\Exception\RequestFailedException');

        $this->assertSame(true, $this->createCouponCall->createResponseDto('{}'));
    }

    /**
     * @test
     */
    public function it_fails_when_response_body_has_success_flag_that_is_false()
    {
        $this->setExpectedException('Matthias\LeanpubApi\Client\Exception\RequestFailedException');

        $this->assertSame(true, $this->createCouponCall->createResponseDto('{"success":false}'));
    }
}
