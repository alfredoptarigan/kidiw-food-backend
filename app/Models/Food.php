<?php

namespace App\Models;

use App\Traits\HasScope;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasUuid, SoftDeletes, HasScope;

    protected $primaryKey = 'uuid';
    protected $keyType = "string";
    public $incrementing = false;

    protected $table = 'foods';
    protected $fillable = [
        'name',
        'price',
        'is_available',
        'quantity',
        'rate_review',
        'image',
        'description',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'quantity' => 'integer',
        'rate_review' => 'double',
    ];

    public function getImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getPriceAttribute($value)
    {
        return $value ? number_format($value, 0, ',', '.') : null;
    }

    public function getRateReviewAttribute($value)
    {
        return $value ? number_format($value, 1, ',', '.') : null;
    }

    public function categories() :BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'food_categories');
    }

}
