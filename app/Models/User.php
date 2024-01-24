<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\api\v1\Article;
use App\Models\api\v1\Category;
use App\Models\api\v1\Comment;
use App\Models\api\v1\Role;
use App\Models\api\v1\Tag;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'image',
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



    public function article() : HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function articleLike():BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public function tag() : HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function category() : HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function role():BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function comment() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
    
    










}
