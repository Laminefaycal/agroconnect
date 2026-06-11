<?php

namespace App\Domain\Consommateur;

class Consommateur
{
    public function __construct(
        private string $id,
        private string $nom,
        private string $email,
        private string $adresseLivraison,
        private string $telephone
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
}