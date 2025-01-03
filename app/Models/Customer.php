<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import corretto del trait
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject
{
    use Notifiable, HasFactory;
    // Definire la tabella associata al modello
    protected $table = 'customer';

    // Definire la chiave primaria se diversa da 'id'
    protected $primaryKey = 'id';

    // Definire se la chiave primaria è incrementale 
    public $incrementing = true;

    // Definire il tipo di chiave primaria
    protected $keyType = 'int';

    // Definire se il modello deve gestire i timestamp
    public $timestamps = true;

    // Definire i campi fillable
    protected $fillable = [
        'nome',
        'cognome',
        'data_nascita',
        'username',
        'email',
        'password',
        'stato',
        'avatar',
        // altri campi necessari
    ];

    // Nascondere i campi sensibili
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Definire i cast dei campi
    protected $casts = [
        'email_verified_at' => 'datetime',
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
        return ['role' => 'customer'];
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }
}