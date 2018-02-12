<?php

namespace Rest\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rest\ApiBundle\Traits\Entity\NameTrait;
use Rest\ApiBundle\Traits\Entity\TimestampTrait;

/**
 * Campaign
 *
 * @ORM\Table(name="campaign")
 * @ORM\Entity(repositoryClass="Rest\ApiBundle\Repository\CampaignRepository")
 */
class Campaign
{
    use NameTrait,
        TimestampTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="campaigns")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="CampaignType", inversedBy="campaigns")
     * @ORM\JoinColumn(name="campaign_type_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $campaignType;

    /**
     * Campaign constructor.
     */
    public function __construct()
    {
        $this->dateCreated = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \Rest\ApiBundle\Entity\User $user
     *
     * @return Campaign
     */
    public function setUser(\Rest\ApiBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Rest\ApiBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set campaignType
     *
     * @param \Rest\ApiBundle\Entity\CampaignType $campaignType
     *
     * @return Campaign
     */
    public function setCampaignType(\Rest\ApiBundle\Entity\CampaignType $campaignType = null)
    {
        $this->campaignType = $campaignType;

        return $this;
    }

    /**
     * Get campaignType
     *
     * @return \Rest\ApiBundle\Entity\CampaignType
     */
    public function getCampaignType()
    {
        return $this->campaignType;
    }
}
