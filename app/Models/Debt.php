<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{

    protected $fillable = [
        'user_id',
        'creditor',
        'amount',
        'remaining_amount',
        'loan_date',
        'due_date',
        'status',
        'description',
    ];

    /**
     * Get the user that owns the debt.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // App\Models\Debt.php
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'id_activity'); // ou 'activity_id' si c’est ça que tu utilises
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'id_account');
    }


}
