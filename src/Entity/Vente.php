<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOperation = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'ventes')]
    private Collection $Articles;

    #[ORM\Column]
    private ?float $transport = null;

    #[ORM\Column]
    private ?float $grandTotal = null;

    #[ORM\Column(length: 255)]
    private ?string $invoicePath = null;

    public function __construct()
    {
        $this->Articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->dateOperation;
    }

    public function setDateOperation(\DateTimeInterface $dateOperation): static
    {
        $this->dateOperation = $dateOperation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->Articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->Articles->contains($article)) {
            $this->Articles->add($article);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        $this->Articles->removeElement($article);

        return $this;
    }

    public function getTransport(): ?float
    {
        return $this->transport;
    }

    public function setTransport(float $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    public function getGrandTotal(): ?float
    {
        return $this->grandTotal;
    }

    public function setGrandTotal(float $grandTotal): static
    {
        $this->grandTotal = $grandTotal;

        return $this;
    }

    public function getInvoicePath(): ?string
    {
        return $this->invoicePath;
    }

    public function setInvoicePath(string $invoicePath): static
    {
        $this->invoicePath = $invoicePath;

        return $this;
    }
}
