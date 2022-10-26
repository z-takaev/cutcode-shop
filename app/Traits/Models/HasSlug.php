<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $item->slug = self::generateUniqSlug($item->slug ?? str($item->{self::fromSlug()})->slug());
        });
    }

    static protected function fromSlug(): string
    {
        return 'name';
    }

    static private function generateUniqSlug(string $slug): string
    {
        $record = self::query()->where('slug', $slug)->first();

        if (!$record) {
            return $slug;
        }

        return self::generateUniqSlug($slug . '-' . uniqid());
    }
}
