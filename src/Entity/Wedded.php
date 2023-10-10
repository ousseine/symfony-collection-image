<?php

namespace App\Entity;

use App\Repository\WeddedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeddedRepository::class)]
class Wedded
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $mary = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $wife = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $weddAt = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $city = null;

    #[ORM\OneToMany(mappedBy: 'wedd', targetEntity: Image::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMary(): ?string
    {
        return $this->mary;
    }

    public function setMary(string $mary): static
    {
        $this->mary = $mary;

        return $this;
    }

    public function getWife(): ?string
    {
        return $this->wife;
    }

    public function setWife(string $wife): static
    {
        $this->wife = $wife;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getWeddAt(): ?\DateTimeInterface
    {
        return $this->weddAt;
    }

    public function setWeddAt(?\DateTimeInterface $weddAt): static
    {
        $this->weddAt = $weddAt;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setWedd($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getWedd() === $this) {
                $image->setWedd(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }
}
