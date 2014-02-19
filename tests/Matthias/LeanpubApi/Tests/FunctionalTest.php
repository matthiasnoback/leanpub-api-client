<?php

namespace Matthias\LeanpubApi\Tests;

use Guzzle\Http\Client;
use Matthias\LeanpubApi\Client\GuzzleClient;
use Matthias\LeanpubApi\Dto\CouponCollection;
use Matthias\LeanpubApi\Dto\IndividualPurchases;
use Matthias\LeanpubApi\LeanpubApi;
use Matthias\LeanpubApi\LeanpubApiFactory;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    private $bookSlug;

    /**
     * @var LeanpubApi
     */
    private $leanpubApi;

    protected function setUp()
    {
        $apiKey = $this->getEnvOrSkipTest('LEANPUB_API_KEY');
        $this->bookSlug = $this->getEnvOrSkipTest('LEANPUB_BOOK_SLUG');

        $apiClient = new GuzzleClient(new Client(), $apiKey);

        $leanpubApiFactory = new LeanpubApiFactory($apiClient);

        $this->leanpubApi = $leanpubApiFactory->create();
    }

    /**
     * @test
     */
    public function it_fetches_coupon_codes()
    {
        $couponCollection = $this->leanpubApi->listCoupons($this->bookSlug);

        $this->assertTrue($couponCollection instanceof CouponCollection);
    }

    /**
     * @test
     */
    public function it_fetches_individual_purchases()
    {
        $invidualPurchases = $this->leanpubApi->listIndividualPurchases($this->bookSlug);

        $this->assertTrue($invidualPurchases instanceof IndividualPurchases);
    }

    private function getEnvOrSkipTest($env)
    {
        $value = getenv($env);
        if ($value === false) {
            throw new \PHPUnit_Framework_SkippedTestError(sprintf(
                'No "%s" environment variable was provided',
                $env
            ));
        }

        return $value;
    }
}
