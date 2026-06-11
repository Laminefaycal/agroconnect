<?php

namespace App\Domain\Transporteur;

interface TransporteurRepositoryInterface
{
    public function findById(string $id): ?Transporteur;
    
    public function findAllDisponibles(): array;
}