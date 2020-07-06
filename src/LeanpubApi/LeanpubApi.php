<?php
declare(strict_types=1);

namespace LeanpubApi;

use Generator;
use LeanpubApi\BookSummary\BookSummary;
use LeanpubApi\BookSummary\GetBookSummary;
use LeanpubApi\BookSummary\GetBookSummaryFromLeanpubApi;
use LeanpubApi\Common\LeanpubApiClient;
use LeanpubApi\Coupons\Coupons;
use LeanpubApi\Coupons\CouponsUsingLeanpubApi;
use LeanpubApi\Coupons\CreateCoupon;
use LeanpubApi\IndividualPurchases\IndividualPurchaseFromLeanpubApi;
use LeanpubApi\IndividualPurchases\IndividualPurchases;
use LeanpubApi\JobStatus\GetJobStatus;
use LeanpubApi\JobStatus\GetJobStatusFromLeanpubApi;
use LeanpubApi\JobStatus\JobStatus;
use LeanpubApi\Publish\Publish;
use LeanpubApi\Publish\PublishUsingLeanpubApi;
use LeanpubApi\StartPreview\StartPreview;
use LeanpubApi\StartPreview\StartPreviewUsingLeanpubApi;

final class LeanpubApi implements
    IndividualPurchases,
    GetBookSummary,
    StartPreview,
    GetJobStatus,
    Publish,
    Coupons
{
    private LeanpubApiClient $leanpubApiClient;

    public function __construct(LeanpubApiClient $leanpubApiClient)
    {
        $this->leanpubApiClient = $leanpubApiClient;
    }

    public function allIndividualPurchases(): Generator
    {
        return (new IndividualPurchaseFromLeanpubApi($this->leanpubApiClient))->allIndividualPurchases();
    }

    public function getBookSummary(): BookSummary
    {
        return (new GetBookSummaryFromLeanpubApi($this->leanpubApiClient))->getBookSummary();
    }

    public function startPreview(): void
    {
        (new StartPreviewUsingLeanpubApi($this->leanpubApiClient))->startPreview();
    }

    public function startPreviewOfSubset(): void
    {
        (new StartPreviewUsingLeanpubApi($this->leanpubApiClient))->startPreviewOfSubset();
    }

    public function getJobStatus(): JobStatus
    {
        return (new GetJobStatusFromLeanpubApi($this->leanpubApiClient))->getJobStatus();
    }

    public function publishNewVersion(): void
    {
        (new PublishUsingLeanpubApi($this->leanpubApiClient))->publishNewVersion();
    }

    public function publishNewVersionAndEmailReaders(string $emailMessage): void
    {
        (new PublishUsingLeanpubApi($this->leanpubApiClient))->publishNewVersionAndEmailReaders($emailMessage);
    }

    public function createCoupon(CreateCoupon $createCoupon): void
    {
        (new CouponsUsingLeanpubApi($this->leanpubApiClient))->createCoupon($createCoupon);
    }
}
