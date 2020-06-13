<?php
declare(strict_types=1);

namespace LeanpubApi\BookSummary;

use LeanpubApi\Common\BookSlug;

interface GetBookSummary
{
    public function getBookSummary(BookSlug $leanpubBookSlug): BookSummary;
}
