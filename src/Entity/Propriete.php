<?php

namespace App\Entity;

use App\Repository\ProprieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProprieteRepository::class)
 */
class Propriete
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class, inversedBy="propriete")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $livre;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="proprietes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Emprunt::class, mappedBy="propriete", orphanRemoval=true)
     */
    private $emprunt;

    public function __construct()
    {
        $this->emprunt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    //check si propriete est disponible
    public function estDisponible(): bool
    { 
        //recuperation des emprunts de la propriete
        //pour chaque emprunt, si un n'a pas de date de rendu, c'est qu'il n'est pas dispo.
        foreach($this->getEmprunt() as $emprunt){
            if($emprunt->getDateRendu() === null){
                return false;
            }
        }
        return true;
    }



    /**
     * @return Collection|Emprunt[]
     */
    public function getEmprunt(): Collection
    {
        return $this->emprunt;
    }

    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunt->contains($emprunt)) {
            $this->emprunt[] = $emprunt;
            $emprunt->setPropriete($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunt->contains($emprunt)) {
            $this->emprunt->removeElement($emprunt);
            // set the owning side to null (unless already changed)
            if ($emprunt->getPropriete() === $this) {
                $emprunt->setPropriete(null);
            }
        }

        return $this;
    }

}