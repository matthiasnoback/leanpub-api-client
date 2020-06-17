<?php
declare(strict_types=1);

namespace IntegrationTests;

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use LeanpubApi\Common\LeanpubApiClient;
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
        $this->leanpubApi = new LeanpubApi(
            new LeanpubApiClient(
                HttpClientDiscovery::find(),
                MessageFactoryDiscovery::find(),
                BaseUrl::fromString((string)$_ENV['LEANPUB_BASE_URL']),
                ApiKey::fromString((string)$_ENV['LEANPUB_API_KEY']),
                BookSlug::fromString((string)$_ENV['LEANPUB_BOOK_SLUG'])
            )
        );
    }
}
