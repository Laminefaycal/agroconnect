<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;

/**
 * Cas d'utilisation permettant au consommateur de valider la bonne réception de sa commande.
 */
class ValiderReceptionUseCase
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
     * Valide la réception d'une livraison spécifique.
     *
     * @param string $idLivraison L'identifiant de la livraison.
     * @return void
     */
    public function execute(string $idLivraison): void
    {

    // 1. Récupérer la livraison
    $livraison = $this->livraisonRepository->findById($idLivraison);

    if (!$livraison) {
        throw new \Exception("Livraison introuvable");
    }

    // 2. Récupérer la commande associée
    $commande = $this->commandeRepository->findById($livraison->getCommandeId());

    if (!$commande) {
        throw new \Exception("Commande introuvable");
    }

    // 3. Mettre à jour les statuts
    $livraison->confirmerReception();
    $commande->confirmerReception();

    // 4. Sauvegarder
    $this->livraisonRepository->save($livraison);
    $this->commandeRepository->save($commande);

    }
}
