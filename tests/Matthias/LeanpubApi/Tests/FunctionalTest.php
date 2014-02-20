<?php

namespace Matthias\LeanpubApi\Tests;

use Guzzle\Http\Client;
use Matthias\LeanpubApi\Client\GuzzleClient;
use Matthias\LeanpubApi\Dto\CouponCollection;
use Matthias\LeanpubApi\Dto\CreateCoupon;
use Matthias\LeanpubApi\Dto\IndividualPurchases;
use Matthias\LeanpubApi\Dto\PackageDiscount;
use Matthias\LeanpubApi\Dto\Purchase;
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
        $individualPurchases = $this->leanpubApi->listIndividualPurchases($this->bookSlug, 3);

        $this->assertTrue($individualPurchases instanceof IndividualPurchases);
    }

    /**
     * @test
     */
    public function it_fetches_a_traversable_list_of_all_individual_purchases()
    {
        $loopCount = 0;
        $maxLoopCount = 100;

        foreach ($this->leanpubApi->getAllIndividualPurchases($this->bookSlug) as $purchase) {
            if ($loopCount > $maxLoopCount) {
                break;
            }

            if (!($purchase instanceof Purchase)) {
                $this->fail('Expected to retrieve only instances of Purchase');
            }

            $loopCount++;
        }
    }

    /**
     * @test
     */
    public function it_creates_a_coupon()
    {
        $createCoupon = new CreateCoupon(uniqid(), new \DateTime());
        $createCoupon->setSuspended(true);
        $createCoupon->addPackageDiscount(new PackageDiscount('book', 100));
        $createCoupon->setNote('Coupon created by unit test');

        $this->assertSame(true, $this->leanpubApi->createCoupon($this->bookSlug, $createCoupon));
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
