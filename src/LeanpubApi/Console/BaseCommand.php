<?php
declare(strict_types=1);

namespace LeanpubApi\Console;

use Assert\Assert;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use LeanpubApi\LeanpubApi;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command
{

    protected function showProgress(LeanpubApi $leanpubApi, InputInterface $input, OutputInterface $output): void
    {
        $jobIsComplete = false;

        $jobStatus = $leanpubApi->getJobStatus();
        ProgressBar::setFormatDefinition('normal', ' %current%/%max% [%bar%] %message%');
        $progressBar = new ProgressBar($output, $jobStatus->total());
        $progressBar->setMessage('Started');

        while (!$jobIsComplete) {
            $jobStatus = $leanpubApi->getJobStatus();

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

    protected function leanpubApi(OutputInterface $output): LeanpubApi
    {
        foreach (['LEANPUB_API_KEY', 'LEANPUB_BOOK_SLUG'] as $environmentVariable) {
            if (!isset($_ENV[$environmentVariable])) {
                throw new RuntimeException('Undefined environment variable: ' . $environmentVariable);
            }
        }

        if (!isset($_ENV['LEANPUB_BASE_URL'])) {
            $_ENV['LEANPUB_BASE_URL'] = 'https://leanpub.com';
        }

        $loggerPlugin = new LoggerPlugin(new ConsoleLogger($output));

        return new LeanpubApi(
            ApiKey::fromString((string)$_ENV['LEANPUB_API_KEY']),
            BookSlug::fromString((string)$_ENV['LEANPUB_BOOK_SLUG']),
            BaseUrl::fromString((string)$_ENV['LEANPUB_BASE_URL']),
            new PluginClient(
                HttpClientDiscovery::find(),
                [$loggerPlugin]
            ),
            MessageFactoryDiscovery::find()
        );
    }
}
