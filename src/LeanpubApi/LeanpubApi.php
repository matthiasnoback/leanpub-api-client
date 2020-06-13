<?php
declare(strict_types=1);

namespace LeanpubApi;

use Generator;
use LeanpubApi\BookSummary\BookSummary;
use LeanpubApi\BookSummary\GetBookSummary;
use LeanpubApi\BookSummary\GetBookSummaryFromLeanpubApi;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use LeanpubApi\IndividualPurchases\IndividualPurchaseFromLeanpubApi;
use LeanpubApi\IndividualPurchases\IndividualPurchases;
use Psr\Http\Client\ClientInterface;

final class LeanpubApi implements IndividualPurchases, GetBookSummary
{
    private ApiKey $apiKey;

    private BookSlug $bookSlug;

    private BaseUrl $baseUrl;

    private ClientInterface $httpClient;

    public function __construct(
        ApiKey $apiKey,
        BookSlug $bookSlug,
        BaseUrl $baseUrl,
        ClientInterface $httpClient
    ) {
        $this->apiKey = $apiKey;
        $this->bookSlug = $bookSlug;
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient;
    }

    public function allIndividualPurchases(): Generator
    {
        return (new IndividualPurchaseFromLeanpubApi(
            $this->bookSlug,
            $this->apiKey,
            $this->baseUrl,
            $this->httpClient))->allIndividualPurchases();
    }

    public function getBookSummary(): BookSummary
    {
        return (new GetBookSummaryFromLeanpubApi(
            $this->apiKey,
            $this->baseUrl,
            $this->bookSlug,
            $this->httpClient))->getBookSummary();
    }
}
