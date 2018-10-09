<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserQuestionChoice", mappedBy="user", cascade={"persist"})
     */
    private $userquestionchoices;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function __construct()
      {
          $this->isActive = true;
          $this->score = 0;
          $this->userquestionchoices = new ArrayCollection();
          // may not be needed, see section on salt below
          // $this->salt = md5(uniqid('', true));
      }


      public function getSalt()
      {
          // you *may* need a real salt depending on your encoder
          // see section on salt below
          return null;
      }

      public function getRoles()
      {
          return $this->roles;
      }

      public function eraseCredentials()
      {
      }

      /** @see \Serializable::serialize() */
      public function serialize()
      {
          return serialize(array(
              $this->id,
              $this->username,
              $this->password,
              // see section on salt below
              // $this->salt,
          ));
      }

      /** @see \Serializable::unserialize() */
      public function unserialize($serialized)
      {
          list (
              $this->id,
              $this->username,
              $this->password,
              // see section on salt below
              // $this->salt
          ) = unserialize($serialized, array('allowed_classes' => false));
      }

      public function setRoles(array $roles): self
      {
          $this->roles = $roles;

          return $this;
      }

      public function getScore(): ?int
      {
          return $this->score;
      }

      public function setScore(int $score): self
      {
          $this->score = $score;

          return $this;
      }

      /**
       * @return Collection|UserQuestionChoice[]
       */
      public function getUserquestionchoices(): Collection
      {
          return $this->userquestionchoices;
      }

      public function addUserquestionchoice(UserQuestionChoice $userquestionchoice): self
      {
          if (!$this->userquestionchoices->contains($userquestionchoice)) {
              $this->userquestionchoices[] = $userquestionchoice;
              $userquestionchoice->setUser($this);
          }

          return $this;
      }

      public function removeUserquestionchoice(UserQuestionChoice $userquestionchoice): self
      {
          if ($this->userquestionchoices->contains($userquestionchoice)) {
              $this->userquestionchoices->removeElement($userquestionchoice);
              // set the owning side to null (unless already changed)
              if ($userquestionchoice->getUser() === $this) {
                  $userquestionchoice->setUser(null);
              }
          }

          return $this;
      }

}
