<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift_assigned extends Model
{
    use HasFactory;

    protected $table = 'shift_assigned';

    protected $fillable = [
        'user_id',
        'shift_id',
        'code',
        'state',
    ];

    public function user() // Relación: Varios turnos asignados pueden estar asociados a un mismo usuario
    {
        return $this->belongsTo(User::class);
    }

    public function shift() // Relación: Un turno solo puede estar asignado una vez
    {                                  // Cambiado a belongsTo por errores de testeo
        return $this->belongsTo(Shift::class);
    }
}
