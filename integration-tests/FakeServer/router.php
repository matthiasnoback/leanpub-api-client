<?php
declare(strict_types=1);

use Assert\Assert;
use function Safe\json_decode;

require dirname(__DIR__) . '/bootstrap.php';

error_reporting(E_ALL);

if ($_SERVER['REQUEST_URI'] === '/title_page.jpg') {
    header('Content-Type: image/jpg');
    echo file_get_contents(__DIR__ . '/title_page.jpg');
    exit;
}

$bookSlug = $_ENV['LEANPUB_BOOK_SLUG'];

/**
 * @param array<string,null|string> $data
 */
function validateApiKey(array $data): void {
    if (!isset($data['api_key']) || $data['api_key'] !== $_ENV['LEANPUB_API_KEY']) {
        header('Content-Type: text/html');
        header('Location: https://leanpub.com/login', true, 302);
        echo file_get_contents(__DIR__ . '/redirect.html');
        exit;
    }
}

$pathInfo = $_SERVER['REQUEST_URI'];
$requestUriParts = explode('?', $pathInfo);
$pathInfo = (string)reset($requestUriParts);

$jobStartedAtFile = sys_get_temp_dir() . '/job-started-at';
if (preg_match('#^/' . preg_quote($bookSlug) . '\.json$#', $pathInfo) > 0) {
    validateApiKey($_GET);
    header('Content-Type: application/json');
    echo file_get_contents(__DIR__ . '/book-summary.json');
    exit;
} elseif ($pathInfo === '/' . $bookSlug . '/individual_purchases.json') {
    validateApiKey($_GET);
    header('Content-Type: application/json');
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $jsonFile = __DIR__ . '/individual-purchases-page-' . $page . '.json';
    if (!file_exists($jsonFile)) {
        echo file_get_contents(__DIR__ . '/no-more-individual-purchases.json');
    } else {
        echo file_get_contents($jsonFile);
    }
    exit;
} elseif ($pathInfo === '/' . $bookSlug .  '/preview.json'
    && $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_SERVER['HTTP_CONTENT_TYPE']) && $_SERVER['HTTP_CONTENT_TYPE'] === 'application/x-www-form-urlencoded'
) {
    validateApiKey($_POST);
    file_put_contents($jobStartedAtFile, time());
    header('Content-Type: application/json');
    echo file_get_contents(__DIR__ . '/preview.json');
    exit;
} elseif ($pathInfo === '/' . $bookSlug .  '/preview/subset.json'
    && $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_SERVER['HTTP_CONTENT_TYPE']) && $_SERVER['HTTP_CONTENT_TYPE'] === 'application/x-www-form-urlencoded'
) {
    validateApiKey($_POST);
    file_put_contents($jobStartedAtFile, time());
    header('Content-Type: application/json');
    echo file_get_contents(__DIR__ . '/preview.json');
    exit;
} elseif ($pathInfo === '/' . $bookSlug . '/publish.json') {
    validateApiKey($_POST);
    file_put_contents($jobStartedAtFile, time());
    header('Content-Type: application/json');
    echo file_get_contents(__DIR__ . '/publish.json');
    exit;
} elseif ($pathInfo === '/' . $bookSlug . '/job_status.json') {
    validateApiKey($_GET);
    header('Content-Type: application/json');

    $generatingAPreviewTakesSeconds = 3;

    if (!file_exists($jobStartedAtFile)) {
        echo file_get_contents(__DIR__ . '/no_job.json');
    }
    elseif (time() - (int)file_get_contents($jobStartedAtFile) > $generatingAPreviewTakesSeconds) {
        echo file_get_contents(__DIR__ . '/job_completed.json');
    }
    else {
        echo file_get_contents(__DIR__ . '/job_in_progress.json');
    }

    exit;
} elseif ($pathInfo === '/' . $bookSlug . '/coupons.json') {
    validateApiKey($_GET);

    header('Content-Type: application/json');

    $requestBody = file_get_contents('php://input');
    Assert::that($requestBody)->string();
    $decodedData = json_decode($requestBody, true);
    Assert::that($decodedData)->isArray();

    if ($decodedData['coupon']['package_discounts_attributes'][0]['package_slug'] === 'unknown_package_slug') {
        echo file_get_contents(__DIR__ . '/unknown_package_slug.json');
    } elseif ($decodedData['coupon']['coupon_code'] === 'COUPON_CODE_USED_BEFORE') {
        echo file_get_contents(__DIR__ . '/coupon_already_exists.json');
    } else {
        echo file_get_contents(__DIR__ . '/coupon_created.json');
    }
    exit;
}

header("HTTP/1.0 404 Not Found");
echo 'Page not found';
