<?php

namespace App\Domain\Services;
use App\Domain\Livraison\Livraison;
use App\Domain\Transporteur\Transporteur;

class ServiceLivraison
{
    public function proposerAuxTransporteurs(Livraison $livraison): void
    {
        // Logique pour lister ou notifier les transporteurs
    }

    public function affecterTransporteur(Livraison $livraison, Transporteur $transporteur): void
    {
        // Logique d'affectation finale
    }
}