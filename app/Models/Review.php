<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    protected $fillable = [
        'user_id',
        'company_id',
        'stars',
        'comment',
    ];

    public function userReview() // Relación: Varias reseñas pueden tener un usuario
    {
        return $this->belongsTo(User::class);
    }

    public function companyReview() // Relación: Varias reseñas pueden tener una compañia
    {
        return $this->belongsTo(Company::class);  
    }

}
