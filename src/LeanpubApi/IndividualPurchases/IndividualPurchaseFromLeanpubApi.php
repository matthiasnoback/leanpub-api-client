<?php
declare(strict_types=1);

namespace LeanpubApi\IndividualPurchases;

use Generator;
use GuzzleHttp\Psr7\Request;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use Psr\Http\Client\ClientInterface;
use Safe\Exceptions\JsonException;
use function Safe\json_decode;
use function Safe\json_encode;

final class IndividualPurchaseFromLeanpubApi implements IndividualPurchases
{
    private BookSlug $bookSlug;

    private ApiKey $apiKey;

    private BaseUrl $leanpubApiBaseUrl;

    private ClientInterface $httpClient;

    public function __construct(
        BookSlug $bookSlug,
        ApiKey $apiKey,
        BaseUrl $leanpubApiBaseUrl,
        ClientInterface $httpClient
    ) {
        $this->bookSlug = $bookSlug;
        $this->apiKey = $apiKey;
        $this->leanpubApiBaseUrl = $leanpubApiBaseUrl;
        $this->httpClient = $httpClient;
    }

    public function allIndividualPurchases(): Generator
    {
        $page = 1;

        while (true) {
            $decodedData = $this->loadPage($page);

            if (isset($decodedData['data']) && count($decodedData['data']) === 0) {
                // We know we reached the last page when the response contains an empty "data" key
                break;
            }

            foreach ($decodedData as $purchaseData) {
                if (!is_array($purchaseData)) {
                    throw CouldNotLoadIndividualPurchases::becauseJsonDataStructureIsInvalid(
                        json_encode($purchaseData));
                }

                yield Purchase::createFromJsonDecodedData($purchaseData);
            }

            $page++;
        }
    }

    /**
     * @return array<mixed>
     */
    private function loadPage(int $page): array
    {
        $response = $this->httpClient->sendRequest(
            new Request(
                'GET',
                sprintf(
                    '%s/%s/individual_purchases.json?api_key=%s&page=%d',
                    $this->leanpubApiBaseUrl->asString(),
                    $this->bookSlug->asString(),
                    $this->apiKey->asString(),
                    $page
                )
            )
        );

        $jsonData = $response->getBody()->getContents();

        try {
            $decodedData = json_decode($jsonData, true);
        } catch (JsonException $previous) {
            throw CouldNotLoadIndividualPurchases::becauseJsonDataIsInvalid($jsonData, $previous);
        }

        if (!is_array($decodedData)) {
            throw CouldNotLoadIndividualPurchases::becauseJsonDataStructureIsInvalid($jsonData);
        }

        return $decodedData;
    }
}
