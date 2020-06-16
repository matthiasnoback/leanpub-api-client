<?php
declare(strict_types=1);

namespace LeanpubApi\StartPreview;

use RuntimeException;

final class CouldNotStartPreview extends RuntimeException
{
    public static function unknownReason(): self
    {
        return new self(
            'Could not start a preview (reason unknown)'
        );
    }
}
