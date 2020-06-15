<?php
declare(strict_types=1);

namespace LeanpubApi\Console;

use Assert\Assert;
use LeanpubApi\LeanpubApi;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
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
                'Number of seconds between asking job status (>= 5)',
                '5'
            )
            ->addOption(
                'subset',
                null,
                InputOption::VALUE_NONE,
                'Generate a preview based on Subset.txt'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('subset')) {
            $output->writeln('Starting preview of subset...');
            $this->leanpubApi->startPreviewOfSubset();
        } else {
            $output->writeln('Starting preview...');
            $this->leanpubApi->startPreview();
        }

        $jobIsComplete = false;

        $jobStatus = $this->leanpubApi->getJobStatus();
        ProgressBar::setFormatDefinition('normal', ' %current%/%max% [%bar%] %message%');
        $progressBar = new ProgressBar($output, $jobStatus->total());
        $progressBar->setMessage('Started preview');

        while (!$jobIsComplete) {
            $jobStatus = $this->leanpubApi->getJobStatus();

            $progressBar->setProgress($jobStatus->at());
            $progressBar->setMaxSteps($jobStatus->total());
            $progressBar->setMessage($jobStatus->message());

            if ($jobStatus->isComplete()) {
                $progressBar->finish();
                $jobIsComplete = true;
            } else {
                $this->wait($input);
            }
        }
        $output->writeln('');

        $output->writeln('Preview can be found at: ' . $this->leanpubApi->getBookSummary()->pdfPreviewUrl());

        return 0;
    }

    private function wait(InputInterface $input): void
    {
        $sleepOption = $input->getOption('sleep');
        Assert::that($sleepOption)->string();
        $sleep = (int)$sleepOption;
        if ($sleep < 5) {
            throw new RuntimeException('Leanpub allows a minimum interval of 5 seconds between fetching the job status');
        }

        sleep($sleep);
    }
}
