<?php
declare(strict_types=1);

namespace LeanpubApi\StartPreview;

use LeanpubApi\Common\LeanpubApiClient;

final class StartPreviewUsingLeanpubApi implements StartPreview
{
    private LeanpubApiClient $leanpubApiClient;

    public function __construct(LeanpubApiClient $leanpubApiClient)
    {
        $this->leanpubApiClient = $leanpubApiClient;
    }

    public function startPreview(): void
    {
        $responseData = $this->leanpubApiClient->getJsonDecodedDataForRequest('POST', '/preview.json');

        if (!isset($responseData['success']) || $responseData['success'] !== true) {
            throw CouldNotStartPreview::unknownReason();
        }
    }

    public function startPreviewOfSubset(): void
    {
        $responseData = $this->leanpubApiClient->getJsonDecodedDataForRequest('POST', '/preview/subset.json');

        if (!isset($responseData['success']) || $responseData['success'] !== true) {
            throw CouldNotStartPreview::unknownReason();
        }
    }
}
