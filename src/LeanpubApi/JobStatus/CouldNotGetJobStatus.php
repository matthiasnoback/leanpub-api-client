<?php
declare(strict_types=1);

namespace LeanpubApi\JobStatus;

use RuntimeException;

final class CouldNotGetJobStatus extends RuntimeException
{
    public static function becauseResponseContainsInvalidJson(string $responseBody): self
    {
        return new self(
            'Could not get job status because response contains invalid JSON: ' . $responseBody
        );
    }
}
