<?php

namespace App\Application\Transporteur\UseCase;

use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;

/**
 * Class ConsulterLivraisonsDisponiblesUseCase
 * * Permet à un transporteur de lister toutes les livraisons disponibles.
 * * @package App\Application\Transporteur\UseCase
 */
class ConsulterLivraisonsDisponiblesUseCase
{
    /**
     * @param LivraisonRepositoryInterface $livraisonRepository
     */
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository
    ) {}

    /**
     * Exécute la récupération des livraisons disponibles.
     * * @return array
     */
    public function execute(): array
    {
        // Exemple d'appel vers votre repository
        return $this->livraisonRepository->findDisponibles();
    }
}
