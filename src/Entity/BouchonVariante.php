<?php

namespace App\Entity;

use App\Repository\BouchonVarianteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BouchonVarianteRepository::class)]
class BouchonVariante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'no')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bouchon $bouchon = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeCorps $typeCorps = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?GrammageCorps $grammageCorps = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AntenneCouleur $antenneCouleur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AntenneLongueur $antenneLongueur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuilleLongueur $quilleLongueur = null;

    #[ORM\ManyToOne]
    private ?Couleur $couleur = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(length: 255)]
    private ?string $codeSku = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\Column(nullable: true)]
    private ?float $poidsTotal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBouchon(): ?Bouchon
    {
        return $this->bouchon;
    }

    public function setBouchon(?Bouchon $bouchon): static
    {
        $this->bouchon = $bouchon;

        return $this;
    }

    public function getTypeCorps(): ?TypeCorps
    {
        return $this->typeCorps;
    }

    public function setTypeCorps(?TypeCorps $typeCorps): static
    {
        $this->typeCorps = $typeCorps;

        return $this;
    }

    public function getGrammageCorps(): ?GrammageCorps
    {
        return $this->grammageCorps;
    }

    public function setGrammageCorps(?GrammageCorps $grammageCorps): static
    {
        $this->grammageCorps = $grammageCorps;

        return $this;
    }

    public function getAntenneCouleur(): ?AntenneCouleur
    {
        return $this->antenneCouleur;
    }

    public function setAntenneCouleur(?AntenneCouleur $antenneCouleur): static
    {
        $this->antenneCouleur = $antenneCouleur;

        return $this;
    }

    public function getAntenneLongueur(): ?AntenneLongueur
    {
        return $this->antenneLongueur;
    }

    public function setAntenneLongueur(?AntenneLongueur $antenneLongueur): static
    {
        $this->antenneLongueur = $antenneLongueur;

        return $this;
    }

    public function getQuilleLongueur(): ?QuilleLongueur
    {
        return $this->quilleLongueur;
    }

    public function setQuilleLongueur(?QuilleLongueur $quilleLongueur): static
    {
        $this->quilleLongueur = $quilleLongueur;

        return $this;
    }

    public function getCouleur(): ?Couleur
    {
        return $this->couleur;
    }

    public function setCouleur(?Couleur $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCodeSku(): ?string
    {
        return $this->codeSku;
    }

    public function setCodeSku(string $codeSku): static
    {
        $this->codeSku = $codeSku;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    public function getPoidsTotal(): ?float
    {
        return $this->poidsTotal;
    }

    public function setPoidsTotal(?float $poidsTotal): static
    {
        $this->poidsTotal = $poidsTotal;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
