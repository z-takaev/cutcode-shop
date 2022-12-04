<?php

namespace Domain\Catalog\Models;

use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = ['slug', 'name', 'thumbnail', 'sorting', 'on_home_page'];

    protected function thumbnailDir(): string
    {
        return 'brands';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    public function newCollection(array $models = [])
    {
        return new BrandCollection($models);
    }
}
