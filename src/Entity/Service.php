<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
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
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $specialPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $mbLimit;

    /**
     * @ORM\Column(type="integer")
     */
    private $msgLimit;

    /**
     * @ORM\Column(type="integer")
     */
    private $talkMinuteLimit;

    /**
     * @ORM\Column(type="integer")
     */
    private $speedMb;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLimited;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="originalService")
     */
    private $orderItems;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ServiceRestriction", mappedBy="service", orphanRemoval=true)
     */
    private $restrictions;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->restrictions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSpecialPrice(): ?float
    {
        return $this->specialPrice;
    }

    public function setSpecialPrice(?float $specialPrice): self
    {
        $this->specialPrice = $specialPrice;

        return $this;
    }

    public function getMbLimit(): ?int
    {
        return $this->mbLimit;
    }

    public function setMbLimit(int $mbLimit): self
    {
        $this->mbLimit = $mbLimit;

        return $this;
    }

    public function getMsgLimit(): ?int
    {
        return $this->msgLimit;
    }

    public function setMsgLimit(int $msgLimit): self
    {
        $this->msgLimit = $msgLimit;

        return $this;
    }

    public function getTalkMinuteLimit(): ?int
    {
        return $this->talkMinuteLimit;
    }

    public function setTalkMinuteLimit(int $talkMinuteLimit): self
    {
        $this->talkMinuteLimit = $talkMinuteLimit;

        return $this;
    }

    public function getSpeedMb(): ?int
    {
        return $this->speedMb;
    }

    public function setSpeedMb(int $speedMb): self
    {
        $this->speedMb = $speedMb;

        return $this;
    }

    public function getIsLimited(): ?bool
    {
        return $this->isLimited;
    }

    public function setIsLimited(bool $isLimited): self
    {
        $this->isLimited = $isLimited;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setOriginalService($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getOriginalService() === $this) {
                $orderItem->setOriginalService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ServiceRestriction[]
     */
    public function getRestrictions(): Collection
    {
        return $this->restrictions;
    }

    public function addRestriction(ServiceRestriction $restriction): self
    {
        if (!$this->restrictions->contains($restriction)) {
            $this->restrictions[] = $restriction;
            $restriction->setService($this);
        }

        return $this;
    }

    public function removeRestriction(ServiceRestriction $restriction): self
    {
        if ($this->restrictions->contains($restriction)) {
            $this->restrictions->removeElement($restriction);
            // set the owning side to null (unless already changed)
            if ($restriction->getService() === $this) {
                $restriction->setService(null);
            }
        }

        return $this;
    }
}
