<?php

namespace App\Entity;

use App\Repository\AstuceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;



use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AstuceRepository::class)
 */
class Astuce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *@ORM\Column(type="string", length=255)
     *@Assert\Length(min=3,minMessage="plus de 3 caractere")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @var string
     * @Assert\NotBlank(message="Il faut importer une image")
     * @Assert\Image()
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this -> image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this -> image = $image;
    }


}
