<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'survey';

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    // relationship with question table
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
