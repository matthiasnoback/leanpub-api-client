<?php

namespace Matthias\LeanpubApi\Serializer;

use Matthias\LeanpubApi\Dto\DtoInterface;

interface DtoSerializerInterface
{
    public function serialize(DtoInterface $dto, $format);
}
