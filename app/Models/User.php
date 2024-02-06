<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'username',
        'email',
        'password',
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

    //method one of eloquent
    // public function posts(){
    //     return $this->hasMany(Post::class,'user_id');
    // }

    public function posts(){
        return $this->hasMany('App\Models\Post');
    }

    public function role(){
        return $this->belongsTo('App\Models\Role');
    }

    public function favorite_posts(){
        return $this->belongsToMany('App\Models\Post')->withTimestamps();
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function scopeAuthors($query)
    {
        return $query->where('role_id',2);
    }

}
