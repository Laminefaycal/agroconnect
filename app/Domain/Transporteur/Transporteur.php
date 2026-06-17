<?php

namespace App\Domain\Transporteur;

/**
 * Class Transporteur
 *
 * Représente un prestataire logistique ou un chauffeur sur la plateforme AgroConnect.
 * Gère l'identité, les coordonnées et le type de moyen de locomotion utilisé
 * pour effectuer le transit des marchandises.
 */
class Transporteur
{
    /**
     * Constructeur de l'entité Transporteur avec promotion de propriétés.
     *
     * @param  string  $id  L'identifiant unique du transporteur.
     * @param  string  $nom  Le nom complet ou la raison sociale.
     * @param  string  $email  L'adresse e-mail professionnelle.
     * @param  string  $telephone  Le numéro de téléphone (ex: +241...).
     * @param  string  $vehicule  Le type ou modèle de véhicule utilisé (ex: Camionnette, Moto, Pick-up).
     */
    public function __construct(
        private string $id,
        private string $nom,
        private string $email,
        private string $telephone,
        private string $vehicule,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getVehicule(): string
    {
        return $this->vehicule;
    }
}
