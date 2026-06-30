<?php

namespace App\Application\Transporteur\DTO;

/**
 * Class AccepterLivraisonDto
 *
 * Objet de transfert de données (DTO) utilisé lors de l'acceptation
 * d'une livraison par un transporteur.
 */
class AccepterLivraisonDto
{
    /**
     * L'identifiant unique de la livraison.
     */
    private string $livraisonId;

    /**
     * L'identifiant unique du transporteur.
     */
    private string $transporteurId;

    /**
     * Constructeur de la classe AccepterLivraisonDto.
     *
     * @param  string  $livraisonId  L'identifiant de la livraison.
     * @param  string  $transporteurId  L'identifiant du transporteur.
     */
    public function __construct(string $livraisonId, string $transporteurId)
    {
        $this->livraisonId = $livraisonId;
        $this->transporteurId = $transporteurId;
    }

    /**
     * Récupère l'identifiant de la livraison.
     */
    public function getLivraisonId(): string
    {
        return $this->livraisonId;
    }

    /**
     * Récupère l'identifiant du transporteur.
     */
    public function getTransporteurId(): string
    {
        return $this->transporteurId;
    }
}
