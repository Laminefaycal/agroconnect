<?php

namespace App\Domain\Consommateur;

interface ConsommateurRepositoryInterface
{
    public function findById(string $id): ?Consommateur;
    
    public function save(Consommateur $consommateur): void;
}