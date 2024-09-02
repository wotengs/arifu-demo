<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{

    use HasApiTokens, HasFactory, Notifiable;

    //Admin All previledges including creating Users, Can Bulk Delete & restore
    //User(Editor/Support-Team) - Create new Program & Lessons, edit Program & Lessons, Delete FeedBack, Updating Own Profile & Restore deletions
   
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->can('view-admin', User::class);
    }

    public function isAdmin(){

        return $this->role === self::ROLE_ADMIN;

    }

    public function isUser(){

        return $this->role === self::ROLE_USER;

    }

    const ROLE_ADMIN = 'ADMIN';

    const ROLE_USER = 'USER';

    const ROLE_DEFAULT = self::ROLE_USER;

    const ROLES = [

        self::ROLE_ADMIN =>'Admin',
        self::ROLE_USER =>'User',

    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'image',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function program()
    {
        return $this->belongsToMany(Program::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lessons::class, 'lessons_user')->withPivot(['order'])->withTimestamps();
    }

    public function learners()
    {
        return $this->belongsToMany(Learners::class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class);
    }
}
