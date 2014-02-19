<?php

namespace Matthias\LeanpubApi\Call;

use Matthias\LeanpubApi\Serializer\DtoDeserializerInterface;

class ListCouponsCall extends AbstractCall
{
    private $deserializer;

    public function __construct(DtoDeserializerInterface $deserializer, $bookSlug, $format)
    {
        $this->setBookSlug($bookSlug);
        $this->setFormat($format);
        $this->deserializer = $deserializer;
    }

    public function getMethod()
    {
        return 'GET';
    }

    public function getPath()
    {
        return sprintf('/%s/coupons.%s', $this->bookSlug, $this->format);
    }

    public function createResponseDto($responseBody)
    {
        return $this->deserializer->deserialize($responseBody, $this->format);
    }
}
