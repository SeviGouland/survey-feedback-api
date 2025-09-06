<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject; 

class Responder extends Authenticatable implements JWTSubject 
{
    use HasFactory;

    protected $table = 'responder'; 

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // JWT methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // relationship with answer table
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
