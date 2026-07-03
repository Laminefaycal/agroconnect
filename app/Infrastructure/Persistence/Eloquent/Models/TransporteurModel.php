<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransporteurModel extends Model
{
    protected $table = 'transporteurs';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nom',
        'telephone',
        'type_vehicule',
    ];

    protected $casts = [
        'id' => 'string',
    ];


    /**
     * Un transporteur peut effectuer plusieurs livraisons
     */
    public function livraisons(): HasMany
    {
        return $this->hasMany(LivraisonModel::class, 'transporteur_id', 'id');
    }
}
