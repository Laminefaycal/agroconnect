<?php

namespace App\Domain\Produit;

interface ProduitRepositoryInterface
{
    public function findById(string $id): ?Produit;
    
    public function findAll(): array;
    
    public function search(string $keyword): array;
    
    public function save(Produit $produit): void;
    
    public function delete(string $id): void;
}