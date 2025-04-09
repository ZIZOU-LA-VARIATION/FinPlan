<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    /** @use HasFactory<\Database\Factories\InvestmentFactory> */
    use HasFactory;
    // Spécifier les attributs mass-assignables
// Modèle Investment (Investment.php)
    protected $fillable = [
        'id_user',
        'name',
        'amount',
        'type',
        'investment_date',
        'status',
        'current_value'
    ];


    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
