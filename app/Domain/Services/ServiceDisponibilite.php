<?php

namespace App\Domain\Services;

use App\Domain\Produit\Produit;

/**
 * Class ServiceDisponibilite
 *
 * Service du Domaine (Domain Service) chargé de valider les règles métiers transversales
 * liées aux stocks et aux flux de commandes sur la plateforme AgroConnect.
 *
 * @package App\Domain\Services
 */
class ServiceDisponibilite
{
    /**
     * Vérifie de manière isolée si un produit agricole dispose d'un stock suffisant 
     * pour répondre à une demande d'achat.
     *
     * @param Produit $produit L'entité Produit concernée par la vérification.
     * @param int $quantite La quantité demandée par le consommateur.
     * @return bool Vrai si le produit est disponible dans la quantité requise, faux sinon.
     */
    public function verifierStock(Produit $produit, int $quantite): bool
    {
        return $produit->estDisponible($quantite);
    }
}