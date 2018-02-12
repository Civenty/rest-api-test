<?php

namespace Rest\ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Rest\ApiBundle\Traits\Entity\NameTrait;
use Rest\ApiBundle\Traits\Entity\TimestampTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Rest\ApiBundle\Repository\UserRepository")
 *
 * @UniqueEntity(fields="email", errorPath="email", message="fos_user.email.already_used")
 */
class User extends BaseUser
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
    protected $id;

    /**
     * @Assert\NotBlank(message="fos_user.password.blank")
     */
    protected $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="user")
     */
    private $campaigns;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->dateCreated = new \DateTime();
        $this->campaigns = new ArrayCollection();
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
     * Add campaign
     *
     * @param \Rest\ApiBundle\Entity\Campaign $campaign
     *
     * @return User
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
