<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'type_transaction_id',
        'origin',
        'code',
        'supplier_id',
        'value',
        'user_id',
        'commentary'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}
