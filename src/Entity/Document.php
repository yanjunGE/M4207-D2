<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
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
    private $chemin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\OneToMany(targetEntity=Acces::class, mappedBy="doc")
     */
    private $auto;

    public function __construct()
    {
        $this->auto = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(string $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
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

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection|Acces[]
     */
    public function getAuto(): Collection
    {
        return $this->auto;
    }

    public function addAuto(Acces $auto): self
    {
        if (!$this->auto->contains($auto)) {
            $this->auto[] = $auto;
            $auto->setDoc($this);
        }

        return $this;
    }

    public function removeAuto(Acces $auto): self
    {
        if ($this->auto->removeElement($auto)) {
            // set the owning side to null (unless already changed)
            if ($auto->getDoc() === $this) {
                $auto->setDoc(null);
            }
        }

        return $this;
    }
}
