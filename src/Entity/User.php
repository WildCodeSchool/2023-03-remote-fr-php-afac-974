<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Vich\Uploadable]
#[UniqueEntity(fields: ['email'], message: 'Un compte avec cette adresse mail existe déja.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide.')]
    #[Assert\Email(message: 'L\'email {{ value }} n\'est pas valide.')]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Length(
        min: 6,
        minMessage: "Le mot de passe est trop court et doit faire au moins {{ limit }} caractères."
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide.')]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide.')]
    private ?string $lastname = null;

    #[Vich\UploadableField(mapping: 'user_file', fileNameProperty: 'avatar')]
    #[Assert\Image(
        mimeTypes: ['image/jpg', 'image/png', 'image/jpeg'],
        mimeTypesMessage: 'Seuls les formats suivants sont acceptés : .jpeg , .jpg , .png',
    )]
    private ?File $imageFile = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ecard::class)]
    private Collection $ecards;

    #[ORM\ManyToMany(targetEntity: Painting::class, inversedBy: 'users')]
    private Collection $paintingsBookmarked;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->ecards = new ArrayCollection();
        $this->paintingsBookmarked = new ArrayCollection();
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles,
            'password' => $this->password,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'avatar' => $this->avatar,
            'updatedAt' => $this->updatedAt,
            'paintingsBookmarked' => $this->paintingsBookmarked,
            'ecards' => $this->ecards
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->roles = $data['roles'];
        $this->password = $data['password'];
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->avatar = $data['avatar'];
        $this->updatedAt = $data['updatedAt'];
        $this->paintingsBookmarked = $data['paintingsBookmarked'];
        $this->ecards = $data['ecards'];
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection<int, Ecard>
     */
    public function getEcards(): Collection
    {
        return $this->ecards;
    }

    public function addEcard(Ecard $ecard): static
    {
        if (!$this->ecards->contains($ecard)) {
            $this->ecards->add($ecard);
            $ecard->setUser($this);
        }

        return $this;
    }

    public function removeEcard(Ecard $ecard): static
    {
        if ($this->ecards->removeElement($ecard)) {
            // set the owning side to null (unless already changed)
            if ($ecard->getUser() === $this) {
                $ecard->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Painting>
     */
    public function getPaintingsBookmarked(): Collection
    {
        return $this->paintingsBookmarked;
    }

    public function addPaintingsBookmarked(Painting $paintingsBookmarked): static
    {
        if (!$this->paintingsBookmarked->contains($paintingsBookmarked)) {
            $this->paintingsBookmarked->add($paintingsBookmarked);
        }

        return $this;
    }

    public function removePaintingsBookmarked(Painting $paintingsBookmarked): static
    {
        $this->paintingsBookmarked->removeElement($paintingsBookmarked);

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): User
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new DateTimeImmutable('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
