@if ($ticket->replies->count())
    <div class="form-group clearfix">
        <a href="#ReplyForm" class="btn btn-primary pull-right"><i class="fa fa-commenting"></i> Add reply</a>
    </div>

    @foreach($ticket->replies as $reply)
        <div class="panel panel-sm panel-{{$reply->user_id == $ticket->technician_id? 'success' : 'primary'}}">
            <div class="panel-heading">
                <h5 class="panel-title">By: {{$reply->user->name}} at: {{$reply->created_at->format('d/m/Y H:i')}}</h5>
            </div>
            <div class="panel-body">
                {!! $reply->content !!}
            </div>
        </div>
    @endforeach
@endif

<div id="ReplyForm">
    {{Form::open(['route' => ['ticket.reply', $ticket]])}}
    {{csrf_field()}}

    <div class="form-group">
        {{Form::label('reply.content', 'Description', ['class' => 'control-label'])}}
        {{Form::textarea('reply.content', null, ['class' => 'form-control'])}}
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{$errors->has('reply.status')? 'has-error' : ''}}">
                {{Form::label('reply.status', 'Change status from "' . $ticket->status->name . '" to', ['class' => 'control-label'])}}
                {{Form::select('reply.status', App\Status::where('id', '!=', $ticket->status_id)->selection('Select Status'), null, ['class' => 'form-control'])}}
                @if ($errors->has('reply.status'))
                    <div class="error-message">{{$errors->get('status')}}</div>
                @endif
            </div>
        </div>
    </div>


    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
    </div>
    {{Form::close()}}
</div>