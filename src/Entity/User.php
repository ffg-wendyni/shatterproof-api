<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Location;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $gender;

    /**
     * @ORM\Column(type="date")
     */
    private $dob;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $ethnicity;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $occupation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $organization;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletterSub;

    /**
     * @ORM\Column(type="boolean")
     */
    private $textAlertSub;

    /**
     * @ORM\Column(type="boolean")
     */
    private $shareOnMedia;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pledged;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customPledgeLink;

    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="users")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="location_id")
     */
    private $location;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getUserLocation(): ?array
    {
        return $this->location->toArray();
    }

    public function getStringField($field): ?string
    {
        return $this->$field;
    }

    public function getDateField($field): ?string
    {
        $date = $this->$field;
        return $date->format('Y-m-j');
    }

    public function getBooleanField($field): ?bool
    {
        return $this->$field;
    }

    public function toArray()
    {
        return [

            'userInfo' => [
                'userId' => $this->getUserId(),
                'firstName' => $this->getStringField('firstName'),
                'lastName' => $this->getStringField('lastName'),
                'email' => $this->getStringField('email'),
                'phone' => $this->getStringField('phone'),
                'gender' => $this->getStringField('gender'),
                'dob' => $this->getDateField('dob'),
                'ethnicity' => $this->getStringField('ethnicity'),
                'occupation' => $this->getStringField('occupation'),
                'organization' => $this->getStringField('organization'),
                'newsletterSub' => $this->getBooleanField('newsletterSub'),
                'textAlertSub' => $this->getBooleanField('textAlertSub'),
                'shareOnMedia' => $this->getBooleanField('shareOnMedia'),
                'pledged' => $this->getBooleanField('pledged'),
                'customPledgeLink' => $this->getStringField('customPledgeLink')
            ],
            'addressInfo' => $this->getUserLocation()
        ];
    }

    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    public function setStringField(String $field, String $value)
    {
        $this->$field = $value;
    }

    public function setDateField(String $field, String $value)
    {
        $value = DateTime::createFromFormat('Y-m-j', $value);
        $this->$field = $value;
    }

    public function setBooleanField(String $field, String $value)
    {
        $this->$field = $value;
    }
}
