<?php

namespace App\Entity;

use App\Repository\PaintingRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaintingRepository::class)]
#[Vich\Uploadable]
class Painting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Ce champ ne doit pas être vide')]
    #[Assert\Length(min: 4, minMessage: 'Le titre est trop court et doit faire plus de {{ limit }} caractères')]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message:'Ce champ ne doit pas être vide')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 200, maxMessage: 'L\'anecdote est trop longue et doit faire moins de {{ limit }} caractères')]
    private ?string $anecdote = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'Ce champ ne doit pas être vide')]
    #[Assert\Regex(
        pattern: '/[0-9]/',
        message: 'La hauteur ne doit contenir que des chiffres.',
    )]
    private ?int $height = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'Ce champ ne doit pas être vide')]
    #[Assert\Regex(
        pattern: '/[0-9]/',
        message: 'La largeur ne doit contenir que des chiffres.',
    )]
    private ?int $width = null;

    #[Vich\UploadableField(mapping: 'painting_file', fileNameProperty: 'image')]
    #[Assert\Image(
        mimeTypes: ['image/jpg',' image/png','image/jpeg'],
        mimeTypesMessage: 'Seuls les formats suivants sont acceptés : .jpeg , .jpg , .png',
    )]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'paintings')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'paintings')]
    private ?Artist $artist = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'painting', targetEntity: Ecard::class)]
    private Collection $ecards;
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'paintingsBookmarked')]
    private Collection $users;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->ecards = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAnecdote(): ?string
    {
        return $this->anecdote;
    }

    public function setAnecdote(?string $anecdote): self
    {
        $this->anecdote = $anecdote;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

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
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
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
            $ecard->setPainting($this);
        }

        return $this;
    }

    public function removeEcard(Ecard $ecard): static
    {
        if ($this->ecards->removeElement($ecard)) {
            // set the owning side to null (unless already changed)
            if ($ecard->getPainting() === $this) {
                $ecard->setPainting(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addPaintingsBookmarked($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removePaintingsBookmarked($this);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
