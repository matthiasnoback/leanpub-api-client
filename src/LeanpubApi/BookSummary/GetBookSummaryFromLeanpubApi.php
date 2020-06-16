<?php
declare(strict_types=1);

namespace LeanpubApi\BookSummary;

use LeanpubApi\Common\LeanpubApiClient;

final class GetBookSummaryFromLeanpubApi implements GetBookSummary
{
    private LeanpubApiClient $leanpubApiClient;

    public function __construct(LeanpubApiClient $leanpubApiClient)
    {
        $this->leanpubApiClient = $leanpubApiClient;
    }

    public function getBookSummary(): BookSummary
    {
        $decodedData = $this->leanpubApiClient->getJsonDecodedDataForRequest('GET', '.json');

        return BookSummary::fromJsonDecodedData($decodedData);
    }
}
