<?php

namespace Rest\ApiBundle\Traits\Entity;

use Symfony\Component\Validator\Constraints as Assert;

trait NameTrait
{
    /**
     * @var string
     *
     * @Assert\NotBlank(message="rest_api.name.blank")
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
