<?php

namespace Matthias\LeanpubApi\Call;

use Matthias\LeanpubApi\Serializer\DtoDeserializerInterface;

class ListAllSalesCallFactory
{
    private $deserializer;

    public function __construct(DtoDeserializerInterface $deserializer)
    {
        $this->deserializer = $deserializer;
    }

    public function create($bookSlug, $page, $format)
    {
        return new ListAllSalesCall($this->deserializer, $bookSlug, $page, $format);
    }
}
