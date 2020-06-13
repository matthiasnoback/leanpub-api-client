<?php
declare(strict_types=1);

namespace IntegrationTests;

use LeanpubApi\BookSummary\BookSummary;

final class GetBookSummaryTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_loads_a_book_summary_from_leanpub(): void
    {
        $bookSummary = $this->leanpubApi->getBookSummary();

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
