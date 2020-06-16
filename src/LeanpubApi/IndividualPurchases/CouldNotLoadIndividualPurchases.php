<?php
declare(strict_types=1);

namespace LeanpubApi\IndividualPurchases;

use RuntimeException;

final class CouldNotLoadIndividualPurchases extends RuntimeException
{
    public static function becauseJsonDataStructureIsInvalid(string $jsonData): self
    {
        return new self(
            sprintf(
                'Could not create Purchase DTOs because the provided JSON data does not have the expected structure: %s',
                $jsonData
            )
        );
    }
}
