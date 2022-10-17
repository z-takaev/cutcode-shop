<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'thumbnail', 'price', 'brand_id'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            $product->slug = $product->slug ?? str($product->name)->slug();
        });
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
