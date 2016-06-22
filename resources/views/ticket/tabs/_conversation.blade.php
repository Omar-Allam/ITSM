@if ($ticket->replies->count())
    <div class="form-group clearfix">
        <a href="#ReplyForm" class="btn btn-primary pull-right"><i class="fa fa-commenting"></i> Add reply</a>
    </div>

    @foreach($ticket->replies()->latest()->get() as $reply)
        <div class="panel panel-sm panel-{{$reply->class}}">
            <div class="panel-heading">
                <h5 class="panel-title"><a href="#reply{{$reply->id}}" data-toggle="collapse">By: {{$reply->user->name}} at: {{$reply->created_at->format('d/m/Y H:i')}}</a></h5>
            </div>
            <div class="panel-body collapse" id="reply{{$reply->id}}">
                <div class="reply">
                    {!! $reply->content !!}
                </div>
                <br>
                <span class="label label-default">Status: {{$reply->status->name}}</span>
            </div>
        </div>
    @endforeach
@endif

<div id="ReplyForm">
    {{Form::open(['route' => ['ticket.reply', $ticket], 'files' => true])}}
    {{csrf_field()}}

    <div class="form-group {{$errors->has('reply.content')? 'has-errors' : ''}}">
        {{Form::label('reply[content]', 'Description', ['class' => 'control-label'])}}
        {{Form::textarea('reply[content]', null, ['class' => 'form-control richeditor', 'rows' => 5])}}
        @if ($errors->has('reply.content'))
            <div class="error-message">{{$errors->first('reply.content')}}</div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{$errors->has('reply.status_id')? 'has-error' : ''}}">
                {{Form::label('reply[status_id]', 'Change status from "' . $ticket->status->name . '" to', ['class' => 'control-label'])}}
                {{Form::select('reply[status_id]', App\Status::reply($ticket)->selection('Select Status'), null, ['class' => 'form-control'])}}
                @if ($errors->has('reply.status_id'))
                    <div class="error-message">{{$errors->first('status_id')}}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <attachment limit="2"></attachment>
        </div>
    </div>


    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
    </div>
    {{Form::close()}}
</div>
