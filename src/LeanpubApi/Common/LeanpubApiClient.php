<?php
declare(strict_types=1);

namespace LeanpubApi\Common;

use Http\Message\RequestFactory;
use Psr\Http\Client\ClientInterface;
use Safe\Exceptions\JsonException;
use function Safe\json_decode;

final class LeanpubApiClient
{
    private ClientInterface $client;

    private RequestFactory $requestFactory;

    private BaseUrl $baseUrl;

    private ApiKey $apiKey;

    private BookSlug $bookSlug;

    public function __construct(
        ClientInterface $client,
        RequestFactory $requestFactory,
        BaseUrl $baseUrl,
        ApiKey $apiKey,
        BookSlug $bookSlug
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->apiKey = $apiKey;
        $this->bookSlug = $bookSlug;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param array<string,string> $parameters
     * @return array<mixed>
     */
    public function getJsonDecodedDataForRequest(string $method, string $uri, array $parameters = []): array
    {
        $parameters['api_key'] = $this->apiKey->asString();

        $uri = $this->baseUrl->asString() . '/' . $this->bookSlug->asString() . $uri;
        if ($method === 'GET' && !empty($parameters)) {
            $uri .= '?' . http_build_query($parameters);
        }

        $headers = [];
        if ($method === 'POST') {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        $body = null;
        if ($method === 'POST' && !empty($parameters)) {
            $body = http_build_query($parameters);
        }

        $response = $this->client->sendRequest(
            $this->requestFactory->createRequest(
                $method,
                $uri,
                $headers,
                $body
            )
        );

        if ($response->getStatusCode() === 302) {
            $locationHeaders = $response->getHeader('Location');
            if (count($locationHeaders) === 1 && strpos($locationHeaders[0], '/login') !== false) {
                throw BadResponse::redirectToLoginPage($this->apiKey, $this->bookSlug);
            }
        }

        $responseBody = $response->getBody()->getContents();

        try {
            $responseData = json_decode($responseBody, true);
        } catch (JsonException $exception) {
            throw BadResponse::invalidJson($responseBody);
        }

        if (!is_array($responseData)) {
            throw BadResponse::expectedJsonDecodedDataToBeAnArray($responseBody);
        }

        return $responseData;
    }
}
