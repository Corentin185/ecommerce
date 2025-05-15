<?php

// src/Entity/Produit.php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\StockOption; // ← N'oublie pas cette ligne

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Option::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $options;

    #[ORM\OneToMany(targetEntity: Option::class, mappedBy: 'relation')]
    private Collection $typeOption;

    // 🔗 Relation vers StockOption (1 produit → plusieurs variations)
    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: StockOption::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $stockOptions;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->typeOption = new ArrayCollection();
        $this->stockOptions = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getType(): ?string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getPrix(): ?float { return $this->prix; }
    public function setPrix(float $prix): self { $this->prix = $prix; return $this; }

    public function getStock(): ?int { return $this->stock; }
    public function setStock(int $stock): static { $this->stock = $stock; return $this; }

    public function getOptions(): Collection { return $this->options; }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setProduit($this);
        }
        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            if ($option->getProduit() === $this) {
                $option->setProduit(null);
            }
        }
        return $this;
    }

    public function getTypeOption(): Collection { return $this->typeOption; }

    public function addTypeOption(Option $typeOption): static
    {
        if (!$this->typeOption->contains($typeOption)) {
            $this->typeOption->add($typeOption);
            $typeOption->setRelation($this);
        }
        return $this;
    }

    public function removeTypeOption(Option $typeOption): static
    {
        if ($this->typeOption->removeElement($typeOption)) {
            if ($typeOption->getRelation() === $this) {
                $typeOption->setRelation(null);
            }
        }
        return $this;
    }

    // ✅ Getters / setters pour StockOption

    public function getStockOptions(): Collection
    {
        return $this->stockOptions;
    }

    public function addStockOption(StockOption $stockOption): static
    {
        if (!$this->stockOptions->contains($stockOption)) {
            $this->stockOptions->add($stockOption);
            $stockOption->setProduit($this);
        }

        return $this;
    }

    public function removeStockOption(StockOption $stockOption): static
    {
        if ($this->stockOptions->removeElement($stockOption)) {
            if ($stockOption->getProduit() === $this) {
                $stockOption->setProduit(null);
            }
        }

        return $this;
    }
}
