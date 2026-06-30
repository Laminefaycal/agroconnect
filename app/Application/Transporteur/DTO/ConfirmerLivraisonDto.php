<?php

namespace App\Application\Transporteur\DTO;

/**
 * Class ConfirmerLivraisonDto
 *
 * Objet de transfert de données pour la confirmation d'une livraison.
 */
class ConfirmerLivraisonDto
{
    public function __construct(
        private string $livraisonId
    ) {}

    public function getLivraisonId(): string
    {
        return $this->livraisonId;
    }
}
