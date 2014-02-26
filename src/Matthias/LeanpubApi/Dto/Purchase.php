<?php

namespace Matthias\LeanpubApi\Dto;

class Purchase
{
    private $authorPaidOutAt;
    private $authorRoyalties;
    private $authorRoyaltyPercentage;
    private $causePaidOutAt;
    private $causeRoyalties;
    private $causeRoyaltyPercentage;
    private $createdAt;
    private $publisherPaidOutAt;
    private $publisherRoyalties;
    private $royaltyDaysHold;
    private $authorUsername;
    private $publisherSlug;
    private $userEmail;
    private $purchaseUuid;

    public function setAuthorPaidOutAt(\DateTime $authorPaidOutAt = null)
    {
        $this->authorPaidOutAt = $authorPaidOutAt;
    }

    public function getAuthorPaidOutAt()
    {
        return $this->authorPaidOutAt;
    }

    /**
     * @param float $authorRoyalties
     */
    public function setAuthorRoyalties($authorRoyalties)
    {
        $this->authorRoyalties = (float) $authorRoyalties;
    }

    public function getAuthorRoyalties()
    {
        return $this->authorRoyalties;
    }

    /**
     * @param float $authorRoyaltyPercentage
     */
    public function setAuthorRoyaltyPercentage($authorRoyaltyPercentage)
    {
        $this->authorRoyaltyPercentage = (float) $authorRoyaltyPercentage;
    }

    public function getAuthorRoyaltyPercentage()
    {
        return $this->authorRoyaltyPercentage;
    }

    /**
     * @param string $authorUsername
     */
    public function setAuthorUsername($authorUsername)
    {
        $this->authorUsername = (string) $authorUsername;
    }

    public function getAuthorUsername()
    {
        return $this->authorUsername;
    }

    public function setCausePaidOutAt(\DateTime $causePaidOutAt = null)
    {
        $this->causePaidOutAt = $causePaidOutAt;
    }

    public function getCausePaidOutAt()
    {
        return $this->causePaidOutAt;
    }

    /**
     * @param float $causeRoyalties
     */
    public function setCauseRoyalties($causeRoyalties)
    {
        $this->causeRoyalties = (float) $causeRoyalties;
    }

    public function getCauseRoyalties()
    {
        return $this->causeRoyalties;
    }

    /**
     * @param float $causeRoyaltyPercentage
     */
    public function setCauseRoyaltyPercentage($causeRoyaltyPercentage)
    {
        $this->causeRoyaltyPercentage = (float) $causeRoyaltyPercentage;
    }

    public function getCauseRoyaltyPercentage()
    {
        return $this->causeRoyaltyPercentage;
    }

    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setPublisherPaidOutAt(\DateTime $publisherPaidOutAt = null)
    {
        $this->publisherPaidOutAt = $publisherPaidOutAt;
    }

    public function getPublisherPaidOutAt()
    {
        return $this->publisherPaidOutAt;
    }

    /**
     * @param float $publisherRoyalties
     */
    public function setPublisherRoyalties($publisherRoyalties)
    {
        $this->publisherRoyalties = (float) $publisherRoyalties;
    }

    public function getPublisherRoyalties()
    {
        return $this->publisherRoyalties;
    }

    /**
     * @param string $publisherSlug
     */
    public function setPublisherSlug($publisherSlug)
    {
        $this->publisherSlug = (string) $publisherSlug;
    }

    public function getPublisherSlug()
    {
        return $this->publisherSlug;
    }

    /**
     * @param string $purchaseUuid
     */
    public function setPurchaseUuid($purchaseUuid)
    {
        $this->purchaseUuid = (string) $purchaseUuid;
    }

    public function getPurchaseUuid()
    {
        return $this->purchaseUuid;
    }

    /**
     * @param integer $royaltyDaysHold
     */
    public function setRoyaltyDaysHold($royaltyDaysHold)
    {
        $this->royaltyDaysHold = (integer) $royaltyDaysHold;
    }

    public function getRoyaltyDaysHold()
    {
        return $this->royaltyDaysHold;
    }

    /**
     * @param string $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = (string) $userEmail;
    }

    public function getUserEmail()
    {
        return $this->userEmail;
    }
}
