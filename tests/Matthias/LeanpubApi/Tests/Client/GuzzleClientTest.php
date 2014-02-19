<?php

namespace Matthias\LeanpubApi\Tests\Client;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;
use Matthias\LeanpubApi\Client\GuzzleClient;

class GuzzleClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $guzzleClient;

    /**
     * @var GuzzleClient
     */
    private $apiClient;

    private $apiKey;

    protected function setUp()
    {
        $this->guzzleClient = $this
            ->getMockBuilder('Guzzle\Http\Client')
            ->setMethods(array('send'))
            ->getMock();

        $this->apiKey = '1234';

        $this->apiClient = new GuzzleClient($this->guzzleClient, $this->apiKey);
    }

    /**
     * @test
     */
    public function it_sends_a_request_created_for_an_api_call_instance()
    {
        $responseDto = new \stdClass();

        $apiCall = $this->getMock('Matthias\LeanpubApi\Call\ApiCallInterface');
        $apiCallQuery = array('page' => 1);
        $apiCall
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($apiCallQuery));
        $apiCallMethod = 'GET';
        $apiCall
            ->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue($apiCallMethod));
        $apiCallHeaders = array('Content-Type' => 'application/json');
        $apiCall
            ->expects($this->once())
            ->method('getHeaders')
            ->will($this->returnValue($apiCallHeaders));
        $apiCallPath = '/path';
        $apiCall
            ->expects($this->once())
            ->method('getPath')
            ->will($this->returnValue($apiCallPath));

        $responseBody = 'Response body';

        $apiCall
            ->expects($this->once())
            ->method('createResponseDto')
            ->with($responseBody)
            ->will($this->returnValue($responseDto));

        $actualRequest = null;

        $response = $this->createMockResponse(true, $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->will($this->returnCallback(function(RequestInterface $request) use ($response, &$actualRequest) {
                        $actualRequest = $request;
                        return $response;
                    }));

        $actualResponseDto = $this->apiClient->callApi($apiCall);
        $this->assertSame($responseDto, $actualResponseDto);

        /* @var $actualRequest \Guzzle\Http\Message\RequestInterface */
        $this->assertEquals($apiCallHeaders['Content-Type'], $actualRequest->getHeader('Content-Type'));
        $this->assertEquals($apiCallMethod, $actualRequest->getMethod());
        $this->assertEquals($apiCallPath, $actualRequest->getPath());
        $this->assertEquals($apiCallQuery['page'], $actualRequest->getQuery()->get('page'));
        $this->assertEquals($this->apiKey, $actualRequest->getQuery()->get('api_key'));
    }

    private function createMockResponse($successful, $body)
    {
        $response = $this
            ->getMockBuilder('Guzzle\Http\Message\Response')
            ->disableOriginalConstructor()
            ->setMethods(array('isSuccessful', 'getBody'))
            ->getMock();

        $response
            ->expects($this->any())
            ->method('isSuccessful')
            ->will($this->returnValue($successful));

        $response
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($body));

        return $response;
    }
}
