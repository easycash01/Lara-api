<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import corretto del trait
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use  Notifiable, HasFactory;

    /* RUOLI ALL'INTERNO DELL'APP */
    const ROLE_SUPER_ADMIN = 'Super';
    const ROLE_NORMAL_USER = 'Visitatore';
    const ROLE_PAYING_USER = 'Pagante';
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
        return [
            'role' => $this->role, // Aggiungi il ruolo come custom claim
        ];
    }

    public function isSuperAdmin()
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isNormalUser()
    {
        return $this->role === self::ROLE_NORMAL_USER;
    }

    public function isPayingUser()
    {
        return $this->role === self::ROLE_PAYING_USER;
    }
}
