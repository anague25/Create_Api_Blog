<?php

namespace App\Models\api\v1;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'liked',
        'article_id',
        'user_id'
    ];

    public function article():BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
