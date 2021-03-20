<?php

namespace App\Entity;

use App\Repository\CollaboraterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CollaboraterRepository::class)
 */
class Collaborater
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="collaboratersHost")
     */
    private $host;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="collaboratersTarget")
     */
    private $target;

    /**
     * @ORM\ManyToMany(targetEntity="Operation", mappedBy="collaborater")
     */
    private $operations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHost(): ?User
    {
        return $this->host;
    }

    public function setHost(?User $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getTarget(): ?User
    {
        return $this->target;
    }

    public function setTarget(?User $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperations(Operation $operations): self
    {
        if (!$this->operations->contains($operations)) {
            $this->operations[] = $operations;
            $operations->addUser($this);
        }

        return $this;
    }

    public function removeOperations(Operation $operations): self
    {
        if ($this->operations->removeElement($operations)) {
            $operations->removeUser($this);
        }

        return $this;
    }
}
