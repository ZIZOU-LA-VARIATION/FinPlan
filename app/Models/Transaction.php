<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'id_user',
        'id_activity',
        'id_account',
        'date',
        'amount',
        'type',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'id_activity');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'id_account');
    }
}
