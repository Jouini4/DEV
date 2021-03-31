<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;



use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message ="le nom de l'event est obligatoire")
     */
    public $nom_event;

    /**
     * @ORM\Column(type="text")
      * @Assert\NotBlank (message ="la description de l'event est obligatoire")
     */
    public $description_event;



    /**
     * @ORM\Column(type="date")
     */
    public $date;

    /**
     * @ORM\Column(type="float")
      * @Assert\NotBlank (message ="le prix de l'event est obligatoire")
     */
    public $prix_event;

    /**
     * @ORM\Column(type="integer")
      * @Assert\NotBlank (message ="le nombre de place de l'event est obligatoire")
     */
    public $nbr_place;
    /**
     * @var string
     * @Assert\NotBlank(message="Il faut importer une image")
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    public $image;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @ORM\Column(type="float" , nullable=true)
     */
    private $latitude;


    public function getNomEvent(): ?string
    {
        return $this->nom_event;
    }

    public function setNomEvent(string $nom_event): self
    {
        $this->nom_event = $nom_event;

        return $this;
    }

    public function getDescriptionEvent(): ?string
    {
        return $this->description_event;
    }

    public function setDescriptionEvent(string $description_event): self
    {
        $this->description_event = $description_event;

        return $this;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrixEvent(): ?float
    {
        return $this->prix_event;
    }

    public function setPrixEvent(float $prix_event): self
    {
        $this->prix_event = $prix_event;

        return $this;
    }

    public function getNbrPlace(): ?int
    {
        return $this->nbr_place;
    }

    public function setNbrPlace(int $nbr_place): self
    {
        $this->nbr_place = $nbr_place;

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
    public function __construct()
    {
        $this->date = new \DateTime('now');

    }
}
