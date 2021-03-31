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
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3,minMessage="plus de 3 caractere")
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

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="astuces" )
     */
    private $useridastuce;


    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="astuce")
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class)
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="Astuce_id")
     */
    private $userid;

    public function __construct()
    {
        $this -> commentaire = new ArrayCollection();
        $this->userid = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this -> id;
    }

    public function getTitre(): ?string
    {
        return $this -> titre;
    }

    public function setTitre(string $titre): self
    {
        $this -> titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this -> description;
    }

    public function setDescription(string $description): self
    {
        $this -> description = $description;

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

    public function getUseridastuce(): ?User
    {
        return $this -> useridastuce;
    }

    public function setUseridastuce(?User $useridastuce): self
    {
        $this -> useridastuce = $useridastuce;

        return $this;
    }


    public function getActive(): ?bool
    {
        return $this -> active;
    }

    public function setActive(bool $active): self
    {
        $this -> active = $active;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaire(): Collection
    {
        return $this -> commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this -> commentaire -> contains($commentaire)) {
            $this -> commentaire[] = $commentaire;
            $commentaire -> setAstuce($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this -> commentaire -> removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire -> getAstuce() === $this) {
                $commentaire -> setAstuce(null);
            }
        }

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getUserid(): Collection
    {
        return $this->userid;
    }

    public function addUserid(Video $userid): self
    {
        if (!$this->userid->contains($userid)) {
            $this->userid[] = $userid;
            $userid->setAstuceId($this);
        }

        return $this;
    }

    public function removeUserid(Video $userid): self
    {
        if ($this->userid->removeElement($userid)) {
            // set the owning side to null (unless already changed)
            if ($userid->getAstuceId() === $this) {
                $userid->setAstuceId(null);
            }
        }

        return $this;
    }
}





