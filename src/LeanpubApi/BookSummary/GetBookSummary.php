<?php
declare(strict_types=1);

namespace LeanpubApi\BookSummary;

interface GetBookSummary
{
    public function getBookSummary(): BookSummary;
}
