<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
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
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_couverture;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_ajout;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * à défaut = false
     */
    private $est_emprunte = false;

    /**
     * @ORM\ManyToMany(targetEntity=Auteur::class, mappedBy="livres")
     */
    private $auteurs;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class, mappedBy="livres")
     */
    private $categories;

    /**
     * CASCADE PERSIST pour ajouter propriété en meme temps que livre avec le form de creation de livre
     * @ORM\OneToMany(targetEntity=Propriete::class, mappedBy="livre", orphanRemoval=true, cascade={"persist"})
     */
    private $propriete;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->propriete = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrlCouverture(): ?string
    {
        return $this->url_couverture;
    }

    public function setUrlCouverture(?string $url_couverture): self
    {
        $this->url_couverture = $url_couverture;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(?\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function getEstEmprunte(): ?bool
    {
        return $this->est_emprunte;
    }

    public function setEstEmprunte(?bool $est_emprunte): self
    {
        $this->est_emprunte = $est_emprunte;

        return $this;
    }

    //check si le livre est disponible
    public function estDisponible(): bool
    { 
        //recup des propriétés du livre
        foreach($this->getPropriete() as $propriete){
            //check si la propriété est disponible
            if($propriete->estDisponible()){
                return true;
            }
        }     
        return false;
    }

    //check si le livre est non disponible
    public function falseEstDisponible(): bool
    { 
        //recup des propriétés du livre
        foreach($this->getPropriete() as $propriete){
            //check si la propriété est disponible
            if($propriete->estDisponible()){
                return false;
            }
        }     
        return false;
    }

    /**
     * @return Collection|Auteur[]
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs[] = $auteur;
            $auteur->addLivre($this);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        if ($this->auteurs->contains($auteur)) {
            $this->auteurs->removeElement($auteur);
            $auteur->removeLivre($this);
        }

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addLivre($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeLivre($this);        
        }

        return $this;
    }

    /**
     * @return Collection|Propriete[]
     */
    public function getPropriete(): Collection
    {
        return $this->propriete;
    }

    public function addPropriete(Propriete $propriete): self
    {
        if (!$this->propriete->contains($propriete)) {
            $this->propriete[] = $propriete;
            $propriete->setLivre($this);
        }

        return $this;
    }

    public function removePropriete(Propriete $propriete): self
    {
        if ($this->propriete->contains($propriete)) {
            $this->propriete->removeElement($propriete);
            // set the owning side to null (unless already changed)
            if ($propriete->getLivre() === $this) {
                $propriete->setLivre(null);
            }
        }

        return $this;
    }

}
