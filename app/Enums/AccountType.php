<?php

namespace App\Enums;

enum AccountType: string
{
    case BANK = 'bank';
    case MICRO_FINANCE = 'micro_finance';
    case EMONEY = 'emoney';
}
