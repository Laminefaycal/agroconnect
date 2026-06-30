<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Commande\CommandeRepositoryInterface;
use App\Domain\Commande\StatutCommande;

class ConsulterCommandesRecuesUseCase
{
    private $commandeRepository;

    public function __construct(CommandeRepositoryInterface $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }

    public function execute(string $agriculteurId): array
    {
        if (empty($agriculteurId)) {
            throw new \InvalidArgumentException('Identifiant obligatoire.');
        }

        $commandes = $this->commandeRepository->findByAgriculteurId($agriculteurId);

        return array_values(array_filter(
            $commandes,
            fn ($commande) => $commande->getStatut()->value !== StatutCommande::TERMINEE->value
        ));
    }
}
