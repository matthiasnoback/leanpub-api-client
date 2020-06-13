<?php
declare(strict_types=1);

namespace LeanpubApi\JobStatus;

interface GetJobStatus
{
    public function getJobStatus(): JobStatus;
}
