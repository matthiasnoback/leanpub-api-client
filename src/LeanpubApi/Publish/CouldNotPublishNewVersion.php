<?php
declare(strict_types=1);

namespace LeanpubApi\Publish;

final class CouldNotPublishNewVersion extends \RuntimeException
{
    public static function unknownReason(): self
    {
        return new self(
            'Could not publish a new version (reason unknown)'
        );
    }

    public static function invalidJsonResponse(string $responseBody): self
    {
        return new self(
            'Could not publish a new version; invalid JSON returned: ' . $responseBody
        );
    }
}
