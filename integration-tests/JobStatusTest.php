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
    public function it_can_wait_until_the_current_job_is_completed(): void
    {
        // Since no job is running, the current job status will be considered "completed"
        self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());

        $this->leanpubApi->startPreview();
        self::assertEventually(
            function () {
                self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());
            }
        );

        // A couple of seconds later the fake_leanpub_server should be "done" generating the preview
        self::assertEventually(
            function () {
                self::assertTrue($this->leanpubApi->getJobStatus()->isComplete());
            },
            10000
        );
    }
}
