<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MembreRepository::class)
 */
class Membre
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
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="text")
     */
    private $Bio;

    /**
     * @ORM\OneToOne(targetEntity=Bibliotheque::class, inversedBy="membre", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $BibliothequePerso;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->Bio;
    }

    public function setBio(string $Bio): self
    {
        $this->Bio = $Bio;

        return $this;
    }

    public function getBibliothequePerso(): ?Bibliotheque
    {
        return $this->BibliothequePerso;
    }

    public function setBibliothequePerso(Bibliotheque $BibliothequePerso): self
    {
        $this->BibliothequePerso = $BibliothequePerso;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom() . ' ' . $this->getPrenom();
    }
}