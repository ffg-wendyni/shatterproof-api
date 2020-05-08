<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $zipcode;

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
    private $shareOnMedia;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pledged;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customPledgeLink;


    public function getUserId(): ?int
    {
        return $this->userId;
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
            'userId' => $this->getUserId(),
            'firstName' => $this->getStringField('firstName'),
            'lastName' => $this->getStringField('lastName'),
            'email' => $this->getStringField('email'),
            'zipcode' => $this->getStringField('zipcode'),
            'organization' => $this->getStringField('organization'),
            'newsletterSub' => $this->getBooleanField('newsletterSub'),
            'shareOnMedia' => $this->getBooleanField('shareOnMedia'),
            'pledged' => $this->getBooleanField('pledged'),
            'customPledgeLink' => $this->getStringField('customPledgeLink')
        ];
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
