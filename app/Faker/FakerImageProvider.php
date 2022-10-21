<?php

namespace App\Faker;

use Faker\Provider\Base;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    /**
     * @param string $sourceDirectory
     * @param string $targetFolder
     * @return string
     */
    public function img(string $sourceDirectory, string $targetFolder = ''): string
    {
        if (!is_dir($sourceDirectory)) {
            throw new \InvalidArgumentException(
                sprintf('Source directory %s does not exist or is not a directory.', $sourceDirectory)
            );
        }

        if (!Storage::exists($targetFolder)) {
            Storage::makeDirectory($targetFolder);
        }

        if ($sourceDirectory == $targetFolder) {
            throw new \InvalidArgumentException('Source and target directories must differ.');
        }

        // Drop . and .. and reset array keys
        $files = array_filter(
            array_values(array_diff(scandir($sourceDirectory), ['.', '..'])),
            static function ($file) use ($sourceDirectory) {
                return is_file($sourceDirectory . DIRECTORY_SEPARATOR . $file) && is_readable(
                        $sourceDirectory . DIRECTORY_SEPARATOR . $file
                    );
            }
        );

        if (empty($files)) {
            throw new \InvalidArgumentException(sprintf('Source directory %s is empty.', $sourceDirectory));
        }

        $sourceFullPath = $sourceDirectory . DIRECTORY_SEPARATOR . static::randomElement($files);

        $destinationFile = Uuid::uuid() . '.' . pathinfo($sourceFullPath, PATHINFO_EXTENSION);
        $destinationFullPath = $targetFolder . DIRECTORY_SEPARATOR . $destinationFile;

        if (false === copy($sourceFullPath, Storage::path($destinationFullPath))) {
            return false;
        }

        return DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $destinationFullPath;
    }
}
