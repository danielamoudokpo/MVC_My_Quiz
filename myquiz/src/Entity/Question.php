<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="categorie_id", type="integer", nullable=true)
     */
    private $idCategorie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=true)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reponse", mappedBy="question", orphanRemoval=true)
     */
    private $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?int $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function __toString(){

        return $this->question;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponses(Reponse $reponses): self
    {
        if (!$this->reponses->contains($reponses)) {
            $this->reponses[] = $reponses;
            $reponses->setQuestion($this);
        }

        return $this;
    }

    public function removeReponses(Reponse $reponses): self
    {
        if ($this->reponses->contains($reponses)) {
            $this->reponses->removeElement($reponses);
            // set the owning side to null (unless already changed)
            if ($reponses->getQuestion() === $this) {
                $reponses->setQuestion(null);
            }
        }

        return $this;
    }


}
