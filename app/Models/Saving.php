<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    /** @use HasFactory<\Database\Factories\SavingFactory> */
    use HasFactory;


    protected $fillable = [
        'id_user',
        'name',
        'target_amount',
        'current_amount',
        'deadline',
        'goal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
