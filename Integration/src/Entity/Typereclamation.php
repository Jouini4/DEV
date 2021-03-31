<?php

namespace App\Entity;

use App\Repository\TypereclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypereclamationRepository::class)
 */
class Typereclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tyrc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etrc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comrc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ida;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="Typereclamation" ,cascade={"persist", "remove"})
     */
    private $reclamations;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTyrc(): ?string
    {
        return $this->tyrc;
    }

    public function setTyrc(string $tyrc): self
    {
        $this->tyrc = $tyrc;

        return $this;
    }

    public function getEtrc(): ?string
    {
        return $this->etrc;
    }

    public function setEtrc(?string $etrc): self
    {
        $this->etrc = $etrc;

        return $this;
    }

    public function getComrc(): ?string
    {
        return $this->comrc;
    }

    public function setComrc(?string $comrc): self
    {
        $this->comrc = $comrc;

        return $this;
    }

    public function getIda(): ?int
    {
        return $this->ida;
    }

    public function setIda(?int $ida): self
    {
        $this->ida = $ida;

        return $this;
    }


    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setTypereclamation($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getTypereclamation() === $this) {
                $reclamation->setTypereclamation(null);
            }
        }

        return $this;
    }
    public function __toString()
    {

        return $this->tyrc;

    }

}
