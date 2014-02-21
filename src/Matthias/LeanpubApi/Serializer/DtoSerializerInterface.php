<?php

namespace Matthias\LeanpubApi\Serializer;

use Matthias\LeanpubApi\Dto\DtoInterface;

interface DtoSerializerInterface
{
    /**
     * @param DtoInterface $dto
     * @param string $format
     * @return string
     */
    public function serialize(DtoInterface $dto, $format);
}
