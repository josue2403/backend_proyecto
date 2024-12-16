<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ci',
        'name',
        'last_name',
        'email',
        'rol_id',
        'phone',
        'birthdate',
        'country',
        'city',
        'urlPhoto',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role() // Relación: Muchos Usuarios pueden tener un mismo Rol
    {
        return $this->belongsTo(Rol::class,'rol_id');  // Un usuario pertenece a un rol
    }

    public function company() // Relación: Un usuario (Rol: Propietario, Multi-Propietario) puede tener una o muchas empresas
    {
        return $this->hasMany(Company::class, 'user_id');  
    }

    public function card() // Relación: Un usuario puede tener una o varias tarjetas
    {
        return $this->hasMany(Card::class, 'user_id');  
    }

    public function review() // Relación: Un usuario puede tener una o varias reviews
    {
        return $this->hasMany(Review::class, 'user_id');  
    }

    public function shift_assigned() // Relación: Un usuario (Rol: Propietario, Multi-Propietario) puede tener una o muchas empresas
    {
        return $this->hasMany(Shift_assigned::class, 'user_id');  // Un usuario pertenece a un rol
    }

}
