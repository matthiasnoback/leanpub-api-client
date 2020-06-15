<?php
declare(strict_types=1);

namespace LeanpubApi\Publish;

interface Publish
{
    /**
     * @throws CouldNotPublishNewVersion
     */
    public function publishNewVersion(): void;

    /**
     * @throws CouldNotPublishNewVersion
     */
    public function publishNewVersionAndEmailReaders(string $emailMessage): void;
}
