<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Veuillez entrer votre nom")]
    #[Assert\Length(
        min: 2,
        max: 32,
        minMessage: 'Votre nom doit comporter {{ limit }} caractères minimum',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 32)]
    private ?string $nom = null;

    #[Assert\NotBlank(message: "Veuillez entrer votre prénom")]
    #[Assert\Length(
        min: 2,
        max: 32,
        minMessage: 'Votre prénom doit comporter {{ limit }} caractères minimum',
        maxMessage: 'Votre prénom ne peut pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 32)]
    private ?string $prenom = null;

    #[Assert\NotBlank(message: "Veuillez entrer une adresse email")]
    #[Assert\Email(
        message: 'Cet email {{ value }} a un format incorrect.',
    )]
    #[ORM\Column(length: 32)]
    private ?string $email = null;

    #[Assert\NotBlank(message: "Veuillez entrer un numéro de téléphone")]
    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[Assert\NotBlank(message: "Veuillez laisser un message")]
    #[Assert\Regex(
        pattern: '/^\w+/',
        match: true,
        message: 'Votre message doit contenir un texte valide',
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
