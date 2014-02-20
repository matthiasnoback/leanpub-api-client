<?php

namespace Matthias\LeanpubApi\Tests\Call;

use Matthias\LeanpubApi\Call\ListAllSalesCall;

class ListAllSalesCallTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $deserializer;

    /**
     * @var ListAllSalesCall
     */
    private $listAllSalesCall;

    protected function setUp()
    {
        $this->deserializer = $this->getMock('Matthias\LeanpubApi\Serializer\DtoDeserializerInterface');
        $this->listAllSalesCall = new ListAllSalesCall($this->deserializer, 'book-slug', 2, 'json');
    }

    /**
     * @test
     */
    public function its_query_contains_the_page()
    {
        $this->assertSame(array('page' => 2), $this->listAllSalesCall->getQuery());
    }

    /**
     * @test
     */
    public function it_has_no_headers()
    {
        $this->assertSame(array(), $this->listAllSalesCall->getHeaders());
    }

    /**
     * @test
     */
    public function its_method_is_get()
    {
        $this->assertSame('GET', $this->listAllSalesCall->getMethod());
    }

    /**
     * @test
     */
    public function its_path_is_book_slug_slash_individual_purchases_dot_format()
    {
        $this->assertSame('/book-slug/individual_purchases.json', $this->listAllSalesCall->getPath());
    }

    /**
     * @test
     */
    public function its_body_is_empty()
    {
        $this->assertSame(null, $this->listAllSalesCall->getBody());
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

        $this->assertSame($responseDto, $this->listAllSalesCall->createResponseDto($responseBody));
    }
}
