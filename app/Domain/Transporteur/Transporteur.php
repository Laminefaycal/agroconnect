<?php

namespace App\Domain\Transporteur;

/**
 * Classe représentant un transporteur sur la plateforme AgroConnect.
 */
class Transporteur
{
    private string $id;
    private string $nom;
    private string $email;
    private string $telephone;
    private string $vehicule;

    /**
     * Constructeur.
     *
     * @param string $id        Identifiant unique du transporteur.
     * @param string $nom       Nom du transporteur (personne ou société).
     * @param string $email     Adresse email de contact.
     * @param string $telephone Numéro de téléphone.
     * @param string $vehicule  Type ou immatriculation du véhicule.
     */
    public function __construct(string $id, string $nom, string $email, string $telephone, string $vehicule)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->vehicule = $vehicule;
    }

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

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function setVehicule(string $vehicule): self
    {
        $this->vehicule = $vehicule;
        return $this;
    }
}
