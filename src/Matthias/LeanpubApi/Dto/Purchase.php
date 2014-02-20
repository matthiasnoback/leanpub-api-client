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

    public function setAuthorRoyalties($authorRoyalties)
    {
        $this->authorRoyalties = (float) $authorRoyalties;
    }

    public function getAuthorRoyalties()
    {
        return $this->authorRoyalties;
    }

    public function setAuthorRoyaltyPercentage($authorRoyaltyPercentage)
    {
        $this->authorRoyaltyPercentage = (float) $authorRoyaltyPercentage;
    }

    public function getAuthorRoyaltyPercentage()
    {
        return $this->authorRoyaltyPercentage;
    }

    public function setAuthorUsername($authorUsername)
    {
        $this->authorUsername = $authorUsername;
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

    public function setCauseRoyalties($causeRoyalties)
    {
        $this->causeRoyalties = (float) $causeRoyalties;
    }

    public function getCauseRoyalties()
    {
        return $this->causeRoyalties;
    }

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

    public function setPublisherRoyalties($publisherRoyalties)
    {
        $this->publisherRoyalties = (float) $publisherRoyalties;
    }

    public function getPublisherRoyalties()
    {
        return $this->publisherRoyalties;
    }

    public function setPublisherSlug($publisherSlug)
    {
        $this->publisherSlug = $publisherSlug;
    }

    public function getPublisherSlug()
    {
        return $this->publisherSlug;
    }

    public function setPurchaseUuid($purchaseUuid)
    {
        $this->purchaseUuid = $purchaseUuid;
    }

    public function getPurchaseUuid()
    {
        return $this->purchaseUuid;
    }

    public function setRoyaltyDaysHold($royaltyDaysHold)
    {
        $this->royaltyDaysHold = (integer) $royaltyDaysHold;
    }

    public function getRoyaltyDaysHold()
    {
        return $this->royaltyDaysHold;
    }

    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function getUserEmail()
    {
        return $this->userEmail;
    }
}
