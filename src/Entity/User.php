<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Axe $axe = null;

    #[ORM\Column(nullable: true)]
    private ?string $contact = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Email::class, orphanRemoval: true)]
    private Collection $emails;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $LastConnexion = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?File $file = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?ImageFile $imageFile = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\Column(length: 255)]
    private ?string $resumer = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePayment = null;

    #[ORM\Column]
    private ?bool $poster = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resumerNouveauNom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePayementNouveauNom = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->emails = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->prenom . ' ' . $this->nom . ' ' . $this->email;
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
        $roles[] = '';

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

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, Email>
     */
    public function getEmails(): Collection
    {
        return $this->emails;
    }

    public function addEmail(Email $email): self
    {
        if (!$this->emails->contains($email)) {
            $this->emails->add($email);
            $email->setUser($this);
        }

        return $this;
    }

    public function removeEmail(Email $email): self
    {
        if ($this->emails->removeElement($email)) {
            // set the owning side to null (unless already changed)
            if ($email->getUser() === $this) {
                $email->setUser(null);
            }
        }

        return $this;
    }

    public function getLastConnexion(): ?\DateTimeInterface
    {
        return $this->LastConnexion;
    }

    public function setLastConnexion(?\DateTimeInterface $LastConnexion): self
    {
        $this->LastConnexion = $LastConnexion;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file): self
    {
        // set the owning side of the relation if necessary
        if ($file->getUser() !== $this) {
            $file->setUser($this);
        }

        $this->file = $file;

        return $this;
    }

    public function getImageFile(): ?ImageFile
    {
        return $this->imageFile;
    }

    public function setImageFile(ImageFile $imageFile): self
    {
        // set the owning side of the relation if necessary
        if ($imageFile->getUser() !== $this) {
            $imageFile->setUser($this);
        }

        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    public function getResumer(): ?string
    {
        return $this->resumer;
    }

    public function setResumer(string $resumer): self
    {
        $this->resumer = $resumer;

        return $this;
    }

    public function getImagePayment(): ?string
    {
        return $this->imagePayment;
    }

    public function setImagePayment(string $imagePayment): self
    {
        $this->imagePayment = $imagePayment;

        return $this;
    }

    public function isPoster(): ?bool
    {
        return $this->poster;
    }

    public function setPoster(bool $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getResumerNouveauNom(): ?string
    {
        return $this->resumerNouveauNom;
    }

    public function setResumerNouveauNom(string $resumerNouveauNom): self
    {
        $this->resumerNouveauNom = $resumerNouveauNom;

        return $this;
    }

    public function getImagePayementNouveauNom(): ?string
    {
        return $this->imagePayementNouveauNom;
    }

    public function setImagePayementNouveauNom(string $imagePayementNouveauNom): self
    {
        $this->imagePayementNouveauNom = $imagePayementNouveauNom;

        return $this;
    }

}
