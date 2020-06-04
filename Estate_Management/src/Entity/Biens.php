<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BiensRepository")
 */
class Biens
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
     * @ORM\Column(type="string", length=1000)
     */
    private $descriptions;

    /**
     * @ORM\Column(type="integer")
     */
    private $surfaces;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_pieces;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_chambres;

    /**
     * @ORM\Column(type="float")
     */
    private $loyers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statuts;

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
     * @ORM\OneToOne(targetEntity="App\Entity\Adresses", inversedBy="biens", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Adresses;

    

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueLocations", mappedBy="biens")
     */
    private $historiqueLocations;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="biens",cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="biens")
     */
    private $messages;
    
    public function __construct()
    {
        $this->historiqueLocations = new ArrayCollection();
        $this->activate = 1;
        $this->date_add = new \DateTime();
        $this->date_update = new \DateTime();
        $this->images = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    public function setNoms(string $noms): self
    {
        $this->noms = $noms;

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function getSurfaces(): ?int
    {
        return $this->surfaces;
    }

    public function setSurfaces(int $surfaces): self
    {
        $this->surfaces = $surfaces;

        return $this;
    }

    public function getNbrPieces(): ?int
    {
        return $this->nbr_pieces;
    }

    public function setNbrPieces(int $nbr_pieces): self
    {
        $this->nbr_pieces = $nbr_pieces;

        return $this;
    }

    public function getNbrChambres(): ?int
    {
        return $this->nbr_chambres;
    }

    public function setNbrChambres(int $nbr_chambres): self
    {
        $this->nbr_chambres = $nbr_chambres;

        return $this;
    }

    public function getLoyers(): ?float
    {
        return $this->loyers;
    }

    public function setLoyers(float $loyers): self
    {
        $this->loyers = $loyers;

        return $this;
    }

    public function getStatuts(): ?bool
    {
        return $this->statuts;
    }

    public function setStatuts(bool $statuts): self
    {
        $this->statuts = $statuts;

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

    public function getAdresses()
    {
        return $this->Adresses;
    }

    public function setAdresses(Adresses $Adresses)
    {
        $this->Adresses = $Adresses;

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
            $historiqueLocation->setBiens($this);
        }

        return $this;
    }

    public function removeHistoriqueLocation(HistoriqueLocations $historiqueLocation): self
    {
        if ($this->historiqueLocations->contains($historiqueLocation)) {
            $this->historiqueLocations->removeElement($historiqueLocation);
            // set the owning side to null (unless already changed)
            if ($historiqueLocation->getBiens() === $this) {
                $historiqueLocation->setBiens(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setBiens($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getBiens() === $this) {
                $image->setBiens(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Messages[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setBiens($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getBiens() === $this) {
                $message->setBiens(null);
            }
        }

        return $this;
    }
}
