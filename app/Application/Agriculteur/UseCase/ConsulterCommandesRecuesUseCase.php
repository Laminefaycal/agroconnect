<?php

namespace App\Application\Agriculteur\UseCase;

<<<<<<< HEAD
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
=======
use App\Domain\Interface\Repository\CommandeRepositoryInterface;

class ConsulterCommandesRecuesUseCase
{
    private $commandeRepository;

    public function __construct(CommandeRepositoryInterface $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }

    public function execute(string $agriculteurId): array
    {
        // Récupère la liste des commandes liées à cet agriculteur précis
        return $this->commandeRepository->findByAgriculteurId($agriculteurId);
>>>>>>> feature/implementer-use-cases-agriculteur
    }
}
