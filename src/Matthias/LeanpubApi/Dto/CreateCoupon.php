<?php

namespace Matthias\LeanpubApi\Dto;

class CreateCoupon
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

    public function __construct($couponCode = null, \DateTime $startDate = null)
    {
        $this->setCouponCode($couponCode);

        if ($startDate === null) {
            $startDate = new \DateTime();
        }

        $this->setStartDate($startDate);
    }

    public function setCouponCode($couponCode)
    {
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

    public function setMaxUses($maxUses)
    {
        $this->maxUses = $maxUses;
    }

    public function setNote($note)
    {
        $this->note = (string) $note;
    }

    public function setSuspended($suspended)
    {
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

    public function __clone()
    {
        if ($this->startDate instanceof \DateTime) {
            $this->startDate = clone $this->startDate;
        }

        if ($this->endDate instanceof \DateTime) {
            $this->endDate = clone $this->endDate;
        }

        $clonedPackageDiscounts = array();
        foreach ($this->packageDiscounts as $key => $packageDiscount) {
            $clonedPackageDiscounts[$key] = clone $packageDiscount;
        }
        $this->packageDiscounts = $clonedPackageDiscounts;
    }
}
