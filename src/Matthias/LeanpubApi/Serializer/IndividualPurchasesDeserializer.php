<?php

namespace Matthias\LeanpubApi\Serializer;

use Assert\Assertion;
use Matthias\LeanpubApi\Dto\IndividualPurchases;
use Matthias\LeanpubApi\Dto\Purchase;

class IndividualPurchasesDeserializer implements DtoDeserializerInterface
{
    public function deserialize($rawData, $format)
    {
        Assertion::same('json', $format, 'No other format is supported');

        $purchases = json_decode($rawData, true);

        $dto = new IndividualPurchases();

        foreach ($purchases as $purchaseArray) {
            $dto->addPurchase($this->createPurchaseFromArray($purchaseArray));
        }

        return $dto;
    }

    /**
     * @param array<string,mixed> $purchaseArray
     */
    private function createPurchaseFromArray(array $purchaseArray)
    {
        $purchase = new Purchase();

        $purchase->setAuthorPaidOutAt(JsonDate::toDateTime($purchaseArray['author_paid_out_at']));
        $purchase->setAuthorRoyalties($purchaseArray['author_royalties']);
        $purchase->setAuthorRoyaltyPercentage($purchaseArray['author_royalty_percentage']);
        $purchase->setCausePaidOutAt(JsonDate::toDateTime($purchaseArray['cause_paid_out_at']));
        $purchase->setCauseRoyalties($purchaseArray['cause_royalties']);
        $purchase->setCauseRoyaltyPercentage($purchaseArray['cause_royalty_percentage']);
        $purchase->setCreatedAt(JsonDate::toDateTime($purchaseArray['created_at']));
        $purchase->setPublisherPaidOutAt(JsonDate::toDateTime($purchaseArray['publisher_paid_out_at']));
        $purchase->setPublisherRoyalties($purchaseArray['publisher_royalties']);
        $purchase->setRoyaltyDaysHold($purchaseArray['royalty_days_hold']);
        $purchase->setAuthorUsername($purchaseArray['author_username']);
        $purchase->setPublisherSlug($purchaseArray['publisher_slug']);
        $purchase->setUserEmail($purchaseArray['user_email']);
        $purchase->setPurchaseUuid($purchaseArray['purchase_uuid']);

        return $purchase;
    }
}
