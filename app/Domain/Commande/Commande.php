<?php

namespace App\Domain\Commande;

use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Transporteur\Transporteur;
use DateTime;
use InvalidArgumentException;

class Commande
{
    private array $lignes = [];

    private ?Livraison $livraison = null;

    public function __construct(
        private DateTime $dateCommande,
        private StatutCommande $statut,
        private ModeLivraison $modeLivraison,
        private ?string $id,
    ) {}

    public function valider(): void
    {
        if ($this->statut !== StatutCommande::EN_ATTENTE_VALIDATION) {
            throw new InvalidArgumentException('Seule une commande en attente peut être validée.');
        }
        $this->statut = StatutCommande::VALIDEE;
    }

    public function choisirModeLivraison(ModeLivraison $mode): void  // nom corrigé
    {
        $this->modeLivraison = $mode;
    }

    public function assignerTransporteur(Transporteur $transporteur): void
    {
        if ($this->modeLivraison === ModeLivraison::AGRICULTEUR) {
            throw new InvalidArgumentException('Impossible d’assigner un transporteur en mode livraison par agriculteur.');
        }
        if ($this->livraison === null) {
            $this->livraison = new Livraison(
                uniqid(), // à remplacer par un vrai UUID en production
                null,
                null,
                StatutLivraison::ASSIGNEE
            );
        }
        $this->livraison->assignerTransporteur($transporteur);
        $this->statut = StatutCommande::EN_LIVRAISON;
    }

    public function ajouterLigne(LigneCommande $ligne): void
    {
        $this->lignes[] = $ligne;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDateCommande(): DateTime
    {
        return $this->dateCommande;
    }

    public function getStatut(): StatutCommande
    {
        return $this->statut;
    }

    public function getModeLivraison(): ModeLivraison
    {
        return $this->modeLivraison;
    }

    public function getLignes(): array
    {
        return $this->lignes;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(Livraison $livraison): void
    {
        $this->livraison = $livraison;
    }
}
