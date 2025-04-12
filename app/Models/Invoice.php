<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'id_user',
        'id_activity',
        'title',
        'amount',
        'due_date',
        'status',
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
}
