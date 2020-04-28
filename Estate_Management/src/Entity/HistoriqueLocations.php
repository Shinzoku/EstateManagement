<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoriqueLocationsRepository")
 */
class HistoriqueLocations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_update;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_delete;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locataires", inversedBy="historiqueLocations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $locataires;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Biens", inversedBy="historiqueLocations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $biens;

    public function __construct()
    {
        $this->activate = 1;
        $this->date_add = new \DateTime();
        $this->date_update = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString() {
        return (string) $this->getId();
    }

    public function getActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUpdate(\DateTimeInterface $date_update): self
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getDateDelete(): ?\DateTimeInterface
    {
        return $this->date_delete;
    }

    public function setDateDelete(?\DateTimeInterface $date_delete): self
    {
        $this->date_delete = $date_delete;

        return $this;
    }

    public function getLocataires()
    {
        return $this->locataires;
    }

    public function setLocataires(?Locataires $locataires)
    {
        $this->locataires = $locataires;

        return $this;
    }

    public function getBiens()
    {
        return $this->biens;
    }

    public function setBiens(?Biens $biens)
    {
        $this->biens = $biens;

        return $this;
    }
}