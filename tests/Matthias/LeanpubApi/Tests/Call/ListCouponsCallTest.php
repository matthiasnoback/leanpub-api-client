<?php

namespace Matthias\LeanpubApi\Tests\Call;

use Matthias\LeanpubApi\Call\ListCouponsCall;
use Matthias\LeanpubApi\Serializer\DtoDeserializerInterface;

class ListCouponsCallTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DtoDeserializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $deserializer;

    /**
     * @var ListCouponsCall
     */
    private $listCouponsCall;

    protected function setUp()
    {
        $this->deserializer = $this->getMock('Matthias\LeanpubApi\Serializer\DtoDeserializerInterface');
        $this->listCouponsCall = new ListCouponsCall($this->deserializer, 'book-slug', 'json');
    }

    /**
     * @test
     */
    public function its_query_is_empty()
    {
        $this->assertSame(array(), $this->listCouponsCall->getQuery());
    }

    /**
     * @test
     */
    public function it_has_no_headers()
    {
        $this->assertSame(array(), $this->listCouponsCall->getHeaders());
    }

    /**
     * @test
     */
    public function its_method_is_get()
    {
        $this->assertSame('GET', $this->listCouponsCall->getMethod());
    }

    /**
     * @test
     */
    public function its_path_is_book_slug_slash_individual_purchases_dot_format()
    {
        $this->assertSame('/book-slug/coupons.json', $this->listCouponsCall->getPath());
    }

    /**
     * @test
     */
    public function its_body_is_empty()
    {
        $this->assertSame(null, $this->listCouponsCall->getBody());
    }

    /**
     * @test
     */
    public function its_response_is_a_deserialized_collection()
    {
        $responseBody = 'raw response body';
        $responseDto = new \stdClass();

        $this->deserializer
            ->expects($this->once())
            ->method('deserialize')
            ->with($responseBody, 'json')
            ->will($this->returnValue($responseDto));

        $this->assertSame($responseDto, $this->listCouponsCall->createResponseDto($responseBody));
    }
}
