<?php

namespace Matthias\LeanpubApi\Validator;

use Matthias\LeanpubApi\Dto\DtoInterface;

interface DtoValidatorInterface
{
    public function validate(DtoInterface $dto);
}
