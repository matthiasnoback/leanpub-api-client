<?php
declare(strict_types=1);

namespace LeanpubApi\Coupons;

use LeanpubApi\Common\LeanpubApiClient;
use LeanpubApi\Console\CouldNotCreateCoupon;

final class CouponsUsingLeanpubApi implements Coupons
{
    private LeanpubApiClient $leanpubApiClient;

    public function __construct(LeanpubApiClient $leanpubApiClient)
    {
        $this->leanpubApiClient = $leanpubApiClient;
    }

    public function createCoupon(CreateCoupon $createCoupon): void
    {
        $result = $this->leanpubApiClient->postJsonData(
            '/coupons.json',
            $createCoupon->asArray()
        );

        if (isset($result['status'])) {
            throw CouldNotCreateCoupon::responseReturnedInternalServerError($result);
        }

        if (!isset($result['success']) || !$result['success']) {
            throw CouldNotCreateCoupon::responseWasUnsuccessful($result);
        }
    }
}
