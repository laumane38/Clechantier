<?php

namespace App\Entity;

use DateTime;
use App\Repository\OperationRepository;
use App\Repository\UserRepository;
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
    * @ORM\ManyToOne(targetEntity="User", inversedBy="registeredBy")
     */
    private $registeredBy;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private DateTime $registeredAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private DateTime $dateStart;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private DateTime $dateEnd;

    /** 
    * @ORM\ManyToOne(targetEntity="OperationList", inversedBy="operation")  
    */
    private $operationList;

    /** 
    * @ORM\ManyToOne(targetEntity="Article", inversedBy="operation")  
    */
    private $article;

    /**
     * @ORM\ManyToMany(targetEntity=Collaborater::class, inversedBy="operations")
     */
    private $collaborater;

    public function __construct()
    {
        $this->collaborater = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegisteredBy(): ?User
    {
        return $this->registeredBy;
    }

    public function setRegisteredBy(?User $registeredBy): self
    {
        $this->registeredBy = $registeredBy;

        return $this;
    }

    public function getRegisteredAt(): ?DateTime
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(DateTime $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getDateStart(): ?DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(DateTime $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(DateTime $dateEnd): self
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
     * @return Collection|Collaborater[]
     */
    public function getCollaborater(): Collection
    {
        return $this->collaborater;
    }

    public function addCollaborater(Collaborater $collaborater): self
    {
        if (!$this->collaborater->contains($collaborater)) {
            $this->collaborater[] = $collaborater;
        }

        return $this;
    }

    public function removeCollaborater(Collaborater $collaborater): self
    {
        $this->collaborater->removeElement($collaborater);

        return $this;
    }

}
