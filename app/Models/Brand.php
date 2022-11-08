<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;

    public function scopeHomepage($query)
    {
        return $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    protected $fillable = ['slug', 'name', 'thumbnail', 'sorting', 'on_home_page'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
