<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $casts = [
        'price' => PriceCast::class
    ];

    public function scopeHomepage($query)
    {
        return $query->where('on_home_page', true)
                    ->orderBy('sorting')
                    ->limit(10);
    }

    public function scopeFiltered($query)
    {
        return $query
            ->when(request('filters.brands'), function (Builder $q) {
                $q->whereIn('brand_id', request('filters.brands'));
            })
            ->when(request('filters.price'), function (Builder $q) {
                $q->whereBetween(
                    'price',
                    [
                        request('filters.price.from', 0) * 100,
                        request('filters.price.to', 100000) * 100,
                    ]
                );
            });
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
