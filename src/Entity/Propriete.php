<?php

namespace App\Entity;

use App\Repository\ProprieteRepository;
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
}
