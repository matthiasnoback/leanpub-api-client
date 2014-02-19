<?php

namespace Matthias\LeanpubApi\Tests\Serializer;

use Matthias\LeanpubApi\Dto\IndividualPurchases;
use Matthias\LeanpubApi\Dto\Purchase;
use Matthias\LeanpubApi\Serializer\IndividualPurchasesDeserializer;

class IndividualPurchasesDeserializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IndividualPurchasesDeserializer
     */
    private $individualPurchasesDeserializer;

    protected function setUp()
    {
        $this->individualPurchasesDeserializer = new IndividualPurchasesDeserializer();
    }

    /**
     * @test
     */
    public function it_fails_when_format_is_not_json()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->individualPurchasesDeserializer->deserialize('body', 'xml');
    }

    /**
     * @test
     */
    public function it_deserializes_a_collection_of_invididual_purchases()
    {
        $responseBody = <<<EOF
[{
    "purchase_uuid": "the-purchase-uuid"
}]
EOF;

        $individualPurchases = new IndividualPurchases();
        $purchase = new Purchase();
        $purchase->setId('the-purchase-uuid');
        $individualPurchases->addPurchase($purchase);

        $actualCollection = $this->individualPurchasesDeserializer->deserialize($responseBody, 'json');

        $this->assertEquals($individualPurchases, $actualCollection);
    }
}
