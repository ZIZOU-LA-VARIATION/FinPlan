<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_bk';

    protected $fillable = ['id_user', 'name', 'initial_balance', 'current_balance', 'bank_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

