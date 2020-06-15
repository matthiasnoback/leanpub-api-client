<?php
declare(strict_types=1);

namespace IntegrationTests;

use Asynchronicity\PHPUnit\Asynchronicity;

final class JobStatusTest extends IntegrationTestCase
{
    use Asynchronicity;

    /**
     * @test
     */
    public function it_can_get_the_current_job_status_after_starting_a_full_preview(): void
    {
        // Since no job is running, the current job status will be considered "completed"
        self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());

        $this->leanpubApi->startPreview();

        self::assertEventually(function () {
            self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());
        });

        // A couple of seconds later the fake_leanpub_server should be "done" generating the preview
        self::assertEventually(function () {
            self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());
        });
    }

    /**
     * @test
     */
    public function it_can_get_the_current_job_status_after_starting_a_preview_of_the_subset(): void
    {
        self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());

        $this->leanpubApi->startPreviewOfSubset();

        self::assertEventually(function () {
            self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());
        });

        // A couple of seconds later the fake_leanpub_server should be "done" generating the subset preview
        self::assertEventually(function () {
            self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());
        });
    }
}
