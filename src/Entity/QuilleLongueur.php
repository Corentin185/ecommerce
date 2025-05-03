<?php

namespace App\Entity;

use App\Repository\QuilleLongueurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuilleLongueurRepository::class)]
class QuilleLongueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $nom = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?float
    {
        return $this->nom;
    }

    public function setNom(float $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
}
