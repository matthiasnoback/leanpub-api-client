<?php

namespace Matthias\LeanpubApi\Dto;

class Purchase
{
    private $id;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
