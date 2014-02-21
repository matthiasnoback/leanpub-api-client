<?php

namespace Matthias\LeanpubApi\Call;

interface ApiCallInterface
{
    public function getMethod();

    public function getPath();

    public function getQuery();

    public function getHeaders();

    public function getBody();

    /**
     * @param string
     */
    public function createResponseDto($responseBody);
}
