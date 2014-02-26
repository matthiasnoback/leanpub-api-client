<?php

namespace Matthias\LeanpubApi\Dto;

use Assert\Assertion;

class CreateCoupon implements DtoInterface
{
    /**
     * @var string
     */
    private $couponCode;

    /**
     * @var \DateTime|null
     */
    private $startDate;

    /**
     * @var \DateTime|null
     */
    private $endDate;

    /**
     * @var integer|null
     */
    private $maxUses;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var boolean
     */
    private $suspended;

    /**
     * @var PackageDiscount[]
     */
    private $packageDiscounts = array();

    /**
     * @param string $couponCode
     */
    public function __construct($couponCode, \DateTime $startDate)
    {
        $this->setCouponCode($couponCode);
        $this->setStartDate($startDate);
    }

    /**
     * @param string $couponCode
     */
    public function setCouponCode($couponCode)
    {
        Assertion::notEmpty($couponCode, 'Coupon code can not be empty');

        $this->couponCode = $couponCode;
    }

    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    public function setEndDate(\DateTime $endDate = null)
    {
        $this->endDate = $endDate;
    }

    /**
     * @param integer $maxUses
     */
    public function setMaxUses($maxUses)
    {
        $this->maxUses = $maxUses;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        Assertion::nullOrString($note, 'Note should be null or a string', null);

        $this->note = (string) $note;
    }

    /**
     * @param boolean $suspended
     */
    public function setSuspended($suspended)
    {
        Assertion::boolean($suspended);

        $this->suspended = (boolean) $suspended;
    }

    public function getCouponCode()
    {
        return $this->couponCode;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getMaxUses()
    {
        return $this->maxUses;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function isSuspended()
    {
        return $this->suspended;
    }

    public function addPackageDiscount(PackageDiscount $packageDiscount)
    {
        $this->packageDiscounts[] = $packageDiscount;
    }

    public function getPackageDiscounts()
    {
        return $this->packageDiscounts;
    }
}
