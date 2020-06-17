<?php
declare(strict_types=1);

namespace IntegrationTests;

use Asynchronicity\PHPUnit\Asynchronicity;

final class PublishAndJobStatusTest extends IntegrationTestCase
{
    use Asynchronicity;

    /**
     * @test
     */
    public function it_can_get_the_current_job_status_after_publishing(): void
    {
        // Since no job is running, the current job status will be considered "completed"
        self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());

        $this->leanpubApi->publishNewVersion();

        self::assertEventually(function () {
            self::assertFalse($this->leanpubApi->getJobStatus()->isComplete());
        });

        // A couple of seconds later the fake_leanpub_server should be "done" generating the preview
        self::assertEventually(function () {
            self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());
        });
    }

    /**
     * @test
     */
    public function it_can_get_the_current_job_status_after_publishing_and_emailing_readers(): void
    {
        self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());

        $this->leanpubApi->publishNewVersionAndEmailReaders('Thanks for your support!');

        self::assertEventually(function () {
            self::assertFalse($this->leanpubApi->getJobStatus()->isComplete());
        });

        // A couple of seconds later the fake_leanpub_server should be "done" generating the subset preview
        self::assertEventually(function () {
            self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());
        });
    }
}
