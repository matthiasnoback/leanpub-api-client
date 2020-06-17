<?php
declare(strict_types=1);

namespace LeanpubApi\Publish;

use RuntimeException;

final class CouldNotPublishNewVersion extends RuntimeException
{
    /**
     * @param array<mixed> $decodedData
     */
    public static function unknownReason(array $decodedData): self
    {
        return new self(
            'Could not publish a new version (reason unknown). Response: ' . json_encode($decodedData)
        );
    }
}
