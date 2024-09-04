<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satisfactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'learners_id',
        'program_id',
        'satisfaction_level', // Renamed to match the migration and seeder
    ];

    // Relationship to the related models (Program)
    public function satisfiable()
    {
        return $this->morphTo();
    }

    // Relationship to the learner who provided the satisfaction
    public function learner()
    {
        return $this->belongsTo(Learners::class, 'learners_id');
    }

   }
