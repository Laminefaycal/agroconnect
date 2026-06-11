<?php

namespace App\Domain\Transporteur;

/**
 * Class Transporteur
 *
 * Représente un prestataire logistique ou un chauffeur sur la plateforme AgroConnect.
 * Gère l'identité, les coordonnées et le type de moyen de locomotion utilisé 
 * pour effectuer le transit des marchandises.
 *
 * @package App\Domain\Transporteur
 */
class Transporteur
{
    /**
     * Constructeur de l'entité Transporteur avec promotion de propriétés.
     *
     * @param string $id L'identifiant unique du transporteur.
     * @param string $nom Le nom complet ou la raison sociale.
     * @param string $email L'adresse e-mail professionnelle.
     * @param string $telephone Le numéro de téléphone (ex: +241...).
     * @param string $vehicule Le type ou modèle de véhicule utilisé (ex: Camionnette, Moto, Pick-up).
     */
    public function __construct(
        private string $id,
        private string $nom,
        private string $email,
        private string $telephone,
        private string $vehicule,
    ) {}

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @return string
     */
    public function getVehicule(): string
    {
        return $this->vehicule;
    }
}