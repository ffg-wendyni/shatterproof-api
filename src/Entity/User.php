<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=255)
     */
    private $ethnicity;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $occupation;

     /**
     * @ORM\Column(type="string", length=10)
     */
    private $newsletterSub;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getFirstName(): ?String
    {
        return $this->firstName;
    }

    public function getLastName(): ?String
    {
        return $this->lastName;
    }

    public function getEmail(): ?String
    {
        return $this->email;
    }

    public function getPhone(): ?String
    {
        return $this->phone;
    }

    public function getGender(): ?String
    {
        return $this->gender;
    }

    public function getEthnicity(): ?String
    {
        return $this->ethnicity;
    }

    public function getOccupation(): ?String
    {
        return $this->occupation;
    }

    public function getNewsletterSub(): ?String
    {
        return $this->newsletterSub;
    }

    public function toArray()
    {
        return [
            'userId' => $this->getUserId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'gender' => $this->getGender(),
            'ethnicity' => $this->getEthnicity(),
            'occupation' => $this->getOccupation(),
            'newsletterSub' => $this->getNewsletterSub()
        ];
    }

    public function setFirstName(String $firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName(String $lastName)
    {
        $this->lastName = $lastName;
    }

    public function setEmail(String $email)
    {
        $this->email = $email;
    }

    public function setPhone(String $phone)
    {
        $this->phone = $phone;
    }

    public function setGender(String $gender)
    {
        $this->gender = $gender;
    }
    
    public function setEthnicity(String $ethnicity)
    {
        $this->ethnicity = $ethnicity;
    }

    public function setOccupation(String $occupation)
    {
        $this->occupation = $occupation;
    }

    public function setNewsletterSub(String $newsletterSub)
    {
        $this->newsletterSub = $newsletterSub;
    }
}
