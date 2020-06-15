<?php
declare(strict_types=1);

namespace LeanpubApi;

use Generator;
use Http\Message\RequestFactory;
use LeanpubApi\BookSummary\BookSummary;
use LeanpubApi\BookSummary\GetBookSummary;
use LeanpubApi\BookSummary\GetBookSummaryFromLeanpubApi;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use LeanpubApi\IndividualPurchases\IndividualPurchaseFromLeanpubApi;
use LeanpubApi\IndividualPurchases\IndividualPurchases;
use LeanpubApi\JobStatus\GetJobStatus;
use LeanpubApi\JobStatus\GetJobStatusFromLeanpubApi;
use LeanpubApi\JobStatus\JobStatus;
use LeanpubApi\Publish\Publish;
use LeanpubApi\Publish\PublishUsingLeanpubApi;
use LeanpubApi\StartPreview\StartPreview;
use LeanpubApi\StartPreview\StartPreviewUsingLeanpubApi;
use Psr\Http\Client\ClientInterface;

final class LeanpubApi implements
    IndividualPurchases,
    GetBookSummary,
    StartPreview,
    GetJobStatus,
    Publish
{
    private ApiKey $apiKey;

    private BookSlug $bookSlug;

    private BaseUrl $baseUrl;

    private ClientInterface $httpClient;

    private RequestFactory $requestFactory;

    public function __construct(
        ApiKey $apiKey,
        BookSlug $bookSlug,
        BaseUrl $baseUrl,
        ClientInterface $httpClient,
        RequestFactory $requestFactory
    ) {
        $this->apiKey = $apiKey;
        $this->bookSlug = $bookSlug;
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    public function allIndividualPurchases(): Generator
    {
        return (new IndividualPurchaseFromLeanpubApi(
            $this->bookSlug,
            $this->apiKey,
            $this->baseUrl,
            $this->httpClient,
            $this->requestFactory))->allIndividualPurchases();
    }

    public function getBookSummary(): BookSummary
    {
        return (new GetBookSummaryFromLeanpubApi(
            $this->apiKey,
            $this->baseUrl,
            $this->bookSlug,
            $this->httpClient,
            $this->requestFactory))->getBookSummary();
    }

    public function startPreview(): void
    {
        (new StartPreviewUsingLeanpubApi(
            $this->bookSlug,
            $this->apiKey,
            $this->baseUrl,
            $this->httpClient,
            $this->requestFactory
        ))->startPreview();
    }

    public function startPreviewOfSubset(): void
    {
        (new StartPreviewUsingLeanpubApi(
            $this->bookSlug,
            $this->apiKey,
            $this->baseUrl,
            $this->httpClient,
            $this->requestFactory
        ))->startPreviewOfSubset();
    }

    public function getJobStatus(): JobStatus
    {
        return (new GetJobStatusFromLeanpubApi(
            $this->bookSlug,
            $this->apiKey,
            $this->baseUrl,
            $this->httpClient,
            $this->requestFactory
        ))->getJobStatus();
    }

    public function publishNewVersion(): void
    {
        (new PublishUsingLeanpubApi(
            $this->bookSlug,
            $this->apiKey,
            $this->baseUrl,
            $this->httpClient,
            $this->requestFactory
        ))->publishNewVersion();
    }

    public function publishNewVersionAndEmailReaders(string $emailMessage): void
    {
        (new PublishUsingLeanpubApi(
            $this->bookSlug,
            $this->apiKey,
            $this->baseUrl,
            $this->httpClient,
            $this->requestFactory
        ))->publishNewVersionAndEmailReaders($emailMessage);
    }
}
