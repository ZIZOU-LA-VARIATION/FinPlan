<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    // app/Models/Activity.php

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_activity');
    }
    public function debts()
    {
        return $this->hasMany(Debt::class, 'id_activity');
    }

}
