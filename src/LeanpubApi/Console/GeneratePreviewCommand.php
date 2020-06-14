<?php
declare(strict_types=1);

namespace LeanpubApi\Console;

use LeanpubApi\LeanpubApi;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GeneratePreviewCommand extends Command
{
    private LeanpubApi $leanpubApi;

    public function __construct(LeanpubApi $leanpubApi)
    {
        $this->leanpubApi = $leanpubApi;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('generate-preview')
            ->addOption(
                'sleep',
                null,
                InputOption::VALUE_REQUIRED,
                'Number of seconds between asking job status'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TODO allow generating preview of Subset.txt

        $output->writeln('Starting preview...');
        $this->leanpubApi->startPreview();

        $output->writeln('Done');

        $jobIsComplete = false;
        $sleepOption = $input->getOption('sleep');
        $sleep = is_scalar($sleepOption) ? (int)$sleepOption : 5;
        if ($sleep < 5) {
            throw new \RuntimeException('Leanpub allows a minimum interval of 5 seconds between fetching the job status');
        }

        while (!$jobIsComplete) {
            $output->writeln('Fetching job status...');
            $jobStatus = $this->leanpubApi->getJobStatus();

            if ($jobStatus->isComplete()) {
                $jobIsComplete = true;
                $output->writeln('The job is completed');
            } else {
                $output->writeln('The job is not finished yet. Going to sleep now before trying again...');

                sleep($sleep);
            }
        }

        $output->writeln('Preview can be found at: ' . $this->leanpubApi->getBookSummary()->pdfPreviewUrl());

        return 0;
    }
}
