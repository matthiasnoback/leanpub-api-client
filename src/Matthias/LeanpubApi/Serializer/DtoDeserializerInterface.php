<?php

namespace Matthias\LeanpubApi\Serializer;

interface DtoDeserializerInterface
{
    public function deserialize($rawData, $format);
}
