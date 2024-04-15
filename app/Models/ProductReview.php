<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'text',
        'rating'
    ];

    protected $casts = [
        'rating' => 'int'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
