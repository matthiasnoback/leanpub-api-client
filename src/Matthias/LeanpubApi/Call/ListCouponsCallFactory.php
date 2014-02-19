<?php

namespace Matthias\LeanpubApi\Call;

use Matthias\LeanpubApi\Serializer\DtoDeserializerInterface;

class ListCouponsCallFactory
{
    private $deserializer;

    public function __construct(DtoDeserializerInterface $deserializer)
    {
        $this->deserializer = $deserializer;
    }

    public function create($bookSlug, $format)
    {
        return new ListCouponsCall($this->deserializer, $bookSlug, $format);
    }
}
