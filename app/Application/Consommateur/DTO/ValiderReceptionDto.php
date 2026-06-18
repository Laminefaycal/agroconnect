<?php

namespace App\Application\Consommateur\DTO;

/**
 * Class ValiderReceptionDto
 * * Transporte les données nécessaires pour confirmer la réception d'une commande par le client.
 *
 * @package App\Application\Consommateur\DTO
 */
class ValiderReceptionDto
{
    /**
     * L'identifiant unique de la commande reçue.
     * @var string
     */
    private string $commandeId;

    /**
     * Indicateur confirmant si la marchandise est effectivement livrée.
     * @var bool
     */
    private bool $estLivree;

    /**
     * ValiderReceptionDto constructor.
     *
     * @param string $commandeId L'identifiant de la commande concernée.
     * @param bool $estLivree Statut de livraison (true si reçue avec succès).
     */
    public function __construct(string $commandeId, bool $estLivree)
    {
        $this->commandeId = $commandeId;
        $this->estLivree = $estLivree;
    }

    /**
     * Récupère l'identifiant de la commande.
     *
     * @return string
     */
    public function getCommandeId(): string
    {
        return $this->commandeId;
    }

    /**
     * Vérifie si la commande a bien été confirmée comme livrée.
     *
     * @return bool
     */
    public function isEstLivree(): bool
    {
        return $this->estLivree;
    }
}