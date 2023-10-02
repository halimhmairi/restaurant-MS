<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    /**
     * @ORM\OneToOne(targetEntity="menu", inversedBy="gallery")
     * @ORM\JoinColumn(name="entity_a_id", referencedColumnName="id")
     */


    #[ORM\Column(length: 255)]
    private array | string $images = '';

    #[ORM\ManyToOne(inversedBy: 'gallery')]
    #[ORM\JoinColumn(nullable: false)]
    public ?Menu $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?Menu
    {
        return $this->image;
    }

    public function setImage(Menu $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImages(): array | string | null
    {
        return json_decode(json_decode($this->images));
    }

    public function setImages(array | string $images): self
    {
        $this->images = json_encode($images);

        return $this;
    }

}