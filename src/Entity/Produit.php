<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Assert\NotBlank()
     */
    private $Nom_Produit;


   /* /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Assert\NotBlank()
     */
   /* private $Categorie;*/


    /**
     * @ORM\Column(type="text", length=255,nullable=true)
     * @Assert\NotBlank()
     */
    private $Description;

    /**
     * @var string
     * @Assert\NotBlank(message="Il faut importer une image")
     * @Assert\Image()
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $Image;

    /**
     * @ORM\Column(type="float",nullable=true)
     * @Assert\NotBlank()
     */
    private $Prix;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="Produits")
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->Nom_Produit;
    }

    public function setNomProduit(string $Nom_Produit): self
    {
        $this->Nom_Produit = $Nom_Produit;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this -> Image;
    }

    /**
     * @param string $Image
     */
    public function setImage(string $Image): void
    {
        $this -> Image = $Image;
    }


    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }
}
