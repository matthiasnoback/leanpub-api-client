# Leanpub API client for PHP

This library contains a PHP implementation of a client that can be used to connect to the [Leanpub
API](https://leanpub.com/help/api). It is *not feature-complete*, but the features that are implemented are implemented
fully and they work correctly.

# Installation

Using [Composer](https://getcomposer.org/), require the ``matthiasnoback/leanpub-api-client`` package.

This package uses the [Guzzle HTTP client](https://guzzle.readthedocs.org/en/latest/) to connect to the Leanpub API.

# Usage

```php
use Matthias\LeanpubApi\LeanpubApiFactory;
use Guzzle\Http\Client;

// your personal API key
$apiKey = ...;

$apiClient = new GuzzleClient(new Client(), $apiKey);
$factory = new LeanpubApiFactory($apiClient);

$leanpubApi = $factory->create();
```

## Get coupons

To get all coupons for a given book:

```php
$bookSlug = 'a-year-with-symfony';

$coupons = $leanpubApi->listCoupons($bookSlug);
```

## Get individual purchases per page

```php
$page = 2;

$individualPurchases = $leanpubApi->listIndividualPurchases($bookSlug, $page);
```

## Get all individual purchases

```php
foreach ($leanpubApi->listAllIndividualPurchases($bookSlug) as $purchase) {
    // iterate over the individual purchases one by one
    ...
}
```

## Create a coupon

```php
use Matthias\LeanpubApi\Dto\CreateCoupon;

$code = '1234abcd';
$startDate = new \DateTime('2014-04-01');
$coupon = new CreateCoupon($code, $startDate);

// configure the DTO some more using its setters
// $coupon->setEndDate(new \DateTime('2015-04-01'));
// ...

$leanpubApi->createCoupon($bookSlug, $coupon);
```
