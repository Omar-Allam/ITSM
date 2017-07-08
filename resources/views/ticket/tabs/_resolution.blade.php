@if ($ticket->resolution)
    <div class="row">
        <div class="col-md-2"> <p>Added by {{$ticket->resolution->user->name }}
                at {{$ticket->resolution->created_at->format('d/m/Y H:i:s')}}

            </p></div>
        <div class="col-md-2">@if(Auth::user()->id == $ticket->resolution->user_id)
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editResolution">Edit
                </button>
            @endif</div>
    </div>

    <div class="well well-sm well-white">
        {!! $ticket->resolution->content !!}
    </div>
@elseif (can('resolve', $ticket))
    {{Form::open(['route' => ['ticket.resolution', $ticket]])}}
    {{csrf_field()}}

    <div class="form-group">
        {{Form::label('content', 'Description', ['class' => 'control-label'])}}
        {{Form::textarea('content', null, ['class' => 'form-control richeditor'])}}
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Add resolution</button>
    </div>
    {{Form::close()}}
@endif

@if($ticket-> resolution && Auth::user()->id == $ticket->resolution->user_id)
    <div id="editResolution" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Resolution</h4>
                </div>
                <div class="modal-body">
                    {{Form::open(['route' => ['ticket.edit-resolution', $ticket]])}}
                    {{csrf_field()}}
                    <div class="form-group">
                        {{Form::label('content', 'Description', ['class' => 'control-label'])}}
                        {{Form::textarea('content',  $ticket->resolution->content ?? '' , ['class' => 'form-control richeditor'])}}
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save
                        </button>
                    </div>
                    {{Form::close()}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endif

