<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    public function scopeHomepage($query)
    {
        return $query->where('on_home_page', true)
                    ->orderBy('sorting')
                    ->limit(10);
    }

    protected $fillable = ['slug', 'name', 'thumbnail', 'price', 'brand_id', 'sorting', 'on_home_page'];

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function brands(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
