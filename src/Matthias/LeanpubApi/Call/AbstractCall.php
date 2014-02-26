<?php

namespace Matthias\LeanpubApi\Call;

use Assert\Assertion;

abstract class AbstractCall implements ApiCallInterface
{
    protected $format;
    protected $bookSlug;

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

    /**
     * @param string $bookSlug
     */
    protected function setBookSlug($bookSlug)
    {
        Assertion::string($bookSlug);
        Assertion::notEmpty($bookSlug);

        $this->bookSlug = $bookSlug;
    }

    /**
     * @param string $format
     */
    protected function setFormat($format)
    {
        Assertion::inArray($format, array('json', 'xml'));

        $this->format = $format;
    }
}
