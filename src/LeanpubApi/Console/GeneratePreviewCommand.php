<?php
declare(strict_types=1);

namespace LeanpubApi\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GeneratePreviewCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('leanpub:generate-preview')
            ->setDescription('Generate a preview of the book')
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
        $leanpubApi = $this->leanpubApi($output);

        if ($input->getOption('subset')) {
            $output->writeln('Starting preview of subset...');
            $leanpubApi->startPreviewOfSubset();
        } else {
            $output->writeln('Starting preview...');
            $leanpubApi->startPreview();
        }

        $this->showProgress($leanpubApi, $input, $output);

        $output->writeln('Preview can be found at: ' . $leanpubApi->getBookSummary()->pdfPreviewUrl());

        return 0;
    }
}
