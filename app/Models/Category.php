<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'category',
        'sub_category',
    ];

    public function company() // Relación: Una categoria puede estar asociada a varias compañias
    {
        return $this->hasMany(Company::class, 'company_id');
    }

}
