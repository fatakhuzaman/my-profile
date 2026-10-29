<?php

use App\Support\Localization;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

if (! function_exists('localized_route')) {
    /**
     * URL of a named public page in the current (or given) locale.
     *
     * @param  array<string, mixed>|string  $parameters
     */
    function localized_route(string $name, array|string $parameters = [], ?string $locale = null): string
    {
        return Localization::route($name, $parameters, $locale);
    }
}

if (! function_exists('media_url')) {
    /**
     * Public URL of a file stored on the CMS media disk.
     */
    function media_url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        return Storage::disk(config('filesystems.media_disk'))->url($path);
    }
}

if (! function_exists('rich_content')) {
    /**
     * Render content written in the CMS rich editor as sanitized HTML, with
     * attachment URLs resolved from the media disk.
     *
     * @param  string|array<string, mixed>|null  $content
     */
    function rich_content(string|array|null $content): HtmlString
    {
        if (blank($content)) {
            return new HtmlString('');
        }

        return new HtmlString(
            RichContentRenderer::make($content)
                ->fileAttachmentsDisk(config('filesystems.media_disk'))
                ->fileAttachmentsVisibility('public')
                ->toHtml(),
        );
    }
}
