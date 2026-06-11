<?php

namespace App\Domain\Consommateur;

/**
 * Class Consommateur
 *
 * Représente un client ou acheteur final sur la plateforme AgroConnect.
 * Cette entité gère les informations de profil et les coordonnées nécessaires
 * pour passer des commandes et organiser la livraison.
 *
 * @package App\Domain\Consommateur
 */
class Consommateur
{
    /**
     * Constructeur de l'entité Consommateur avec promotion de propriétés.
     *
     * @param string $id L'identifiant unique du consommateur.
     * @param string $nom Le nom complet du consommateur.
     * @param string $email L'adresse e-mail de contact.
     * @param string $adresseLivraison L'adresse physique principale pour les livraisons.
     * @param string $telephone Le numéro de téléphone de contact (ex: +241...).
     */
    public function __construct(
        private string $id,
        private string $nom,
        private string $email,
        private string $adresseLivraison,
        private string $telephone,
    ) {}

    /**
     * Récupère l'identifiant unique du consommateur.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Récupère le nom complet du consommateur.
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Récupère l'adresse e-mail du consommateur.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Récupère l'adresse de livraison par défaut.
     *
     * @return string
     */
    public function getAdresseLivraison(): string
    {
        return $this->adresseLivraison;
    }

    /**
     * Récupère le numéro de téléphone du consommateur.
     *
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }
}