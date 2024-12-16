<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';  // Definir la tabla si no coincide con el nombre del modelo

    protected $fillable = [
        'rol',
        'desc',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'rol_id');  // Un rol puede tener muchos usuarios
    }
}
