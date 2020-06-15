<?php
declare(strict_types=1);

namespace LeanpubApi\IndividualPurchases;

use Generator;

interface IndividualPurchases
{
    /**
     * Returns all individual purchases, most recent purchases first
     *
     * @return Generator<Purchase>
     */
    public function allIndividualPurchases(): Generator;
}
