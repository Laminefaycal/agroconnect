<?php

namespace App\Application\Agriculteur\UseCase;

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
    if (empty($agriculteurId)) {
        throw new \InvalidArgumentException('Identifiant obligatoire.');
    }

    $commandes = $this->commandeRepository->findByAgriculteurId($agriculteurId);

    // array_values permet de remettre les clés à zéro [0, 1] après le filtrage
    return array_values(array_filter(
        $commandes,
        fn($commande) => $commande->getStatut()->value !== 'TERMINEE' // 💡 On compare des chaînes pures (.value)
    ));
}
 }
