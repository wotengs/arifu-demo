<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Lessons extends Model
{
    use HasFactory;

    protected $fillable = [
        'english',
        'swahili',
        'user_id',
        'sent',
        '#',
        'color',
        'program_id',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically increment the lessons count when a lesson is created
        static::created(function ($lesson) {
            // Increment the lessons count in the related program
            $program = Program::find($lesson->program_id);
            if ($program) {
                $program->increment('lessons');
            }
        });

        // Automatically decrement the lessons count when a lesson is deleted
        static::deleted(function ($lesson) {
            $program = Program::find($lesson->program_id);
            if ($program) {
                $program->decrement('lessons');
            }
        });
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
