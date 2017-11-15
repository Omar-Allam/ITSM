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