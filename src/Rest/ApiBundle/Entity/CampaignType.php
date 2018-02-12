<?php

namespace Rest\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rest\ApiBundle\Traits\Entity\NameTrait;
use Rest\ApiBundle\Traits\Entity\TimestampTrait;

/**
 * CampaignType
 *
 * @ORM\Table(name="campaign_type")
 * @ORM\Entity(repositoryClass="Rest\ApiBundle\Repository\CampaignTypeRepository")
 */
class CampaignType
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
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", options={"default": 1})
     */
    private $status = true;

    /**
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="campaignType")
     */
    private $campaigns;

    /**
     * CampaignType constructor.
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
     * Set status
     *
     * @param boolean $status
     *
     * @return CampaignType
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add campaign
     *
     * @param \Rest\ApiBundle\Entity\Campaign $campaign
     *
     * @return CampaignType
     */
    public function addCampaign(\Rest\ApiBundle\Entity\Campaign $campaign)
    {
        $this->campaigns[] = $campaign;

        return $this;
    }

    /**
     * Remove campaign
     *
     * @param \Rest\ApiBundle\Entity\Campaign $campaign
     */
    public function removeCampaign(\Rest\ApiBundle\Entity\Campaign $campaign)
    {
        $this->campaigns->removeElement($campaign);
    }

    /**
     * Get campaigns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCampaigns()
    {
        return $this->campaigns;
    }
}
