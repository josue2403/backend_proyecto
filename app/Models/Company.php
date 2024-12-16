<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    protected $fillable = [
        'name',
        'desc',
        'user_id',
        'country',
        'city',
        'street1',
        'street2',
        'street3',
        'state',
        'urlPhoto',
        'popular',
    ];

    public function user() // Relación: Varias compañias pueden estar asociadas un mismo usuario
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shift() // Relación: Una compañia puede tener uno o muchos turnos
    {
        return $this->hasMany(Shift::class, 'company_id');  
    }

    public function review() // Relación: Una compañia puede tener una o varias reseñas
    {
        return $this->hasMany(Review::class, 'company_id');
    }

    public function category() // Relación: Varias compañias pueden estar asociadas a una misma categoria
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
