<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use App\Domain\Livraison\StatutLivraison;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LivraisonModel extends Model
{
    protected $table = 'livraisons';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'commande_id',
        'transporteur_id',
        'date_prise_en_charge',
        'date_livraison_effective',
        'statut',
    ];

    protected $casts = [
        'id' => 'string',
        'commande_id' => 'string',
        'transporteur_id' => 'string',
        'date_prise_en_charge' => 'datetime',
        'date_livraison_effective' => 'datetime',
        'statut' => StatutLivraison::class,
    ];

    /**
     * Relation avec la Commande associée
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(CommandeModel::class);
    }

    /**
     * Relation avec le Transporteur assigné
     */
    public function transporteur(): BelongsTo
    {
        return $this->belongsTo(TransporteurModel::class);
    }

    /**
     * Met à jour le statut de la livraison
     */
    public function mettreAJourStatut(StatutLivraison $statut): void
    {
        $this->statut = $statut;
        $this->save();
    }

    /**
     * Confirme la livraison effective de la marchandise
     */
    public function confirmerLivraison(): void
    {
        $this->statut = StatutLivraison::LIVREE;
        $this->date_livraison_effective = new DateTime;
        $this->save();
    }
}
