<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learners extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'programs_completed',
    ];

    // Relationship to comments (as before)
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Relationship to programs (a learner can be enrolled in many programs)
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'learners_program'); // Assuming 'learners_program' is the pivot table
    }

    // Relationship to lessons
    public function lessons()
    {
        return $this->hasMany(Lessons::class);
    }

    // Relationship to satisfactions (a learner can provide many satisfaction feedbacks)
    public function satisfactions()
    {
        return $this->hasMany(Satisfactions::class);
    }
}
