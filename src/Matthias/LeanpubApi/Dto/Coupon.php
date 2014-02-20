<?php

namespace Matthias\LeanpubApi\Dto;

class Coupon
{
    /**
     * @var string
     */
    private $couponCode;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var PackageDiscount[]
     */
    private $packageDiscounts = array();

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
     * @var integer
     */
    private $numUses;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var boolean
     */
    private $suspended;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $bookId;

    public function addPackageDiscount(PackageDiscount $packageDiscount)
    {
        $this->packageDiscounts[] = $packageDiscount;
    }

    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
    }

    public function getBookId()
    {
        return $this->bookId;
    }

    public function setCouponCode($couponCode)
    {
        $this->couponCode = $couponCode;
    }

    public function getCouponCode()
    {
        return $this->couponCode;
    }

    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setEndDate(\DateTime $endDate = null)
    {
        $this->endDate = $endDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setMaxUses($maxUses)
    {
        $this->maxUses = (integer) $maxUses;
    }

    public function getMaxUses()
    {
        return $this->maxUses;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNumUses($numUses)
    {
        $this->numUses = (integer) $numUses;
    }

    public function getNumUses()
    {
        return $this->numUses;
    }

    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setSuspended($suspended)
    {
        $this->suspended = (boolean) $suspended;
    }

    public function isSuspended()
    {
        return $this->suspended;
    }

    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getPackageDiscounts()
    {
        return $this->packageDiscounts;
    }
}
