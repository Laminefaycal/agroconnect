<?php

namespace App\Domain\Consommateur;

/**
 * Interface ConsommateurRepositoryInterface
 *
 * Spécifie le contrat de persistance pour la gestion des données des consommateurs.
 * Cette interface isole le comportement métier de la couche Domaine de toute implémentation
 * technique d'accès aux données.
 */
interface ConsommateurRepositoryInterface
{
    /**
     * Recherche un consommateur par son identifiant unique.
     *
     * @param  string  $id  L'identifiant du consommateur à retrouver.
     * @return Consommateur|null L'entité Consommateur correspondante, ou null si elle n'existe pas.
     */
    public function findById(string $id): ?Consommateur;

    /**
     * Enregistre un nouveau consommateur ou met à jour un profil existant.
     *
     * @param  Consommateur  $consommateur  L'entité à sauvegarder dans le système.
     */
    public function save(Consommateur $consommateur): ?Consommateur;
}
