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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="text")
     */
    private $bio;

    /**
     * @ORM\OneToOne(targetEntity=Bibliotheque::class, inversedBy="membre", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bibliothequePerso;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getnom(): ?string
    {
        return $this->nom;
    }

    public function setnom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getBibliothequePerso(): ?Bibliotheque
    {
        return $this->bibliothequePerso;
    }

    public function setBibliothequePerso(Bibliotheque $bibliothequePerso): self
    {
        $this->bibliothequePerso = $bibliothequePerso;

        return $this;
    }

    public function __toString()
    {
        return $this->getnom() . ' ' . $this->getPrenom();
    }
}