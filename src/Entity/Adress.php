<?php

namespace App\Entity;

use App\Repository\AdressRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @ORM\Entity(repositoryClass=AdressRepository::class)
 */
class Adress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idProfil;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adressTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zipCode=null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appartmentNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="boolean")
     */
    private $defaultAdress;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProfil(): ?int
    {
        return $this->idProfil;
    }

    public function setIdProfil(?string $idProfil): self
    {
        $this->idProfil = $idProfil;

        return $this;
    }

    public function getAdressTitle(): string
    {
        return $this->adressTitle;
    }

    public function setAdressTitle(string $adressTitle): self
    {
        $this->adressTitle = $adressTitle;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
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

    public function getCompanie(): ?string
    {
        return $this->companie;
    }

    public function setCompanie(?string $companie): self
    {
        $this->companie = $companie;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getAdress2(): ?string
    {
        return $this->adress2;
    }

    public function setAdress2(?string $adress2): self
    {
        $this->adress2 = $adress2;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    /**
     * @return int|null
     */
    public function setZipCode(?int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getAppartmentNumber(): ?string
    {
        return $this->appartmentNumber;
    }

    public function setAppartmentNumber(?string $appartmentNumber): self
    {
        $this->appartmentNumber = $appartmentNumber;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(?string $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDefaultAdress(): ?bool
    {
        return $this->defaultAdress;
    }

    public function setDefaultAdress(?bool $defaultAdress): self
    {
        $this->defaultAdress = $defaultAdress;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(?bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }
}
