<?php
declare(strict_types=1);

namespace LeanpubApi\Console;

use Symfony\Component\Console\Application;

final class LeanpubApplication extends Application
{
    public function __construct()
    {
        parent::__construct('Leanpub API client', 'UNKNOWN');

        $this->addCommands(
            [
                new GeneratePreviewCommand(),
                new PublishCommand(),
                new CreateCouponCommand()
            ]
        );
    }
}
