<?php

namespace Domain\Product\Models;

use Domain\Catalog\Facades\Sorter;
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
        $query->where('on_home_page', true)
                ->orderBy('sorting')
                ->limit(10);
    }

    public function scopeFiltered($query)
    {
        foreach (filters() as $filter) {
            $query = $filter->apply($query);
        }
    }

    public function scopeSorted($query)
    {
        Sorter::run($query);
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

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }
}
