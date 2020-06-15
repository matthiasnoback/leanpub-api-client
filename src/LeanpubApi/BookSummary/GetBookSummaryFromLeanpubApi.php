<?php
declare(strict_types=1);

namespace LeanpubApi\BookSummary;

use Http\Message\RequestFactory;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use LeanpubApi\IndividualPurchases\CouldNotLoadIndividualPurchases;
use Psr\Http\Client\ClientInterface;
use Safe\Exceptions\JsonException;
use function Safe\json_decode;

final class GetBookSummaryFromLeanpubApi implements GetBookSummary
{
    private ApiKey $apiKey;

    private BaseUrl $baseUrl;

    private BookSlug $bookSlug;

    private ClientInterface $httpClient;

    private RequestFactory $requestFactory;

    public function __construct(
        ApiKey $apiKey,
        BaseUrl $baseUrl,
        BookSlug $bookSlug,
        ClientInterface $httpClient,
        RequestFactory $requestFactory
    ) {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
        $this->bookSlug = $bookSlug;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    public function getBookSummary(): BookSummary
    {
        $response = $this->httpClient->sendRequest(
            $this->requestFactory->createRequest(
                'GET',
                sprintf(
                    '%s/%s.json?api_key=%s',
                    $this->baseUrl->asString(),
                    $this->bookSlug->asString(),
                    $this->apiKey->asString()
                )
            )
        );

        $jsonData = $response->getBody()->getContents();

        try {
            $decodedData = json_decode($jsonData, true);
        } catch (JsonException $previous) {
            throw CouldNotLoadIndividualPurchases::becauseJsonDataIsInvalid($jsonData, $previous);
        }

        return BookSummary::fromJsonDecodedData($decodedData);
    }
}
