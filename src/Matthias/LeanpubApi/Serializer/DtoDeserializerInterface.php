<?php

namespace Matthias\LeanpubApi\Serializer;

interface DtoDeserializerInterface
{
    /**
     * @param string $rawData
     * @param string $format
     * @return object
     */
    public function deserialize($rawData, $format);
}
