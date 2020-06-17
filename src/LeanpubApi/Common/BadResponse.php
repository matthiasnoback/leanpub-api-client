<?php
declare(strict_types=1);

namespace LeanpubApi\Common;

use RuntimeException;

final class BadResponse extends RuntimeException
{
    public static function redirectToLoginPage(ApiKey $apiKey, BookSlug $bookSlug): self
    {
        return new self(
            sprintf(
                'The API client got redirected to the /login page, meaning that API key %s does not give you access to %s',
                $apiKey->asString(),
                $bookSlug->asString()
            )
        );
    }

    public static function invalidJson(string $responseBody): self
    {
        return new self(
            'The API returned invalid JSON: ' . $responseBody
        );
    }

    public static function expectedJsonDecodedDataToBeAnArray(string $responseBody): self
    {
        return new self(
            'Expected the API to return JSON that could be decoded to an array: ' . $responseBody
        );
    }
}
