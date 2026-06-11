<?php

namespace App\Domain\Commande;

use App\Domain\Transporteur\Transporteur;
use DateTime;

class Commande
{
    public function __construct(
        private string $id,
        private DateTime $dateCommande,
        private StatutCommande $statut,
        private ModelLivraison $modeLivraison
    ) {}

    public function valider(): void
    {
        $this->statut = StatutCommande::VALIDEE;
    }

    public function choisirModelLivraison(ModelLivraison $mode): void
    {
        $this->modeLivraison = $mode;
    }

    public function assignerTransporteur(Transporteur $transporteur): void
    {
        // Logique d'assignation
    }
}