<?php
declare(strict_types=1);

namespace LeanpubApi\Console;

use RuntimeException;
use function Safe\json_encode;

final class CouldNotCreateCoupon extends RuntimeException
{
    /**
     * @param array<string,mixed> $result
     */
    public static function responseReturnedInternalServerError(array $result): self
    {
        return new self(
            'Could not create the coupon; the server returned an internal server error.'
            . 'This could mean you provided an unknown package slug/ID. Response data: '
            . json_encode($result)
        );
    }

    /**
     * @param array<string,mixed> $result
     */
    public static function responseWasUnsuccessful(array $result): self
    {
        return new self(
            'Could not create the coupon; the response was unsuccessful.'
            . 'This could mean the provided coupon code has already been used before. Response data: '
            . json_encode($result)
        );
    }
}
