<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;
use App\Domain\Livraison\Livraison;

/**
 * Cas d'utilisation permettant au consommateur de suivre l'état d'avancement de sa livraison.
 */
class SuivreLivraisonUseCase
{
    /** @var CommandeRepositoryInterface */
    private CommandeRepositoryInterface $commandeRepository;

    /** @var LivraisonRepositoryInterface */
    private LivraisonRepositoryInterface $livraisonRepository;

    /**
     * @param CommandeRepositoryInterface $commandeRepository
     * @param LivraisonRepositoryInterface $livraisonRepository
     */
    public function __construct(
        CommandeRepositoryInterface $commandeRepository,
        LivraisonRepositoryInterface $livraisonRepository
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->livraisonRepository = $livraisonRepository;
    }

    /**
     * Récupère les détails de suivi d'une commande/livraison.
     *
     * @param string $idCommande L'identifiant de la commande concernée.
     * @return mixed Les informations ou l'objet de livraison.
     */
   public function execute(string $commandeId): Livraison
{
    $commande = $this->commandeRepository
        ->findById($commandeId);

    if (!$commande) {
        throw new \Exception(
            'Commande introuvable.'
        );
    }

    return $this->livraisonRepository
        ->findByCommandeId($commandeId);
}
}
