<?php

namespace App\Traits\Models;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{
    abstract protected function thumbnailDir(): string;

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
