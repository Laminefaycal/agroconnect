<?php

namespace App\Application\Transporteur\DTO;

/**
 * Class MiseAJourStatutDto
 *
 * Objet de transfert de données (DTO) utilisé pour la mise à jour
 * du statut d'une livraison.
 *
 * @package App\Application\Transporteur\DTO
 */
class MiseAJourStatutDto
{
    /**
     * L'identifiant unique de la livraison.
     *
     * @var string
     */
    private string $livraisonId;

    /**
     * Le nouveau statut à appliquer à la livraison.
     *
     * @var mixed Instance de l'énumération StatutLivraison ou string.
     */
    private $statut;

    /**
     * Constructeur de la classe MiseAJourStatutDto.
     *
     * @param string $livraisonId L'identifiant de la livraison.
     * @param mixed  $statut      Le nouveau statut de la livraison.
     */
    public function __construct(string $livraisonId, $statut)
    {
        $this->livraisonId = $livraisonId;
        $this->statut = $statut;
    }

    /**
     * Récupère l'identifiant de la livraison.
     *
     * @return string
     */
    public function getLivraisonId(): string
    {
        return $this->livraisonId;
    }

    /**
     * Récupère le nouveau statut de la livraison.
     *
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
