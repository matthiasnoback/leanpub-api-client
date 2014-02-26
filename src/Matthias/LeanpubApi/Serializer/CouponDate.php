<?php

namespace Matthias\LeanpubApi\Serializer;

class CouponDate
{
    /**
     * @return null|string
     */
    public static function fromDateTime(\DateTime $date = null)
    {
        if ($date === null) {
            return null;
        }

        return $date->format('Y-m-d');
    }

    /**
     * @param string|null $couponDate
     * @return null|\DateTime
     */
    public static function toDateTime($couponDate)
    {
        if ($couponDate === null) {
            return null;
        }

        return new \DateTime($couponDate);
    }
}
