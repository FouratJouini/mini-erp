<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $Categorie = null;

    #[ORM\Column]
    private ?float $PrixGros = null;

    #[ORM\Column]
    private ?float $PrixDetail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $decription = null;

    #[ORM\Column]
    private ?float $dateValidite = null;

    #[ORM\OneToOne(mappedBy: 'Article', cascade: ['persist', 'remove'])]
    private ?Stock $stock = null;

    /**
     * @var Collection<int, Operation>
     */
    #[ORM\ManyToMany(targetEntity: Operation::class, mappedBy: 'Articles')]
    private Collection $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categorie $Categorie): static
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    public function getPrixGros(): ?float
    {
        return $this->PrixGros;
    }

    public function setPrixGros(float $PrixGros): static
    {
        $this->PrixGros = $PrixGros;

        return $this;
    }

    public function getPrixDetail(): ?float
    {
        return $this->PrixDetail;
    }

    public function setPrixDetail(float $PrixDetail): static
    {
        $this->PrixDetail = $PrixDetail;

        return $this;
    }

    public function getDecription(): ?string
    {
        return $this->decription;
    }

    public function setDecription(?string $decription): static
    {
        $this->decription = $decription;

        return $this;
    }

    public function getDateValidite(): ?float
    {
        return $this->dateValidite;
    }

    public function setDateValidite(float $dateValidite): static
    {
        $this->dateValidite = $dateValidite;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): static
    {
        // set the owning side of the relation if necessary
        if ($stock->getArticle() !== $this) {
            $stock->setArticle($this);
        }

        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->addArticle($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            $operation->removeArticle($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }
}
