<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    public function scopeHomepage($query)
    {
        return $query->where('on_home_page', true)
                    ->orderBy('sorting')
                    ->limit(10);
    }

    protected $fillable = ['slug', 'name', 'thumbnail', 'price', 'brand_id', 'sorting', 'on_home_page'];

    public function brands(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
