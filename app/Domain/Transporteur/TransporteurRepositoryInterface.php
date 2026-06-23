<?php

namespace App\Domain\Transporteur;

/**
 * Interface pour le dépôt des transporteurs.
 */
interface TransporteurRepositoryInterface
{
    /**
     * Récupère un transporteur par son identifiant.
     *
     * @param string $id L'identifiant du transporteur.
     * @return Transporteur|null Le transporteur trouvé, ou null si inexistant.
     */
    public function findById(string $id): ?Transporteur;

    /**
     * Récupère tous les transporteurs disponibles (ex: ceux qui peuvent prendre une livraison).
     *
     * @return Transporteur[] Liste des transporteurs disponibles.
     */
    public function findAllDisponibles(): array;
}
