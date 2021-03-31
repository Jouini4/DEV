<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numcmd;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pnomc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mailc;

    /**
     * @ORM\Column(type="integer")
     */
    private $numclient;





    /**
     * @ORM\Column(type="string", length=255)
     */
    private $obrc;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $desrec;

    /**
     *  @var  string
     * @ORM\Column(name="screenshot",type="string", length=255)
     */
    private $screenshot;



    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Typereclamation::class, inversedBy="reclamations",cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Typereclamation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class)
     * @ORM\JoinColumn(nullable=false, referencedColumnName="ref")
     */
    private $commande;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNumcmd(): ?int
    {
        return $this->numcmd;
    }

    public function setNumcmd(?int $numcmd): self
    {
        $this->numcmd = $numcmd;

        return $this;
    }



    public function getNomc(): ?string
    {
        return $this->nomc;
    }

    public function setNomc(string $nomc): self
    {
        $this->nomc = $nomc;

        return $this;
    }

    public function getPnomc(): ?string
    {
        return $this->pnomc;
    }

    public function setPnomc(string $pnomc): self
    {
        $this->pnomc = $pnomc;

        return $this;
    }

    public function getMailc(): ?string
    {
        return $this->mailc;
    }

    public function setMailc(string $mailc): self
    {
        $this->mailc = $mailc;

        return $this;
    }

    public function getNumclient(): ?int
    {
        return $this->numclient;
    }

    public function setNumclient(int $numclient): self
    {
        $this->numclient = $numclient;

        return $this;
    }


    public function getObrc(): ?string
    {
        return $this->obrc;
    }

    public function setObrc(string $obrc): self
    {
        $this->obrc = $obrc;

        return $this;
    }

    public function getDesrec(): ?string
    {
        return $this->desrec;
    }

    public function setDesrec(?string $desrec): self
    {
        $this->desrec = $desrec;

        return $this;
    }

    public function getScreenshot(): ?string
    {
        return $this->screenshot;
    }
    /**
     * @param string $screenshot
     */
    public function setScreenshot(?string $screenshot): void
    {
        $this->screenshot = $screenshot;

    }


    public function __toString()
    {

        return(string)$this->getUpdatedAt();


        }
    public function _toString()
    {

        return(string)$this->getCreatedAt();


    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTypereclamation(): ?Typereclamation
    {
        return $this->Typereclamation;
    }

    public function setTypereclamation(?Typereclamation $Typereclamation): self
    {
        $this->Typereclamation = $Typereclamation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }





}
