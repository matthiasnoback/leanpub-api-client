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

    /**
     * @param string $bookSlug
     * @param integer $page
     * @param string $format
     */
    public function create($bookSlug, $page, $format)
    {
        return new ListAllSalesCall($this->deserializer, $bookSlug, $page, $format);
    }
}
