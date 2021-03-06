<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'type_transaction';

    protected $fillable = [
        'name',
        'status'
    ];


    protected $hidden = [
        'deleted_at'
    ];

    public function transactions()
    {
        return $this->hasMany(TypeTransaction::class);
    }
}
