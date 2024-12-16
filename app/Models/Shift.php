<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shift';

    protected $fillable = [
        'name',
        'desc',
        'company_id',
        'price',
        'start_date',
        'end_date',
        'state',
        'urlPhoto',
    ];

    public function company() // Relación: Muchos turnos pueden estar asociado a una misma empresa
    {
        return $this->belongsTo(Company::class);
    }

    public function shift_assigned() // Relación: Un turno se asigna una vez
    {                                         // Cambiado a hasMany por errores de testeo
        return $this->hasMany(Shift_assigned::class, 'shift_id');
    }

}
