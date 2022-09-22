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
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Livre::class, mappedBy="bibliotheque", orphanRemoval=true, cascade={"persist"})
     */
    private $Livres;

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

    public function __toString(): string //TODO
    {
        return $this->description;
    }
}