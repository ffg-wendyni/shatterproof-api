<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomPledgeRepository")
 */
class CustomPledge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $pledgeId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer")
     */
    private $likeCount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $body;

    /**
     * @ORM\Column(type="boolean")
     */
    private $approved;

    public function getPledgeId(): ?int
    {
        return $this->pledgeId;
    }

     public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLikeCount(): ?int
    {
        return $this->likeCount;
    }

    public function setLikeCount(int $likeCount): self
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function toArray()
    {
        return [
            'pledgeId' => $this->getPledgeId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'likeCount' => $this->getLikeCount(),
            'body' => $this->getBody(),
            'approved' => $this->getApproved()
        ];
    }
}
