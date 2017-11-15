<div class="conversation-approvals">
    @foreach($ticket->approvals as $approval)
        <div class="panel panel-sm panel-warning">
            <div class="panel-heading">
                <h5 class="panel-title"><a href="#approval{{$approval->id}}"
                                           data-toggle="collapse">{{t('Approval Submitted By')}}
                        : {{$approval->created_by->name}}
                        On {{$approval->created_at->format('d/m/Y H:i A')}}
                        To {{$approval->approver->name}} : ({{\App\TicketApproval::$statuses[$approval->status]}} )
                    </a>
                </h5>
            </div>
            <div class="panel-body collapse" id="approval{{$approval->id}}">
                <div class="reply">
                    {!! tidy_repair_string($approval->content, [], 'utf8') !!}
                </div>
                <br>
            </div>
        </div>
    @endforeach
</div>