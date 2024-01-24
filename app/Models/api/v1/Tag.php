<?php

namespace App\Models\api\v1;

use App\Models\User;
use App\Models\api\v1\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function article():BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
