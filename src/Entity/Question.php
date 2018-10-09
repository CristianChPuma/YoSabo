<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $question;

    /**
     * @ORM\Column(type="text")
     */
    private $explanation;

    /**
     * @ORM\Column(type="string", length=254)
     */
    private $cover;

    /**
     * @ORM\Column(type="integer")
     */
    private $rewards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionChoice", mappedBy="question")
     */
    private $questionchoices;

    public function __construct()
    {
        $this->questionchoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): self
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getRewards(): ?int
    {
        return $this->rewards;
    }

    public function setRewards(int $rewards): self
    {
        $this->rewards = $rewards;

        return $this;
    }

    /**
     * @return Collection|QuestionChoice[]
     */
    public function getQuestionchoices(): Collection
    {
        return $this->questionchoices;
    }

    public function addQuestionchoice(QuestionChoice $questionchoice): self
    {
        if (!$this->questionchoices->contains($questionchoice)) {
            $this->questionchoices[] = $questionchoice;
            $questionchoice->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionchoice(QuestionChoice $questionchoice): self
    {
        if ($this->questionchoices->contains($questionchoice)) {
            $this->questionchoices->removeElement($questionchoice);
            // set the owning side to null (unless already changed)
            if ($questionchoice->getQuestion() === $this) {
                $questionchoice->setQuestion(null);
            }
        }

        return $this;
    }

}
