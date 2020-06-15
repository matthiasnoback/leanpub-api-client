<?php
declare(strict_types=1);

namespace IntegrationTests;

use LeanpubApi\IndividualPurchases\Purchase;

final class IndividualPurchasesTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_loads_all_purchases_from_leanpub(): void
    {
        $numberOfPurchases = 0;

        $lastPurchaseDate = null;

        foreach ($this->leanpubApi->allIndividualPurchases() as $purchase) {
            self::assertInstanceOf(Purchase::class, $purchase);
            /** @var Purchase $purchase */

            // Check that invoice ids have the format we expect them to have
            $purchase->invoiceId();

            if ($lastPurchaseDate !== null) {
                // Check that the purchases are sorted by purchase date descending
                self::assertTrue(strcmp($lastPurchaseDate, $purchase->datePurchased()) >= 0);
            }

            $lastPurchaseDate = $purchase->datePurchased();

            $numberOfPurchases++;
        }

        self::assertEquals(3, $numberOfPurchases, 'The API client is supposed to fetch more than one page');
    }
}
