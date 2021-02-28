<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $registeredBy;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $registeredAt;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $dateStart;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $dateEnd;

    /** 
    * @ORM\ManyToOne(targetEntity="OperationList", inversedBy="operation")  
    */
    private $operationList;

    /** 
    * @ORM\ManyToOne(targetEntity="Article", inversedBy="operation")  
    */
    private $article;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="operations")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegisteredBy(): ?string
    {
        return $this->registeredBy;
    }

    public function setRegisteredBy(?string $registeredBy): self
    {
        $this->registeredBy = $registeredBy;

        return $this;
    }

    public function getRegisteredAt(): ?DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(DateTimeImmutable $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getDateStart(): ?DateTimeImmutable
    {
        return $this->dateStart;
    }

    public function setDateStart(DateTimeImmutable $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function setDateEnd(DateTimeImmutable $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getOperationList(): ?OperationList
    {
        return $this->operationList;
    }

    public function setOperationList(OperationList $operationList): self
    {
        $this->operationList = $operationList;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

}
