<?php

namespace Matthias\LeanpubApi\Call;

interface ApiCallInterface
{
    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return array
     */
    public function getQuery();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return string|null
     */
    public function getBody();

    /**
     * @param string
     * @return mixed
     */
    public function createResponseDto($responseBody);
}
