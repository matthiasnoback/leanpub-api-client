<?php
declare(strict_types=1);

namespace IntegrationTests;

use LeanpubApi\BookSummary\BookSummary;
use LeanpubApi\BookSummary\GetBookSummaryFromLeanpubApi;

/**
 * @group slow
 */
final class GetBookSummaryFromLeanpubApiTest extends IntegrationTestCase
{


    /**
     * @test
     */
    public function it_loads_a_book_summary_from_leanpub(): void
    {
        $getBookSummaryFromLeanpubApi = new GetBookSummaryFromLeanpubApi(
            $this->apiKey,
            $this->baseUrl
        );

        $bookSummary = $getBookSummaryFromLeanpubApi->getBookSummary(
            $this->bookSlug
        );

        self::assertEquals(
            new BookSummary(
                'Advanced Web Application Architecture',
                '',
                'Matthias Noback',
                'http://fake_leanpub_server/title_page.jpg',
                'http://leanpub.com/web-application-architecture',
                'http://leanpub.com/s/oxS20NHbGUnWb4GEJyHYcF.pdf',
                'http://leanpub.com/s/oxS20NHbGUnWb4GEJyHYcF.epub',
                'http://leanpub.com/s/oxS20NHbGUnWb4GEJyHYcF.mobi'
            ),
            $bookSummary
        );
    }
}
