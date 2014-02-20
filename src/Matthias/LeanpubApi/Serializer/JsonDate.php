<?php

namespace Matthias\LeanpubApi\Serializer;

class JsonDate
{
    public static function fromDateTime(\DateTime $date = null)
    {
        if ($date === null) {
            return null;
        }

        return $date->format('c');
    }

    public static function toDateTime($date)
    {
        if ($date === null) {
            return null;
        }

        return new \DateTime($date);
    }
}
