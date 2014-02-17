<?php

namespace Matthias\LeanpubApi\Client;

use Matthias\LeanpubApi\Call\ApiCallInterface;

interface ClientInterface
{
    public function callApi(ApiCallInterface $apiCall);
}
