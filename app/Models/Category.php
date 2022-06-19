<?php

namespace App\Models;

use App\Traits\HasScope;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasUuid, SoftDeletes, HasScope;

    protected $primaryKey = 'uuid';
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'name',
        'icon',
    ];

    public function getIconAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function foods() :BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'food_categories');
    }
}
