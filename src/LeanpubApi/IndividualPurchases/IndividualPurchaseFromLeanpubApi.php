<?php
declare(strict_types=1);

namespace LeanpubApi\IndividualPurchases;

use Generator;
use LeanpubApi\Common\LeanpubApiClient;
use function Safe\json_encode;

final class IndividualPurchaseFromLeanpubApi implements IndividualPurchases
{
    private LeanpubApiClient $leanpubApiClient;

    public function __construct(LeanpubApiClient $leanpubApiClient)
    {
        $this->leanpubApiClient = $leanpubApiClient;
    }

    public function allIndividualPurchases(): Generator
    {
        $page = 1;

        while (true) {
            $decodedData = $this->leanpubApiClient->getJsonData(
                '/individual_purchases.json',
                [
                    'page' => (string)$page
                ]
            );

            if (isset($decodedData['data']) && count($decodedData['data']) === 0) {
                // We know we reached the last page when the response contains an empty "data" key
                break;
            }

            foreach ($decodedData as $purchaseData) {
                if (!is_array($purchaseData)) {
                    throw CouldNotLoadIndividualPurchases::becauseJsonDataStructureIsInvalid(
                        json_encode($purchaseData)
                    );
                }

                yield Purchase::createFromJsonDecodedData($purchaseData);
            }

            $page++;
        }
    }
}
