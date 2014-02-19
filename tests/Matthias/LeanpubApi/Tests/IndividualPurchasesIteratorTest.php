<?php

namespace Matthias\LeanpubApi\Tests;

use Matthias\LeanpubApi\Dto\IndividualPurchases;
use Matthias\LeanpubApi\Dto\Purchase;
use Matthias\LeanpubApi\IndividualPurchasesIterator;

class IndividualPurchasesIteratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_iterates_over_purchases_in_a_collection_and_fetches_new_collections()
    {
        $apiClient = $this->createMockApiClient();

        $purchase1Page1 = new Purchase();
        $purchase2Page1 = new Purchase();
        $individualPurchasesPage1 = new IndividualPurchases();
        $individualPurchasesPage1->addPurchase($purchase1Page1);
        $individualPurchasesPage1->addPurchase($purchase2Page1);

        $apiCall1 = $this->createMockApiCall();
        $listAllSalesCallFactory = $this->createMockListAllSalesCallFactory();

//        $listAllSalesCallFactory
//            ->expects($this->any())
//            ->method('create')
//            ->will($this->returnCallback(function() {
//                        var_dump(func_get_args()); exit;
//                    }));

        $listAllSalesCallFactory
            ->expects($this->at(0))
            ->method('create')
            ->with('book-slug', 1, 'json')
            ->will($this->returnValue($apiCall1));

        $apiClient
            ->expects($this->at(0))
            ->method('callApi')
            ->with($this->identicalTo($apiCall1))
            ->will($this->returnValue($individualPurchasesPage1));

        $purchase1Page2 = new Purchase();
        $purchase2Page2 = new Purchase();
        $individualPurchasesPage2 = new IndividualPurchases();
        $individualPurchasesPage2->addPurchase($purchase1Page2);
        $individualPurchasesPage2->addPurchase($purchase2Page2);

        $apiCall2 = $this->createMockApiCall();
        $listAllSalesCallFactory
            ->expects($this->at(1))
            ->method('create')
            ->with('book-slug', 2, 'json')
            ->will($this->returnValue($apiCall2));

        $apiClient
            ->expects($this->at(1))
            ->method('callApi')
            ->with($this->identicalTo($apiCall2))
            ->will($this->returnValue($individualPurchasesPage2));

        $apiCall3 = $this->createMockApiCall();
        $listAllSalesCallFactory
            ->expects($this->at(2))
            ->method('create')
            ->with('book-slug', 3, 'json')
            ->will($this->returnValue($apiCall3));

        $apiClient
            ->expects($this->at(2))
            ->method('callApi')
            ->with($this->identicalTo($apiCall3))
            ->will($this->returnValue(new IndividualPurchases()));

        $iterator = new IndividualPurchasesIterator($apiClient, $listAllSalesCallFactory, 'book-slug');

        $actualResult = iterator_to_array(new \RecursiveIteratorIterator($iterator), false);

        $this->assertSame(array(
            $purchase1Page1,
            $purchase2Page1,
            $purchase1Page2,
            $purchase2Page2,
        ), $actualResult);
    }

    private function createMockApiClient()
    {
        return $this->getMock('Matthias\LeanpubApi\Client\ClientInterface');
    }

    private function createMockListAllSalesCallFactory()
    {
        return $this
            ->getMockBuilder('Matthias\LeanpubApi\Call\ListAllSalesCallFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('create'))
            ->getMock();
    }

    private function createMockApiCall()
    {
        return $this->getMock('Matthias\LeanpubApi\Call\ApiCallInterface');
    }
}
