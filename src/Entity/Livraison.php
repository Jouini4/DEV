<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonRepository::class)
 */
class Livraison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $Numero;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $Nom_livreur;

    /**
     * @ORM\Column(type="string", length=255,nullable=true )
     */
    private $Numero_telephone_livreur;

    /**
     * @ORM\OneToOne(targetEntity=Commande::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true , referencedColumnName="ref")
     */
    private $Commande;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLivreur(): ?string
    {
        return $this->Nom_livreur;
    }

    public function setNomLivreur(string $Nom_livreur): self
    {
        $this->Nom_livreur = $Nom_livreur;

        return $this;
    }

    public function getNumeroTelephoneLivreur(): ?string
    {
        return $this->Numero_telephone_livreur;
    }

    public function setNumeroTelephoneLivreur(string $Numero_telephone_livreur): self
    {
        $this->Numero_telephone_livreur = $Numero_telephone_livreur;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): self
    {
        $this->Commande = $Commande;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }
}
