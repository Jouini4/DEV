<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $email;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank (message ="le nom de l'event est obligatoire")
     */
    public $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank
     */
    public $prenom;

    /**
     * @ORM\Column(type="integer")
     * * @Assert\NotBlank
     */
    public $num_tel;
    /**
     * @ORM\Column(type="integer")
     * * @Assert\NotBlank
     */
    public $nombre_place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getNombrePlace()
    {
        return $this->nombre_place;
    }

    /**
     * @param mixed $nombre_place
     */
    public function setNombrePlace($nombre_place): void
    {
        $this->nombre_place = $nombre_place;
    }


}
