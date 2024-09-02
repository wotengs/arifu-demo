<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function authors()
    {
        return $this->belongsToMany(User::class, 'lessons_user')->withPivot(['order'])->withTimestamps();
    }

    public function learner()
    {
        return $this->belongsToMany(Learners::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
