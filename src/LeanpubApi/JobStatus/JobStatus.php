<?php
declare(strict_types=1);

namespace LeanpubApi\JobStatus;

use LeanpubApi\Common\Mapping;

final class JobStatus
{
    use Mapping;

    private const COMPLETE = 'complete';

    private string $status;
    private string $message;
    private int $at;
    private int $total;

    public function __construct(string $status, string $message, int $at, int $total)
    {
        $this->status = $status;
        $this->message = $message;
        $this->at = $at;
        $this->total = $total;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromJsonDecodedData(array $data): self
    {
        if (empty($data)) {
            return new self(self::COMPLETE, 'There is no job', 0, 0);
        }

        return new self(
            self::asString($data, 'status'),
            self::asString($data, 'message'),
            self::asInt($data, 'at'),
            self::asInt($data, 'total')
        );
    }

    public function isComplete(): bool
    {
        return $this->status === self::COMPLETE;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function at(): int
    {
        return $this->at;
    }

    public function total(): int
    {
        return $this->total;
    }
}
