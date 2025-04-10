<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialGoal extends Model
{
    protected $fillable = [
        'name',
        'target_amount',
        'current_balance',
        'deadline',
        'description', // ✅ ici
        'id_user'
    ];


    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);  // Chaque objectif financier appartient à un seul utilisateur
    }
}
