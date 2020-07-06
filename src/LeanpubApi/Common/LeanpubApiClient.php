<?php
declare(strict_types=1);

namespace LeanpubApi\Common;

use Http\Message\RequestFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Safe\Exceptions\JsonException;
use function Safe\json_decode;
use function Safe\json_encode;

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
     * @param array<string,mixed> $jsonData
     * @return array<string,mixed>
     */
    public function postJsonData(string $uri, array $jsonData): array
    {
        $request = $this->requestFactory->createRequest(
            'POST',
            $this->buildUrl($uri),
            [
                'Content-Type' => 'application/json'
            ],
            json_encode($jsonData)
        );

        return $this->sendRequestAndParseResponse($request);
    }

    /**
     * @param array<string,mixed> $formData
     * @return array<string,mixed>
     */
    public function postFormData(string $uri, array $formData): array
    {
        $formData['api_key'] = $this->apiKey->asString();

        $request = $this->requestFactory->createRequest(
            'POST',
            $this->buildUrl($uri),
            [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            http_build_query($formData)
        );

        return $this->sendRequestAndParseResponse($request);
    }

    /**
     * @param array<string,mixed> $queryParameters
     * @return array<string,mixed>
     */
    public function getJsonData(string $uri, array $queryParameters = []): array
    {
        $request = $this->requestFactory->createRequest(
            'GET',
            $this->buildUrl($uri, $queryParameters)
        );

        return $this->sendRequestAndParseResponse($request);
    }

    /**
     * @return array<string,mixed>
     */
    private function sendRequestAndParseResponse(RequestInterface $request): array
    {
        $response = $this->client->sendRequest($request);

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

    /**
     * @param array<string,mixed> $queryParameters
     */
    private function buildUrl(string $uri, array $queryParameters = []): string
    {
        $queryParameters['api_key'] = $this->apiKey->asString();

        return $this->baseUrl->asString()
            . '/' . $this->bookSlug->asString()
            . $uri
            . '?' . http_build_query($queryParameters);
    }
}
