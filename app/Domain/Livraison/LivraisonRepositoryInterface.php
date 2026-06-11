<?php

namespace App\Domain\Livraison;

interface LivraisonRepositoryInterface
{
    public function findById(string $id): ?Livraison;
    
    public function findDisponibles(): array;
    
    public function save(Livraison $livraison): void;
}