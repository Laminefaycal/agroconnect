<?php

namespace App\Domain\Transporteur;

class Transporteur
{
    public function __construct(
        private string $id,
        private string $nom,
        private string $email,
        private string $telephone,
        private string $vehicule
    ) {}
}