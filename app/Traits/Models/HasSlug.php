<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $slug = $item->{self::slugName()} ?? str($item->{self::fromSlug()})->slug();

            $item->{self::slugName()} = $item->uniqSlug($slug);
        });
    }

    static protected function fromSlug(): string
    {
        return 'name';
    }

    static protected function slugName(): string
    {
        return 'slug';
    }

    protected function uniqSlug(string $slug): string
    {
        $index = 1;
        $uniqSlug = $slug;

        while ($this->where(self::slugName(), $uniqSlug)->first()) {
            $uniqSlug = "{$slug}-{$index}";

            $index++;
        }

        return $uniqSlug;
    }
}
