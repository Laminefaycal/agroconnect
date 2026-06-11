<?php

namespace App\Domain\Transporteur;

/**
 * Interface TransporteurRepositoryInterface
 *
 * Spécifie le contrat de persistance pour la gestion des transporteurs partenaires.
 * Assure l'isolation de la logique métier logistique face aux mécanismes de stockage.
 *
 * @package App\Domain\Transporteur
 */
interface TransporteurRepositoryInterface
{
    /**
     * Recherche un transporteur par son identifiant unique.
     *
     * @param string $id L'identifiant du transporteur.
     * @return Transporteur|null L'entité Transporteur correspondante, ou null si elle n'existe pas.
     */
    public function findById(string $id): ?Transporteur;

    /**
     * Récupère la liste de tous les transporteurs actuellement actifs et disponibles au Gabon.
     *
     * @return array Liste des entités Transporteur disponibles.
     */
    public function findAllDisponibles(): array;
}