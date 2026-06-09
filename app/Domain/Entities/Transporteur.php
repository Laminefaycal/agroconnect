<?php

namespace App\Domain\Entities;

class Transporteur
{
    private ?int $idTransporteur;
    private string $nom;
    private string $email;
    private string $motDePasse;
    private string $telephone;
    private string $adresse;

    public function __construct(
        ?int $idTransporteur, 
        string $nom, 
        string $email, 
        string $motDePasse, 
        string $telephone, 
        string $adresse
    ) {
        $this->idTransporteur = $idTransporteur;
        $this->nom = $nom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
    }

    public function getIdTransporteur(): ?int { return $this->idTransporteur; }
    public function getNom(): string { return $this->nom; }
    public function getEmail(): string { return $this->email; }
    public function getMotDePasse(): string { return $this->motDePasse; }
    public function getTelephone(): string { return $this->telephone; }
    public function getAdresse(): string { return $this->adresse; }
}