<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learners_id',
        'program_id' ,
        'commentable_id',
        'commentable_type',
        'comment', // Generating a random comment string
    ];

    public function commentable()
    {
        return $this->morphTo();
    }


    public function learner()
    {
        return $this->hasMany(Learners::class, 'id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
