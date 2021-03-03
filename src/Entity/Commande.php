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
    private $Prix_Total;


    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="Commandes")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description_Adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Gouvernorat;

    /**
     * @ORM\Column(type="integer")
     */
    private $code_postal;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero_telephone;



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
        return $this->Prix_Total;
    }

    public function setPrixTotal(float $Prix_Total): self
    {
        $this->Prix_Total = $Prix_Total;

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
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getDescriptionAdresse(): ?string
    {
        return $this->Description_Adresse;
    }

    public function setDescriptionAdresse(?string $Description_Adresse): self
    {
        $this->Description_Adresse = $Description_Adresse;

        return $this;
    }

    public function getGouvernorat(): ?string
    {
        return $this->Gouvernorat;
    }

    public function setGouvernorat(string $Gouvernorat): self
    {
        $this->Gouvernorat = $Gouvernorat;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->numero_telephone;
    }

    public function setNumeroTelephone(int $Numero_telephone): self
    {
        $this->numero_telephone = $Numero_telephone;

        return $this;
    }
}
