<?php

namespace App\Domain\Agriculteur;

interface AgriculteurRepositoryInterface
{
    public function findById(string $id): ?Agriculteur;
    
    public function save(Agriculteur $agriculteur): void;
    
    public function findProduitsByAgriculteur(string $id): array;
}