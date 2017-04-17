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

    protected $fillable = ['reference', 'type'];

    /**
     * @var UploadedFile
     */
    protected $uploadedFile;

    public static function uploadFiles($type, $id)
    {
        $files = \Request::file('attachments');
        if ($files) {
            foreach ($files as $file) {
                if ($file) {
                    $attach = new static(['type' => $type, 'reference' => $id]);
                    $attach->uploadedFile($file);
                    $attach->save();
                }
            }
        }
    }

    public function uploadedFile(UploadedFile $file = null)
    {
        if ($file) {
            $this->uploadedFile = $file;
        }

        return $this->uploadedFile;
    }

    public function getDisplayNameAttribute()
    {
        $parts = explode('_', $this->path);
        array_shift($parts);

        return implode('_', $parts);
    }

    public function getUploadedByAttribute()
    {
        if ($this->type == self::TICKET_TYPE) {
            $user = Ticket::find($this->reference)->created_by;
        } else {
            $user = TicketReply::find($this->reference)->user;
        }

        return $user->name;
    }
}
