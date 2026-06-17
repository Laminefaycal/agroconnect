<?php

namespace App\Application\Agriculteur\DTO;

/**
 * Class PublierProduitDto
 * * Objet de transfert de données (DTO) pour la publication d'un nouveau produit par un agriculteur.
 * * @package App\Application\Agriculteur\DTO
 */
class PublierProduitDto
{
    /**
     * @var int L'identifiant unique de l'agriculteur qui publie le produit.
     */
    public int $agriculteurId;

    /**
     * @var string Le nom du produit agricole.
     */
    public string $nom;

    /**
     * @var string La description détaillée du produit.
     */
    public string $description;

    /**
     * @var float Le prix unitaire du produit.
     */
    public float $prix;

    /**
     * @var int La quantité de stock disponible.
     */
    public int $stock;

    /**
     * @var string L'unité de mesure du produit (ex: kg, litre, tonne).
     */
    public string $unite;

    /**
     * PublierProduitDto constructor.
     *
     * @param int $agriculteurId
     * @param string $nom
     * @param string $description
     * @param float $prix
     * @param int $stock
     * @param string $unite
     */
    public function __construct(
        int $agriculteurId,
        string $nom,
        string $description,
        float $prix,
        int $stock,
        string $unite
    ) {
        $this->agriculteurId = $agriculteurId;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->stock = $stock;
        $this->unite = $unite;
    }
}