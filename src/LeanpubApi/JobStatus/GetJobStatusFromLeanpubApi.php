<?php
declare(strict_types=1);

namespace LeanpubApi\JobStatus;

use LeanpubApi\Common\LeanpubApiClient;

final class GetJobStatusFromLeanpubApi implements GetJobStatus
{
    private LeanpubApiClient $leanpubApiClient;

    public function __construct(LeanpubApiClient $leanpubApiClient)
    {
        $this->leanpubApiClient = $leanpubApiClient;
    }

    public function getJobStatus(): JobStatus
    {
        $responseData = $this->leanpubApiClient->getJsonDecodedDataForRequest('GET', '/job_status.json');

        return JobStatus::fromJsonDecodedData($responseData);
    }
}
