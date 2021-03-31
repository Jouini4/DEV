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
    private $id;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $nbrplace;

    /**
     * @ORM\Column(type="boolean")
     */
    private $approuve;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement",inversedBy="Reservation")
     * @ORM\JoinColumn(name="id_Event", referencedColumnName="id",onDelete="CASCADE")
     */
    public $id_Event;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Reservation")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }


    public function getId(): ?int
    {
        return $this->id;
    }




    /**
     * @return mixed
     */
    public function getIdEvent()
    {
        return $this->id_Event;
    }

    /**
     * @param mixed $id_Event
     */
    public function setIdEvent($id_Event): void
    {
        $this->id_Event = $id_Event;
    }

    /**
     * @return mixed
     */
    public function getNbrplace()
    {
        return $this->nbrplace;
    }

    /**
     * @param mixed $nbrplace
     */
    public function setNbrplace($nbrplace): void
    {
        $this->nbrplace = $nbrplace;
    }

    /**
     * @return mixed
     */
    public function getApprouve()
    {
        return $this->approuve;
    }

    /**
     * @param mixed $approuve
     */
    public function setApprouve($approuve): void
    {
        $this->approuve = $approuve;
    }




}
