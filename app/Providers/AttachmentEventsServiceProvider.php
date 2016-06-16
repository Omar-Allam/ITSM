<?php

namespace App\Providers;

use App\Attachment;
use Illuminate\Support\ServiceProvider;

class AttachmentEventsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Attachment::saving(function (Attachment $attachment) {
            $file = $attachment->uploadedFile();
            $filename = uniqid() . '_' . $file->getClientOriginalName();

            $folder = '/attachments/';
            $path = $folder . $filename;
            $file->move(public_path($folder), $filename);

            $attachment->path = $path;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
