<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $REF;

    /**
     * @ORM\Column(type="float")
     */
    private $prixTotal;


    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="Commandes")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descriptionAdresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gouvernorat;

    /**
     * @ORM\Column(type="integer")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroTelephone;



    public function getREF(): ?int
    {
        return $this->REF;
    }

    public function setREF(int $REF): self
    {
        $this->REF = $REF;

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $Prixtotal): self
    {
        $this->prixTotal = $Prixtotal;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDescriptionAdresse(): ?string
    {
        return $this->descriptionAdresse;
    }

    public function setDescriptionAdresse(?string $descriptionadresse): self
    {
        $this->descriptionAdresse = $descriptionadresse;

        return $this;
    }

    public function getGouvernorat(): ?string
    {
        return $this->gouvernorat;
    }

    public function setGouvernorat(string $gouvernorat): self
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codepostal): self
    {
        $this->codePostal = $codepostal;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(int $numerotelephone): self
    {
        $this->numeroTelephone = $numerotelephone;

        return $this;
    }
}
