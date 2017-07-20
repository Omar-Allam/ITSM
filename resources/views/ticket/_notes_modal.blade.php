{{Form::open(['route' => ['ticket.note', $ticket],'id'=>'noteFrom'])}}
{{csrf_field()}}
<div id="ReplyModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Notes - #{{$ticket->id}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::textarea('note', null, ['class' => 'form-control simpleditor'])}}
                            @if ($errors->has('note'))
                                <div class="error-message">{{$errors->first('note')}}</div>
                            @endif
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="display_to_requester" id="display_to_requester">Show
                                this note to Requester </label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="email_to_technician" id="email_to_technician">E-mail
                                this note to the technician</label>
                        </div>
                        {{--<div class="checkbox">--}}
                            {{--<label><input type="checkbox" name="as_first_response" id="as_first_response">Consider notes--}}
                                {{--addition as first response</label>--}}
                        {{--</div>--}}

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" class="submitNote"><i class="fa fa-check-circle"></i> Add Note
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{Form::close()}}