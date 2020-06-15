<?php
declare(strict_types=1);

namespace LeanpubApi\StartPreview;

final class CouldNotStartPreview extends \RuntimeException
{
    public static function unknownReason(): self
    {
        return new self(
            'Could not start a preview (reason unknown)'
        );
    }

    public static function invalidJsonResponse(string $responseBody): self
    {
        return new self(
            'Could not start a preview; invalid JSON returned: ' . $responseBody
        );
    }
}
