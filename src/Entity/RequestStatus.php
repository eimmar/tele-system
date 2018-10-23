<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RequestStatusRepository")
 */
class RequestStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MessageRequest", mappedBy="status")
     */
    private $messageRequests;

    public function __construct()
    {
        $this->messageRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|MessageRequest[]
     */
    public function getMessageRequests(): Collection
    {
        return $this->messageRequests;
    }

    public function addMessageRequest(MessageRequest $messageRequest): self
    {
        if (!$this->messageRequests->contains($messageRequest)) {
            $this->messageRequests[] = $messageRequest;
            $messageRequest->setStatus($this);
        }

        return $this;
    }

    public function removeMessageRequest(MessageRequest $messageRequest): self
    {
        if ($this->messageRequests->contains($messageRequest)) {
            $this->messageRequests->removeElement($messageRequest);
            // set the owning side to null (unless already changed)
            if ($messageRequest->getStatus() === $this) {
                $messageRequest->setStatus(null);
            }
        }

        return $this;
    }
}
