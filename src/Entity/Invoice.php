<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice
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
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $totalSum;

    /**
     * @ORM\Column(type="integer")
     */
    private $usedMinutes;

    /**
     * @ORM\Column(type="integer")
     */
    private $usedMsg;

    /**
     * @ORM\Column(type="integer")
     */
    private $usedMbs;

    /**
     * @ORM\Column(type="float")
     */
    private $debt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalSum(): ?float
    {
        return $this->totalSum;
    }

    public function setTotalSum(float $totalSum): self
    {
        $this->totalSum = $totalSum;

        return $this;
    }

    public function getUsedMinutes(): ?int
    {
        return $this->usedMinutes;
    }

    public function setUsedMinutes(int $usedMinutes): self
    {
        $this->usedMinutes = $usedMinutes;

        return $this;
    }

    public function getUsedMsg(): ?int
    {
        return $this->usedMsg;
    }

    public function setUsedMsg(int $usedMsg): self
    {
        $this->usedMsg = $usedMsg;

        return $this;
    }

    public function getUsedMbs(): ?int
    {
        return $this->usedMbs;
    }

    public function setUsedMbs(int $usedMbs): self
    {
        $this->usedMbs = $usedMbs;

        return $this;
    }

    public function getDebt(): ?float
    {
        return $this->debt;
    }

    public function setDebt(float $debt): self
    {
        $this->debt = $debt;

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
