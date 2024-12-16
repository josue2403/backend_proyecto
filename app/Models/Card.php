<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table = 'card';

    protected $fillable = [
        'user_id',
        'owner',
        'acc_num',
        'end_month',
        'end_year',
        'cvv',
    ];

    public function user() // Relación: Muchas tarjetas pueden tener un mismo usuario
    {
        return $this->belongsTo(User::class, 'user_id');  
    }
}
