<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 */
class OrderItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTo;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $serviceType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $originalService;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

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

    public function getServiceType(): ?string
    {
        return $this->serviceType;
    }

    public function setServiceType(?string $serviceType): self
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    public function getOriginalService(): ?Service
    {
        return $this->originalService;
    }

    public function setOriginalService(?Service $originalService): self
    {
        $this->originalService = $originalService;

        return $this;
    }

    public function getMainOrder(): ?Order
    {
        return $this->mainOrder;
    }

    public function setMainOrder(?Order $mainOrder): self
    {
        $this->mainOrder = $mainOrder;

        return $this;
    }
}
