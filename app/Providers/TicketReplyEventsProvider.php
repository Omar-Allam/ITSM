<?php

namespace App\Providers;

use App\Attachment;
use App\ExtractImages;
use App\Helpers\ServiceDeskApi;
use App\Images;
use App\Jobs\TicketReplyAttachmentsJob;
use App\Jobs\TicketReplyJob;
use App\Mail\AttachmentsReplyJob;
use App\Status;
use App\TicketLog;
use App\TicketReply;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class TicketReplyEventsProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        //
    }
}
