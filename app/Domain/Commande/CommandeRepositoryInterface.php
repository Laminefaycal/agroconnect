<?php

namespace App\Domain\Commande;

interface CommandeRepositoryInterface
{
    public function findById(string $id): ?Commande;
    
    public function findByConsommateur(string $consommateurId): array;
    
    public function findByAgriculteur(string $agriculteurId): array;
    
    public function save(Commande $commande): void;
}