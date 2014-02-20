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
[{"author_paid_out_at":"2014-02-10T14:07:11Z","author_royalties":"15.0","author_royalty_percentage":"75.0","cause_paid_out_at":"2014-02-14T14:07:11Z","cause_royalties":"5.0","cause_royalty_percentage":"25.0","created_at":"2014-01-02T14:07:11Z","publisher_paid_out_at":null,"publisher_royalties":"0.0","royalty_days_hold":45,"author_username":"matthiasnoback","publisher_slug":"","user_email":"matthiasnoback@gmail.com","purchase_uuid":"1jlxbbEgr6jeQwRSa4ub5c"}]
EOF;

        $actualCollection = $this->individualPurchasesDeserializer->deserialize($responseBody, 'json');
        $this->assertCount(1, $actualCollection);
        $actualPurchases = $actualCollection->getPurchases();
        $actualPurchase = reset($actualPurchases);
        /* @var $actualPurchase Purchase */

        $this->assertEquals(new \DateTime('2014-02-10T14:07:11Z'), $actualPurchase->getAuthorPaidOutAt());
        $this->assertEquals(15, $actualPurchase->getAuthorRoyalties());
        $this->assertEquals(75, $actualPurchase->getAuthorRoyaltyPercentage());
        $this->assertEquals(new \DateTime('2014-02-14T14:07:11Z'), $actualPurchase->getCausePaidOutAt());
        $this->assertEquals(5, $actualPurchase->getCauseRoyalties());
        $this->assertEquals(25, $actualPurchase->getCauseRoyaltyPercentage());
        $this->assertEquals(new \DateTime('2014-01-02T14:07:11Z'), $actualPurchase->getCreatedAt());
        $this->assertSame(null, $actualPurchase->getPublisherPaidOutAt());
        $this->assertEquals(0, $actualPurchase->getPublisherRoyalties());
        $this->assertSame(45, $actualPurchase->getRoyaltyDaysHold());
        $this->assertSame('matthiasnoback', $actualPurchase->getAuthorUsername());
        $this->assertSame(45, $actualPurchase->getRoyaltyDaysHold());
        $this->assertSame('', $actualPurchase->getPublisherSlug());
        $this->assertSame('matthiasnoback@gmail.com', $actualPurchase->getUserEmail());
        $this->assertSame('1jlxbbEgr6jeQwRSa4ub5c', $actualPurchase->getPurchaseUuid());
    }
}
