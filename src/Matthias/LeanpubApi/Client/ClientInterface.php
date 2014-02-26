<?php

namespace Matthias\LeanpubApi\Client;

use Matthias\LeanpubApi\Call\ApiCallInterface;

interface ClientInterface
{
    /**
     * Return the result of calling the API, for instance a DTO, or null
     *
     * @return mixed
     */
    public function callApi(ApiCallInterface $apiCall);
}
