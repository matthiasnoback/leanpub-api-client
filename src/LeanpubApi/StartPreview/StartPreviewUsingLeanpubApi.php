<?php
declare(strict_types=1);

namespace LeanpubApi\StartPreview;

use Http\Message\RequestFactory;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use Psr\Http\Client\ClientInterface;
use Safe\Exceptions\JsonException;
use function Safe\json_decode;

final class StartPreviewUsingLeanpubApi implements StartPreview
{
    private BookSlug $bookSlug;

    private ApiKey $apiKey;

    private BaseUrl $baseUrl;

    private ClientInterface $httpClient;

    private RequestFactory $requestFactory;

    public function __construct(
        BookSlug $bookSlug,
        ApiKey $apiKey,
        BaseUrl $leanpubApiBaseUrl,
        ClientInterface $httpClient,
        RequestFactory $requestFactory
    ) {
        $this->bookSlug = $bookSlug;
        $this->apiKey = $apiKey;
        $this->baseUrl = $leanpubApiBaseUrl;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    public function startPreview(): void
    {
        $response = $this->httpClient->sendRequest(
            $this->requestFactory->createRequest(
                'POST',
                sprintf(
                    '%s/%s/preview.json?api_key=%s',
                    $this->baseUrl->asString(),
                    $this->bookSlug->asString(),
                    $this->apiKey->asString()
                ),
                [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            )
        );
        $responseBody = $response->getBody()->getContents();

        try {
            $responseData = json_decode($responseBody, true);
        } catch (JsonException $exception) {
            throw CouldNotStartPreview::invalidJsonResponse($responseBody);
        }

        if (!$responseData['success'] || $responseData['success'] !== true) {
            throw CouldNotStartPreview::unknownReason();
        }
    }
}
