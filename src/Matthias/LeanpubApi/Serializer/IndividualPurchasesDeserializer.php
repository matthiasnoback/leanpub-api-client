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

    private function createPurchaseFromArray(array $purchaseArray)
    {
        $purchase = new Purchase();
        $purchase->setId($purchaseArray['purchase_uuid']);

        return $purchase;
    }
}
