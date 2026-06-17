<?php

namespace App\Domain\Agriculteur;

/**
 * Class Agriculteur
 *
 * Représente l'entité Domaine d'un producteur agricole au sein de la plateforme AgroConnect.
 * Cette classe encapsule les données fondamentales de l'agriculteur sans dépendance technique.
 */
class Agriculteur
{
    /**
     * Constructeur de l'entité Agriculteur avec promotion de propriétés.
     *
     * @param  string  $id  L'identifiant unique de l'agriculteur.
     * @param  string  $nom  Le nom complet ou la raison sociale de l'agriculteur.
     * @param  string  $email  L'adresse e-mail de contact.
     * @param  string  $telephone  Le numéro de téléphone (ex: +241...).
     * @param  string  $numeroSIRET  Le numéro d'identification fiscale ou d'enregistrement de l'exploitation.
     */
    public function __construct(
        private string $id,
        private string $nom,
        private string $email,
        private string $telephone,
        private string $numeroSIRET,
    ) {}

    /**
     * Récupère l'identifiant unique de l'agriculteur.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Récupère le nom de l'agriculteur.
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Récupère l'adresse e-mail de l'agriculteur.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Récupère le numéro de téléphone de l'agriculteur.
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * Récupère le numéro SIRET de l'exploitation.
     */
    public function getNumeroSIRET(): string
    {
        return $this->numeroSIRET;
    }
}
