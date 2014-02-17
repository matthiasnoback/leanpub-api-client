<?php

namespace Matthias\LeanpubApi\Client;

use Guzzle\Http\ClientInterface as GuzzleClientInterface;
use Guzzle\Http\Exception\RequestException;
use Matthias\LeanpubApi\Call\ApiCallInterface;
use Matthias\LeanpubApi\Client\Exception\RequestFailedException;

class GuzzleClient implements ClientInterface
{
    private $guzzleClient;
    private $apiKey;

    public function __construct(GuzzleClientInterface $guzzleClient, $apiKey)
    {
        $this->guzzleClient = $guzzleClient;
        $this->apiKey = $apiKey;
    }

    public function callApi(ApiCallInterface $apiCall)
    {
        $request = $this->createRequestForApiCall($apiCall);

        try {
            $response = $this->guzzleClient->send($request);

            if (!$response->isSuccessful()) {
                throw new RequestFailedException('Response not successful: ' . (string)$response);
            }
        } catch (RequestException $exception) {
            throw new RequestFailedException('Request failed: ' . $exception->getMessage(), null, $exception);
        }

        return $apiCall->createResponseDto($response->getBody());
    }

    private function createRequestForApiCall(ApiCallInterface $apiCall)
    {
        $request = $this->guzzleClient->createRequest(
            $apiCall->getMethod(),
            $apiCall->getPath(),
            $apiCall->getHeaders(),
            $apiCall->getBody()
        );

        $query = $request->getQuery();
        $query->merge($apiCall->getQuery());
        $query->set('api_key', $this->apiKey);

        return $request;
    }
}
