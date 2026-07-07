<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneCommandeModel extends Model
{
    protected $table = 'lignes_commande';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'commande_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
    ];

    protected $casts = [
        'id' => 'integer',
        'quantite' => 'integer',
        'prix_unitaire' => 'decimal:2',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(CommandeModel::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(ProduitModel::class);
    }
}
