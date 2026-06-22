<?php

namespace App\Application\Transporteur\UseCase;

use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use Exception;

/**
 * Class SignalerProblemeUseCase
 * * Permet à un transporteur de notifier un problème ou un incident survenu lors d'une livraison.
 * * @package App\Application\Transporteur\UseCase
 */
class SignalerProblemeUseCase
{
    /**
     * @param LivraisonRepositoryInterface $livraisonRepository
     */
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository
    ) {}

    /**
     * Exécute le signalement d'un incident sur une livraison.
     * * @param string $livraisonId Identifiant de la livraison concernée.
     * @param string $description Description détaillée du problème.
     * @return void
     * @throws Exception
     */
    public function execute(string $livraisonId, string $description): void
    {
        $livraison = $this->livraisonRepository->findById($livraisonId);

        if (!$livraison) {
            throw new Exception("Livraison introuvable.");
        }

        // Appliquer la logique métier de signalement d'incident
        $livraison->notifierIncident($description);
        $livraison->changerStatut('incident_signale');

        $this->livraisonRepository->save($livraison);
    }
}
