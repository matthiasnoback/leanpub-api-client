<?php

namespace Matthias\LeanpubApi\Call;

use Assert\Assertion;
use Matthias\LeanpubApi\Serializer\IndividualPurchasesDeserializer;

class ListAllSalesCall extends AbstractCall
{
    private $page;

    public function __construct($bookSlug, $page = 1, $format = 'json')
    {
        $this->setBookSlug($bookSlug);
        $this->setPage($page);
        $this->setFormat($format);
    }

    public function getQuery()
    {
        return array(
            'page' => $this->page
        );
    }

    public function getMethod()
    {
        return 'GET';
    }

    public function getPath()
    {
        return sprintf('/%s/individual_purchases.%s', $this->bookSlug, $this->format);
    }

    private function setPage($page)
    {
        Assertion::integer($page, 'Page number should be an integer');
        Assertion::min($page, 1, 'Page number should be at least 1');

        $this->page = $page;
    }

    public function createResponseDto($responseBody)
    {
        $deserializer = new IndividualPurchasesDeserializer();

        return $deserializer->deserialize($responseBody, $this->format);
    }
}
