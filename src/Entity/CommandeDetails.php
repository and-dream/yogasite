<?php

namespace App\Entity;

use App\Repository\CommandeDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeDetailsRepository::class)]
class CommandeDetails
{
 
    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'commandeDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commandes = null;  

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'commandeDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Retraite $products = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCommandes(): ?Commande
    {
        return $this->commandes;
    }

    public function setCommandes(?Commande $commandes): static
    {
        $this->commandes = $commandes;

        return $this;
    }

    public function getProducts(): ?Retraite
    {
        return $this->products;
    }

    public function setProducts(?Retraite $products): static
    {
        $this->products = $products;

        return $this;
    }
}
