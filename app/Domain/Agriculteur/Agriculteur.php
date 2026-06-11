<?php

namespace App\Domain\Agriculteur;

class Agriculteur
{
    public function __construct(
        private string $id,
        private string $nom,
        private string $email,
        private string $telephone,
        private string $numeroSIRET
    ) {}
}