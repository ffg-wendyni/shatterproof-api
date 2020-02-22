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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $phone;

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

    public function toArray()
    {
        return [
            'userId' => $this->getUserId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone()
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
}
