<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** 
    * @ORM\ManyToOne(targetEntity="OptionList", inversedBy="option")  
    */
    private $optionList;

    /** 
    * @ORM\ManyToOne(targetEntity="Article", inversedBy="option")  
    */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOptionList(): ?OptionList
    {
        return $this->optionList;
    }

    public function setOptionList(?OptionList $optionList): self
    {
        $this->optionList = $optionList;

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
}
