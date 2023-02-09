<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $communication = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resume = null;

    #[ORM\Column(nullable: true)]
    private ?bool $aPayer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePayement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Axe $axe = null;

    #[ORM\Column(nullable: true)]
    private ?bool $terms = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $structure = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $produits = null;

    #[ORM\Column(nullable: true)]
    private ?int $contact = null;

    #[ORM\Column(nullable: true)]
    private ?int $numero = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCommunication(): ?string
    {
        return $this->communication;
    }

    public function setCommunication(?string $communication): self
    {
        $this->communication = $communication;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function isAPayer(): ?bool
    {
        return $this->aPayer;
    }

    public function setAPayer(?bool $aPayer): self
    {
        $this->aPayer = $aPayer;

        return $this;
    }

    public function getImagePayement(): ?string
    {
        return $this->imagePayement;
    }

    public function setImagePayement(?string $imagePayement): self
    {
        $this->imagePayement = $imagePayement;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getAxe(): ?Axe
    {
        return $this->axe;
    }

    public function setAxe(?Axe $axe): self
    {
        $this->axe = $axe;

        return $this;
    }

    public function isTerms(): ?bool
    {
        return $this->terms;
    }

    public function setTerms(?bool $terms): self
    {
        $this->terms = $terms;

        return $this;
    }
    public function getStructure(): ?string
    {
        return $this->structure;
    }

    public function setStructure(?string $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getProduits(): ?string
    {
        return $this->produits;
    }

    public function setProduits(?string $produits): self
    {
        $this->produits = $produits;

        return $this;
    }

    public function getContact(): ?int
    {
        return $this->contact;
    }

    public function setContact(?int $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }


}
