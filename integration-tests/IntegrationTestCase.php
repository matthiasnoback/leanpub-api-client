<?php
declare(strict_types=1);

namespace IntegrationTests;

use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    /**
     * @var ApiKey
     */
    protected ApiKey $apiKey;

    /**
     * @var BookSlug
     */
    protected BookSlug $bookSlug;

    /**
     * @var BaseUrl
     */
    protected BaseUrl $baseUrl;

    protected function setUp(): void
    {
        if (!isset($_ENV['LEANPUB_API_KEY'])) {
            $this->markTestSkipped('LEANPUB_API_KEY environment variable is missing');
        }
        if (!isset($_ENV['LEANPUB_BOOK_SLUG'])) {
            $this->markTestSkipped('LEANPUB_BOOK_SLUG environment variable is missing');
        }
        if (!isset($_ENV['LEANPUB_BASE_URL'])) {
            $this->markTestSkipped('LEANPUB_BASE_URL environment variable is missing');
        }

        $this->apiKey = ApiKey::fromString((string)$_ENV['LEANPUB_API_KEY']);
        $this->bookSlug = BookSlug::fromString((string)$_ENV['LEANPUB_BOOK_SLUG']);
        $this->baseUrl = BaseUrl::fromString((string)$_ENV['LEANPUB_BASE_URL']);
    }
}
