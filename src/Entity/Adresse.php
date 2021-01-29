<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genderUser;

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
    private $adresse2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postBox;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appartmentNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuntry;

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

    public function getAdresseTitle(): ?string
    {
        return $this->adresseTitle;
    }

    public function setAdresseTitle(?string $adresseTitle): self
    {
        $this->adresseTitle = $adresseTitle;

        return $this;
    }

    public function getGenderUser(): ?string
    {
        return $this->genderUser;
    }

    public function setGenderUser(?string $genderUser): self
    {
        $this->genderUser = $genderUser;

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

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    public function getPostBox(): ?string
    {
        return $this->postBox;
    }

    public function setPostBox(?string $postBox): self
    {
        $this->postBox = $postBox;

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

    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    public function setPostCode(?int $postCode): self
    {
        $this->postCode = $postCode;

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

    public function getCuntry(): ?string
    {
        return $this->cuntry;
    }

    public function setCuntry(?string $cuntry): self
    {
        $this->cuntry = $cuntry;

        return $this;
    }
}
