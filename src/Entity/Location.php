<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $locationId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $zipcode;

     /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="location")
     */
    private $users;

    public function getLocationId(): ?int
    {
        return $this->locationId;
    }

    
    public function getStringField($field): ?string
    {
        return $this->$field;
    }

    public function toArray()
    {
        return [
            'locationId' => $this->getLocationId(),
            'street1' => $this->getStringField('street1'),
            'street2' => $this->getStringField('street2'),
            'state' => $this->getStringField('state'),
            'country' => $this->getStringField('country'),
            'zipcode' => $this->getStringField('zipcode')
        ];
    }

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection|User[]]
     */
    public function getLocationUsers(): Collection
    {
        return $this->users;
    }

    public function setStringField(String $field, String $value)
    {
        $this->$field = $value;
    }
}
