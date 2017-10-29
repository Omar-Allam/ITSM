@if ($ticket->replies->count() || $ticket->approvals->count())
    <section class="replies">

        <h4>{{t('Ticket Replies')}}</h4>

        @foreach($ticket->replies()->latest()->get() as $reply)
            <div class="panel panel-sm panel-{{$reply->class}}">
                <div class="panel-heading">
                    <h5 class="panel-title"><a href="#reply{{$reply->id}}" data-toggle="collapse">{{t('By')}}
                            : {{$reply->user->name}} On {{$reply->created_at->format('d/m/Y H:i A')}}</a></h5>
                </div>
                <div class="panel-body collapse" id="reply{{$reply->id}}">
                    <div class="reply">
                        {!! tidy_repair_string($reply->content, [], 'utf8') !!}
                    </div>
                    <br>
                </div>
            </div>
        @endforeach

        <h4>{{t('Ticket Approvals')}}</h4>
        @foreach($ticket->approvals as $approval)
            @if($approval->comment)
                <div class="panel panel-sm panel-warning">
                    <div class="panel-heading">
                        <h5 class="panel-title"><a href="#approval{{$approval->id}}"
                                                   data-toggle="collapse">{{t('Approval Reply By')}}
                                : {{$approval->approver->name}}
                                On {{$approval->updated_at->format('d/m/Y H:i A')}}</a>
                        </h5>
                    </div>
                    <div class="panel-body collapse" id="approval{{$approval->id}}">
                        <div class="reply">
                            {!! tidy_repair_string($approval->comment, [], 'utf8') !!}
                        </div>
                        <br>
                    </div>
                </div>
            @endif

        @endforeach
    </section>
@endif