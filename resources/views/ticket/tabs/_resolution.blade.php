@if ($ticket->resolution)
    <h5>Added by {{$ticket->resolution->user->name }} at {{$ticket->resolution->created_at->format('d/m/Y H:i:s')}}</h5>
    <div class="well well-sm well-white">
        {!! $ticket->resolution->content !!}
    </div>
@else
    {{Form::open(['route' => ['ticket.resolution', $ticket]])}}
        {{csrf_field()}}

        <div class="form-group">
            {{Form::label('content', 'Description', ['class' => 'control-label'])}}
            {{Form::textarea('content', null, ['class' => 'form-control'])}}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Add resolution</button>
        </div>
    {{Form::close()}}
@endif
