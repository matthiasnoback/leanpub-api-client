<?php
declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

error_reporting(E_ALL);

if ($_SERVER['REQUEST_URI'] === '/title_page.jpg') {
    header('Content-Type: image/jpg');
    echo file_get_contents(__DIR__ . '/title_page.jpg');
    exit;
}

$bookSlug = $_ENV['LEANPUB_BOOK_SLUG'];

if (!isset($_GET['api_key']) || $_GET['api_key'] !== $_ENV['LEANPUB_API_KEY']) {
    header('Content-Type: text/html');
    echo file_get_contents('redirect.html');
    header('Location: https://leanpub.com/login', true, 302);
    exit;
}

$pathInfo = $_SERVER['REQUEST_URI'];
$requestUriParts = explode('?', $pathInfo);
$pathInfo = (string)reset($requestUriParts);

$previewStartedAtFile = sys_get_temp_dir() . '/preview-started-at';
if (preg_match('#^/' . preg_quote($bookSlug) . '\.json$#', $pathInfo) > 0) {
    header('Content-Type: application/json');
    echo file_get_contents(__DIR__ . '/book-summary.json');
    exit;
} elseif ($pathInfo === '/' . $bookSlug . '/individual_purchases.json') {
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
    file_put_contents($previewStartedAtFile, time());
    header('Content-Type: application/json');
    echo file_get_contents(__DIR__ . '/preview.json');
    exit;
} elseif ($pathInfo === '/' . $bookSlug . '/job_status.json') {
    header('Content-Type: application/json');

    $generatingAPreviewTakesSeconds = 3;

    if (!file_exists($previewStartedAtFile)) {
        echo file_get_contents(__DIR__ . '/no_job.json');
    }
    elseif (time() - (int)file_get_contents($previewStartedAtFile) > $generatingAPreviewTakesSeconds) {
        echo file_get_contents(__DIR__ . '/job_completed.json');
    }
    else {
        echo file_get_contents(__DIR__ . '/job_in_progress.json');
    }

    exit;
}

header("HTTP/1.0 404 Not Found");
echo 'Page not found';
