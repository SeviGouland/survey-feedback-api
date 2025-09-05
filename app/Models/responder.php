<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class Responder extends Authenticatable
{
    use HasFactory;

    protected $table = 'responder'; 

    protected $fillable = [
        'email',
        'password',
    ];

    // for jwt
    protected $hidden = [
        'password',
    ];

    // relationship with answer table
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
