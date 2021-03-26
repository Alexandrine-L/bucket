<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "Veuillez renseigner ce champ")
     * @Assert\Length(
     *     min=3,
     *     max=50,
     *     minMessage="ce champ doit contenir minimum 3 caractères",
     *     maxMessage="la taille maximale est de 50 caractères",
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @Assert\NotBlank(message = "Veuillez renseigner ce champ")
     * @Assert\Length(
     *     min=5,
     *     max=255,
     *     minMessage="ce champ doit contenir minimum 5 caractères",
     *     maxMessage="la taille maximale est de 255 caractères",
     * )
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity=Wish::class, inversedBy="reactions")
     */
    private $wish;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getWish(): ?Wish
    {
        return $this->wish;
    }

    public function setWish(?Wish $wish): self
    {
        $this->wish = $wish;

        return $this;
    }
}
