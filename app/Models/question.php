<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $table = 'question'; 

    protected $fillable = [
        'survey_id',
        'type',
        'question_text',
    ];

    // relationship with table survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
