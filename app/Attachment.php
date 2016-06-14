<?php

namespace App;

use Illuminate\Http\UploadedFile;

/**
 * @property string path
 * @property integer reference
 */
class Attachment extends KModel
{
    const TICKET_TYPE = 1;
    const TICKET_REPLY_TYPE = 2;

    /**
     * @var UploadedFile
     */
    protected $uploadedFile;

    public function uploadedFile(UploadedFile $file = null)
    {
        if ($file) {
            $this->uploadedFile = $file;
        }

        return $this->uploadedFile;
    }

    public function displayName()
    {
        $parts = explode('_', $this->path);
        array_shift($parts);

        return implode('_', $parts);
    }

}
