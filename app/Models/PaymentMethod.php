<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'payment_method',
        'account_name',
        'iban',
        'routing_number',
        'swift',
        'status',
        'account_type',
        'country',
        'city',
        'address',
        'post_code',
        'wallet_address',
        'paypal_email',
    ];
}
