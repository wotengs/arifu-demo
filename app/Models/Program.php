<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'program';

    protected $fillable = [
        'name',
        'lessons',
        'user_id',
    ];

    // Relationship to comments
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Relationship to satisfactions (a program can receive many satisfaction feedbacks)
    public function satisfactions()
    {
        return $this->morphMany(Satisfactions::class, 'satisfiable');
    }

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to lessons
    public function lessons()
    {
        return $this->hasMany(Lessons::class);
    }
    
    // Relationship to learners (many-to-many)
    public function learners()
    {
        return $this->belongsToMany(Learners::class, 'learners_program'); // Assuming 'learners_program' is the pivot table
    }
}
