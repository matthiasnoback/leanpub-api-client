<?php
declare(strict_types=1);

namespace LeanpubApi\StartPreview;

interface StartPreview
{
    public function startPreview(): void;

    public function startPreviewOfSubset(): void;
}
