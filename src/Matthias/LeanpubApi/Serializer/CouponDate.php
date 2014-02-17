<?php

namespace Matthias\LeanpubApi\Serializer;

class CouponDate
{
    public static function fromDateTime(\DateTime $date = null)
    {
        if ($date === null) {
            return null;
        }

        return $date->format('Y-m-d');
    }

    public static function toDateTime($couponDate)
    {
        return new \DateTime($couponDate);
    }
}
