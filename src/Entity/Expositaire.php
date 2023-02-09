<?php

namespace App\Entity;

use App\Repository\ExpositaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpositaireRepository::class)]
class Expositaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $structure = null;

    #[ORM\Column(length: 255)]
    private ?string $emailStructure = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $produits = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getStructure(): ?string
    {
        return $this->structure;
    }

    public function setStructure(string $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getEmailStructure(): ?string
    {
        return $this->emailStructure;
    }

    public function setEmailStructure(string $emailStructure): self
    {
        $this->emailStructure = $emailStructure;

        return $this;
    }

    public function getProduits(): ?string
    {
        return $this->produits;
    }

    public function setProduits(string $produits): self
    {
        $this->produits = $produits;

        return $this;
    }
}
