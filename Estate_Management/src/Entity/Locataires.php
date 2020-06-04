<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocatairesRepository")
 */
class Locataires implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $noms;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenoms;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_de_naissances;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_de_naissances;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephones;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $situation_de_familles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

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
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueLocations", mappedBy="locataires")
     */
    private $historiqueLocations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletter;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
        $this->historiqueLocations = new ArrayCollection();
        $this->activate = 1;
        $this->date_add = new \DateTime();
        $this->date_update = new \DateTime();
        $this->newsletter = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function setNoms(string $noms): self
    {
        $this->noms = $noms;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getDateDeNaissances(): ?\DateTimeInterface
    {
        return $this->date_de_naissances;
    }

    public function setDateDeNaissances(\DateTimeInterface $date_de_naissances): self
    {
        $this->date_de_naissances = $date_de_naissances;

        return $this;
    }

    public function getLieuDeNaissances(): ?string
    {
        return $this->lieu_de_naissances;
    }

    public function setLieuDeNaissances(string $lieu_de_naissances): self
    {
        $this->lieu_de_naissances = $lieu_de_naissances;

        return $this;
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

    public function getTelephones(): ?string
    {
        return $this->telephones;
    }

    public function setTelephones(string $telephones): self
    {
        $this->telephones = $telephones;

        return $this;
    }

    public function getSituationDeFamilles(): ?string
    {
        return $this->situation_de_familles;
    }

    public function setSituationDeFamilles(string $situation_de_familles): self
    {
        $this->situation_de_familles = $situation_de_familles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
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

    /**
     * @return Collection|Biens[]
     */
    public function getBiens(): Collection
    {
        return $this->biens;
    }

    public function addBien(Biens $bien): self
    {
        if (!$this->biens->contains($bien)) {
            $this->biens[] = $bien;
            $bien->setLocataires($this);
        }

        return $this;
    }

    public function removeBien(Biens $bien): self
    {
        if ($this->biens->contains($bien)) {
            $this->biens->removeElement($bien);
            // set the owning side to null (unless already changed)
            if ($bien->getLocataires() === $this) {
                $bien->setLocataires(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HistoriqueLocations[]
     */
    public function getHistoriqueLocations(): Collection
    {
        return $this->historiqueLocations;
    }

    public function addHistoriqueLocation(HistoriqueLocations $historiqueLocation): self
    {
        if (!$this->historiqueLocations->contains($historiqueLocation)) {
            $this->historiqueLocations[] = $historiqueLocation;
            $historiqueLocation->setLocataires($this);
        }

        return $this;
    }

    public function removeHistoriqueLocation(HistoriqueLocations $historiqueLocation): self
    {
        if ($this->historiqueLocations->contains($historiqueLocation)) {
            $this->historiqueLocations->removeElement($historiqueLocation);
            // set the owning side to null (unless already changed)
            if ($historiqueLocation->getLocataires() === $this) {
                $historiqueLocation->setLocataires(null);
            }
        }

        return $this;
    }
    
    public function getSalt()
    {
    }
    public function getRoles(): array
    {
        $roles = [];
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function getUsername()
    {
        return $this->email;
    }
    public function eraseCredentials()
    {
    }

    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }
}
