<?php

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    public function img(string $sourceDirectory, string $targetDirectory): string
    {
        $storageDirectory = 'images' . DIRECTORY_SEPARATOR . $targetDirectory;

        if (!Storage::exists($storageDirectory)) {
            Storage::makeDirectory($storageDirectory);
        }

        $fileName = fake()->file(
            base_path('/tests/fixtures/images' . DIRECTORY_SEPARATOR . $sourceDirectory),
            storage_path('/app/public/images' . DIRECTORY_SEPARATOR . $targetDirectory),
            false
        );

        return DIRECTORY_SEPARATOR . 'storage'
            . DIRECTORY_SEPARATOR . $storageDirectory
            . DIRECTORY_SEPARATOR . $fileName;
    }
}
