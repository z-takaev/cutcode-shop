<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
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

    public function scopeHomepage($query)
    {
        return $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    protected $fillable = ['slug', 'name', 'thumbnail', 'sorting', 'on_home_page'];

    protected function thumbnailDir(): string
    {
        return 'brands';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}