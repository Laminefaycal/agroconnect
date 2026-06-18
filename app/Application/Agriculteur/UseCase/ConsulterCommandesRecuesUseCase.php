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
        // Récupère la liste des commandes liées à cet agriculteur précis
        return $this->commandeRepository->findByAgriculteurId($agriculteurId);
    }
}
