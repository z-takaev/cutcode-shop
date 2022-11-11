<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
    /**
     * @param string $dir
     * @param string $method
     * @param string $sizes
     * @param string $filename
     * @return BinaryFileResponse
     */
    public function __invoke(string $dir, string $method, string $size, string $filename): BinaryFileResponse
    {
        abort_if(
            !in_array(
                $size,
                config('thumbnail.allowedSizes', [])
            ),
            403,
            'Size not allowed'
        );

        $storage = Storage::disk('images');

        $realPath = "$dir/$filename";
        $newDirPath = "$dir/$method/$size";
        $resultPath = "$newDirPath/$filename";

        if (!$storage->exists($newDirPath)) {
            $storage->makeDirectory($newDirPath);
        }

        if (!$storage->exists($resultPath)) {
            $image = Image::make($storage->path($realPath));

            [$w, $h] = explode('x', $size);

            $image->{$method}($w, $h);

            $image->save($storage->path($resultPath));
        }

        return response()->file($storage->path($resultPath));
    }
}
