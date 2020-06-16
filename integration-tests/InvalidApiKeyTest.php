<?php
declare(strict_types=1);

namespace IntegrationTests;

use LeanpubApi\Common\BadResponse;

final class InvalidApiKeyTest extends IntegrationTestCase
{
    /**
     * @var mixed
     */
    private $actualLeanpubApiKey;

    protected function setUp(): void
    {
        $this->actualLeanpubApiKey = $_ENV['LEANPUB_API_KEY'];
        $_ENV['LEANPUB_API_KEY'] = 'invalid_key';

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $_ENV['LEANPUB_API_KEY'] = $this->actualLeanpubApiKey;
    }

    /**
     * @test
     */
    public function it_considers_a_redirect_to_the_login_page_to_be_a_sign_that_the_api_key_was_invalid(): void
    {
        $this->expectException(BadResponse::class);
        $this->expectExceptionMessage('redirected to the /login page');

        // make any call
        $this->leanpubApi->getBookSummary();
    }
}
