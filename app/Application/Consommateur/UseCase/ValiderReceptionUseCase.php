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
        // Logique métier : récupérer la livraison, changer son statut,
        // mettre à jour la commande associée et sauvegarder.
    }
}
