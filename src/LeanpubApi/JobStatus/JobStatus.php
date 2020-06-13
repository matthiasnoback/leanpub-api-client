<?php
declare(strict_types=1);

namespace LeanpubApi\JobStatus;

use LeanpubApi\Common\Mapping;

final class JobStatus
{
    use Mapping;

    private const COMPLETE = 'complete';

    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromJsonDecodedData(array $data): self
    {
        if (empty($data)) {
            return new self(self::COMPLETE);
        }

        return new self(
            self::asString($data, 'status')
        );
    }

    public function isComplete(): bool
    {
        return $this->status === self::COMPLETE;
    }
}
