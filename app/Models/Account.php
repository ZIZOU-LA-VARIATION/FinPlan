<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\AccountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasFactory;

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    protected $fillable = [
        'name',
        'initial_balance',
        'current_balance',
        'bank_name',
        'account_type',
        'id_user',
    ];

    /**
     * Interagir avec l'attribut account_type.
     */
    protected function accountType(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? AccountType::from($value) : null,
            set: fn($value) => $value instanceof AccountType ? $value->value : $value,
        );
    }

    // app/Models/Account.php

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_account');
    }

    public function debts()
    {
        return $this->hasMany(Debt::class, 'id_account');
    }


}



