<?php

namespace App\Entity;

use App\Repository\AccesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccesRepository::class)
 */
class Acces
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="acces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $util;

    /**
     * @ORM\ManyToOne(targetEntity=Document::class, inversedBy="auto")
     * @ORM\JoinColumn(nullable=false)
     */
    private $doc;

    /**
     * @ORM\ManyToOne(targetEntity=Autorisation::class, inversedBy="acces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $autor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtil(): ?Utilisateur
    {
        return $this->util;
    }

    public function setUtil(?Utilisateur $util): self
    {
        $this->util = $util;

        return $this;
    }

    public function getDoc(): ?Document
    {
        return $this->doc;
    }

    public function setDoc(?Document $doc): self
    {
        $this->doc = $doc;

        return $this;
    }

    public function getAutor(): ?Autorisation
    {
        return $this->autor;
    }

    public function setAutor(?Autorisation $autor): self
    {
        $this->autor = $autor;

        return $this;
    }
}
