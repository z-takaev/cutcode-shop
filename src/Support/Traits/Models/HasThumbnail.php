<?php

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait HasThumbnail
{
    abstract protected function thumbnailDir(): string;

    protected $methods = ['resize', 'crop', 'fit'];

    protected static function bootHasThumbnail(): void {
        static::deleting(function (Model $item) {
            $storage = Storage::disk('images');

            $filename = File::basename($item->{$item->thumbnailColumn()});

            foreach ($item->methods as $method) {
               foreach (config('thumbnail.allowedSizes', []) as $size) {
                   $thumbnailPath = "{$item->thumbnailDir()}/$method/$size/$filename";

                    if ($storage->exists($thumbnailPath)) {
                        $storage->delete($thumbnailPath);
                    }
               }
            }
        });
    }

    public function makeThumbnail(string $size, string $method = 'resize'): string {
        return route(
            'thumbnail',
            [$this->thumbnailDir(), $method, $size, File::basename($this->{$this->thumbnailColumn()})]
        );
    }

    protected function thumbnailColumn(): string {
        return 'thumbnail';
    }
}
