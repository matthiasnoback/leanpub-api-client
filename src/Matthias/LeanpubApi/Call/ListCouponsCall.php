<?php

namespace Matthias\LeanpubApi\Call;

use Assert\Assertion;
use Matthias\LeanpubApi\Serializer\CouponsDeserializer;

class ListCouponsCall extends AbstractCall
{
    public function __construct($bookSlug, $format = 'json')
    {
        $this->setBookSlug($bookSlug);
        $this->setFormat($format);
    }

    public function getMethod()
    {
        return 'GET';
    }

    public function getPath()
    {
        return sprintf('/%s/coupons.%s', $this->bookSlug, $this->format);
    }

    public function getQuery()
    {
        return array();
    }

    public function getHeaders()
    {
        return array();
    }

    public function getBody()
    {
        return null;
    }

    public function createResponseDto($responseBody)
    {
        $deserializer = new CouponsDeserializer();

        return $deserializer->deserialize($responseBody, $this->format);
    }
}
