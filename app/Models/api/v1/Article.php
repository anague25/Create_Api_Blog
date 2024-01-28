<?php

namespace App\Models\api\v1;

use App\Models\User;
use App\Models\api\v1\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id',
        'category_id',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function like():HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function tag():BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comment() : HasMany
    {
        return $this->hasMany(Comment::class);
    }


}
