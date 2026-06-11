<?php

namespace App\Domain\Produit;

class Produit
{
    public function __construct(
        private string $id,
        private string $nom,
        private string $description,
        private float $prixUnitaire,
        private int $stock,
        private string $unite
    ) {}

    public function estDisponible(int $quantite): bool
    {
        return $this->stock >= $quantite;
    }

    public function decrementerStock(int $quantite): void
    {
        if ($this->estDisponible($quantite)) {
            $this->stock -= $quantite;
        }
    }
}