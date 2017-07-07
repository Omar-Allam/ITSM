<div id="ReplyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Note - #{{$ticket->id}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{Form::open(['route' => ['ticket.note', $ticket]])}}
                        {{csrf_field()}}

                        <div class="form-group">
                            {{Form::textarea('note', null, ['class' => 'form-control simpleditor'])}}
                            @if ($errors->has('note'))
                                <div class="error-message">{{$errors->first('note')}}</div>
                            @endif
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Add Note
                            </button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>