<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
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
     * @ORM\OneToMany(targetEntity="App\Entity\ContactInfo", mappedBy="city")
     */
    private $contactInfos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ServiceRestriction", mappedBy="cities")
     */
    private $serviceRestrictions;

    public function __construct()
    {
        $this->contactInfos = new ArrayCollection();
        $this->serviceRestrictions = new ArrayCollection();
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

    /**
     * @return Collection|ContactInfo[]
     */
    public function getContactInfos(): Collection
    {
        return $this->contactInfos;
    }

    public function addContactInfo(ContactInfo $contactInfo): self
    {
        if (!$this->contactInfos->contains($contactInfo)) {
            $this->contactInfos[] = $contactInfo;
            $contactInfo->setCity($this);
        }

        return $this;
    }

    public function removeContactInfo(ContactInfo $contactInfo): self
    {
        if ($this->contactInfos->contains($contactInfo)) {
            $this->contactInfos->removeElement($contactInfo);
            // set the owning side to null (unless already changed)
            if ($contactInfo->getCity() === $this) {
                $contactInfo->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ServiceRestriction[]
     */
    public function getServiceRestrictions(): Collection
    {
        return $this->serviceRestrictions;
    }

    public function addServiceRestriction(ServiceRestriction $serviceRestriction): self
    {
        if (!$this->serviceRestrictions->contains($serviceRestriction)) {
            $this->serviceRestrictions[] = $serviceRestriction;
            $serviceRestriction->addCity($this);
        }

        return $this;
    }

    public function removeServiceRestriction(ServiceRestriction $serviceRestriction): self
    {
        if ($this->serviceRestrictions->contains($serviceRestriction)) {
            $this->serviceRestrictions->removeElement($serviceRestriction);
            $serviceRestriction->removeCity($this);
        }

        return $this;
    }
}
