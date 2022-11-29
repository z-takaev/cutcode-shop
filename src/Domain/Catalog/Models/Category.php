<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;

class Category extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = ['slug', 'name'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
