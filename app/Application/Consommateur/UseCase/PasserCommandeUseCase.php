<?php

namespace App\Application\Consommateur\UseCase;

use App\Application\Consommateur\Dto\PasserCommandeDto;
use App\Domain\Commande\Commande;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Consommateur\Repository\ConsommateurRepositoryInterface;
use App\Domain\Produit\Repository\ProduitRepositoryInterface;
use App\Domain\Services\ServiceDisponibilite;

/**
 * Cas d'utilisation gérant l'action de passer une commande par le consommateur.
 */
class PasserCommandeUseCase
{
    /** @var CommandeRepositoryInterface */
    private CommandeRepositoryInterface $commandeRepository;

    /** @var ConsommateurRepositoryInterface */
    private ConsommateurRepositoryInterface $consommateurRepository;

    /** @var ProduitRepositoryInterface */
    private ProduitRepositoryInterface $produitRepository;

    /** @var ServiceDisponibilite */
    private ServiceDisponibilite $serviceDisponibilite;

    /**
     * @param CommandeRepositoryInterface $commandeRepository
     * @param ConsommateurRepositoryInterface $consommateurRepository
     * @param ProduitRepositoryInterface $produitRepository
     * @param ServiceDisponibilite $serviceDisponibilite
     */
    public function __construct(
        CommandeRepositoryInterface $commandeRepository,
        ConsommateurRepositoryInterface $consommateurRepository,
        ProduitRepositoryInterface $produitRepository,
        ServiceDisponibilite $serviceDisponibilite
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->consommateurRepository = $consommateurRepository;
        $this->produitRepository = $produitRepository;
        $this->serviceDisponibilite = $serviceDisponibilite;
    }

    /**
     * Exécute le processus de création et d'enregistrement d'une commande.
     *
     * @param PasserCommandeDto $dto
     * @return Commande La commande générée.
     * @throws \Exception Si un produit n'est pas disponible ou si le consommateur est introuvable.
     */
    public function execute(PasserCommandeDto $dto): Commande
    {
        // 1. Logique métier : Vérification de la disponibilité via le Service de Domaine
        // 2. Récupération des entités requises
        // 3. Instanciation de l'objet métier Commande
        // 4. Sauvegarde via le repository

        // Exemple purement conceptuel :
        // $commande = Commande::creer($dto->idConsommateur, $dto->lignes);
        // return $this->commandeRepository->save($commande);

        throw new \Exception("Logique interne à implémenter selon vos règles métier.");
    }
}
