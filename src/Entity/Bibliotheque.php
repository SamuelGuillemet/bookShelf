<?php

namespace App\Entity;

use App\Repository\BibliothequeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BibliothequeRepository::class)
 */
class Bibliotheque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Livre::class, mappedBy="bibliotheque", orphanRemoval=true, cascade={"persist"})
     */
    private $Livres;

    /**
     * @ORM\OneToOne(targetEntity=Membre::class, mappedBy="BibliothequePerso", cascade={"persist", "remove"})
     */
    private $membre;

    public function __construct()
    {
        $this->Livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->Livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->Livres->contains($livre)) {
            $this->Livres[] = $livre;
            $livre->setBibliotheque($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->Livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getBibliotheque() === $this) {
                $livre->setBibliotheque(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string //TODO
    {
        return $this->name;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(Membre $membre): self
    {
        // set the owning side of the relation if necessary
        if ($membre->getBibliothequePerso() !== $this) {
            $membre->setBibliothequePerso($this);
        }

        $this->membre = $membre;

        return $this;
    }
}