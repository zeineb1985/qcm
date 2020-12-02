<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Question;


/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rep;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="reponses",cascade={"persist"})
     */
    private $question;
    public function __construct()
    {
        $this->question = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getRep();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRep(): ?string
    {
        return $this->rep;
    }

    public function setRep(?string $rep): self
    {
        $this->rep = $rep;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function addQuestion(?Question $question): void
{
    if (!$this->question->contains($question)) {
        $this->question->add($question);
    }



}


    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
/**
     * @return Collection|Question[]
     */
    
    public function getQuestion():? Collection
    {
        return $this->question;
    }

}
