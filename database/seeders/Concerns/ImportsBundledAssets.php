<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\Storage;

trait ImportsBundledAssets
{
    /**
     * Copy a file bundled in `public/` onto the media disk and return its
     * path there, or null when the bundled file is missing.
     */
    protected function importAsset(string $publicPath, string $directory): ?string
    {
        $source = public_path($publicPath);

        if (! is_file($source)) {
            return null;
        }

        $disk = Storage::disk(config('filesystems.media_disk'));
        $target = $directory.'/'.basename($publicPath);

        if (! $disk->exists($target)) {
            $disk->put($target, file_get_contents($source), 'public');
        }

        return $target;
    }
}
