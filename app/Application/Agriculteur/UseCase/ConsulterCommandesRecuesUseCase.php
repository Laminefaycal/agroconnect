<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Repository\CommandeRepositoryInterface;

/**
 * Cas d'utilisation permettant à un agriculteur de lister les commandes passées par les consommateurs.
 */
class ConsulterCommandesRecuesUseCase
{
    /**
     * @param CommandeRepositoryInterface $commandeRepository Le dépôt pour la gestion des commandes.
     */
    public function __construct(
        private CommandeRepositoryInterface $commandeRepository
    ) {}

    /**
     * Récupère l'ensemble des commandes reçues par un agriculteur spécifique.
     *
     * @param string $agriculteurId L'identifiant de l'agriculteur connecté.
     * @return array Liste des commandes associées.
     */
    public function execute(string $agriculteurId): array
    {
        return [];
    }
}
