<?php
declare(strict_types=1);

namespace LeanpubApi\Console;

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use LeanpubApi\LeanpubApi;
use RuntimeException;
use Symfony\Component\Console\Application;

final class LeanpubApplication extends Application
{
    public function __construct()
    {
        parent::__construct('Leanpub API client', 'UNKNOWN');

        foreach (['LEANPUB_API_KEY', 'LEANPUB_BOOK_SLUG'] as $environmentVariable) {
            if (!isset($_ENV[$environmentVariable])) {
                throw new RuntimeException('Undefined environment variable: ' . $environmentVariable);
            }
        }

        if (!isset($_ENV['LEANPUB_BASE_URL'])) {
            $_ENV['LEANPUB_BASE_URL'] = 'https://leanpub.com';
        }

        $leanpubApi = new LeanpubApi(
            ApiKey::fromString((string)$_ENV['LEANPUB_API_KEY']),
            BookSlug::fromString((string)$_ENV['LEANPUB_BOOK_SLUG']),
            BaseUrl::fromString((string)$_ENV['LEANPUB_BASE_URL']),
            HttpClientDiscovery::find(),
            MessageFactoryDiscovery::find()
        );

        $this->addCommands(
            [
                new GeneratePreviewCommand($leanpubApi)
            ]
        );
    }
}
