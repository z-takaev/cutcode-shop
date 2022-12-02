<?php

namespace Support\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    public function img(string $fixturesDir, string $storageDir): string
    {
        $storage = Storage::disk('images');

        if (!$storage->exists($storageDir)) {
            $storage->makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/fixtures/images/$fixturesDir"),
            $storage->path($storageDir),
            false
        );

        return '/storage/images/' . trim($storageDir, '/') . '/' . $file;
    }
}
