<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Membre $usersref = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $coursref = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsersref(): ?Membre
    {
        return $this->usersref;
    }

    public function setUsersref(?Membre $usersref): static
    {
        $this->usersref = $usersref;

        return $this;
    }

    public function getCoursref(): ?Cours
    {
        return $this->coursref;
    }

    public function setCoursref(?Cours $coursref): static
    {
        $this->coursref = $coursref;

        return $this;
    }
}
