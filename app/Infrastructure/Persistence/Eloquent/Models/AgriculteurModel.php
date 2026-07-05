<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgriculteurModel extends Model
{
    protected $table = 'agriculteurs';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nom_exploitation',
        'email',
        'telephone',
        'localisation',
    ];

    protected $casts = [
        'id' => 'string',
    ];


    /**
     * Un agriculteur possède plusieurs produits dans son catalogue
     */
    public function produits(): HasMany
    {
        return $this->hasMany(ProduitModel::class);
    }
}
