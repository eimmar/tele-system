<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use \FOS\UserBundle\Model\User as FOSUser;

/**
 * Class User
 * @InheritanceType("SINGLE_TABLE")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user")
 */
class User extends FOSUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;
    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isIndividual;

    /**
     * @ORM\Column(type="float")
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $workSinceDate;

    /**
     * @ORM\Column(type="float")
     */
    private $additionalCompensation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="user")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MessageRequest", mappedBy="user")
     */
    private $messageRequests;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBlocked;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateUpdated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastVisitDate;

    public function __construct()
    {
        parent::__construct();
        $this->orders = new ArrayCollection();
        $this->messageRequests = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getFirstName();
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

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getIsIndividual(): ?bool
    {
        return $this->isIndividual;
    }

    public function setIsIndividual(bool $isIndividual): self
    {
        $this->isIndividual = $isIndividual;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getWorkSinceDate(): ?\DateTimeInterface
    {
        return $this->workSinceDate;
    }

    public function setWorkSinceDate(?\DateTimeInterface $workSinceDate): self
    {
        $this->workSinceDate = $workSinceDate;

        return $this;
    }

    public function getAdditionalCompensation(): ?float
    {
        return $this->additionalCompensation;
    }

    public function setAdditionalCompensation(float $additionalCompensation): self
    {
        $this->additionalCompensation = $additionalCompensation;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

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
            $messageRequest->setUser($this);
        }

        return $this;
    }

    public function removeMessageRequest(MessageRequest $messageRequest): self
    {
        if ($this->messageRequests->contains($messageRequest)) {
            $this->messageRequests->removeElement($messageRequest);
            // set the owning side to null (unless already changed)
            if ($messageRequest->getUser() === $this) {
                $messageRequest->setUser(null);
            }
        }

        return $this;
    }

    public function getIsBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    public function getLastVisitDate(): ?\DateTimeInterface
    {
        return $this->lastVisitDate;
    }

    public function setLastVisitDate(\DateTimeInterface $lastVisitDate): self
    {
        $this->lastVisitDate = $lastVisitDate;

        return $this;
    }
}
