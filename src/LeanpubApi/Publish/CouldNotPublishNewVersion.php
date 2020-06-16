<?php
declare(strict_types=1);

namespace LeanpubApi\Publish;

use RuntimeException;

final class CouldNotPublishNewVersion extends RuntimeException
{
    public static function unknownReason(): self
    {
        return new self(
            'Could not publish a new version (reason unknown)'
        );
    }
}
