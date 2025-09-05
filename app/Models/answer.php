<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer'; 

    protected $fillable = [
        'question_id',
        'responder_id',
        'response_data',
    ];

    // relationship with responder table
    public function responder()
    {
        return $this->belongsTo(Responder::class);
    }

    // relationship with question table
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
