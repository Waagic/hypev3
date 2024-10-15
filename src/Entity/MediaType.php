<?php

namespace App\Entity;

use App\Repository\MediaTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaTypeRepository::class)]
class MediaType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\OneToOne(mappedBy: 'type', cascade: ['persist', 'remove'])]
    private ?Media $media = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(Media $media): static
    {
        // set the owning side of the relation if necessary
        if ($media->getType() !== $this) {
            $media->setType($this);
        }

        $this->media = $media;

        return $this;
    }
}
