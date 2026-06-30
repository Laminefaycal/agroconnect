<?php

namespace App\Application\Transporteur\DTO;

/**
 * Class SignalerProblemeDto
 *
 * Objet de transfert de données pour le signalement d'un problème sur une livraison.
 */
class SignalerProblemeDto
{
    public function __construct(
        private string $livraisonId,
        private string $description
    ) {}

    public function getLivraisonId(): string
    {
        return $this->livraisonId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
