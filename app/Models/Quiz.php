<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'open_date',
        'due_date',
        'time_limit',
        'allowed_attemps',
        'max_score',
        'automatic_grading',
        'active'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function material()
    {
        return $this->hasOne(Material::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
