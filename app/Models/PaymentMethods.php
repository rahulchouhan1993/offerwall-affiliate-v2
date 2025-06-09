<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    protected $fillable = [
        'user_id',
        'payment_method',
        'account_name',
        'iban',
        'routing_number',
        'swift',
        'status'
    ];
}
