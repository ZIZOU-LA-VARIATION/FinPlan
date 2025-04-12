<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    
        protected $fillable = [
            'id_user',
            'id_activity',
            'amount',
            'start_date',
            'end_date',
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
