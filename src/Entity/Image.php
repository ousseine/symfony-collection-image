<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Wedded::class, inversedBy: 'images')]
    private ?Wedded $wedd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWedd(): ?Wedded
    {
        return $this->wedd;
    }

    public function setWedd(?Wedded $wedd): static
    {
        $this->wedd = $wedd;

        return $this;
    }
}
