<?php
declare(strict_types=1);

namespace IntegrationTests;

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use LeanpubApi\LeanpubApi;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    /**
     * @var LeanpubApi
     */
    protected LeanpubApi $leanpubApi;

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

        $this->leanpubApi = new LeanpubApi(
            ApiKey::fromString((string)$_ENV['LEANPUB_API_KEY']),
            BookSlug::fromString((string)$_ENV['LEANPUB_BOOK_SLUG']),
            BaseUrl::fromString((string)$_ENV['LEANPUB_BASE_URL']),
            HttpClientDiscovery::find(),
            MessageFactoryDiscovery::find()
        );
    }
}
