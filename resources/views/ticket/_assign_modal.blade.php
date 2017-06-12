{{Form::open(['route' => ['ticket.reassign', $ticket], 'class' => 'modal fade', 'id' => 'AssignForm'])}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{t('Assign Ticket')}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group {{$errors->first('group_id', 'has-error')}}">
                    {{Form::label('group_id', t('Group'), ['class' => 'control-label'])}}
                    {{Form::select('group_id', App\Group::selection('Select Group'), null, ['class' => 'form-control'])}}
                    {!! $errors->first('group_id', '<div class="help-block">:message</div>') !!}
                </div>

                <div class="form-group {{$errors->first('technician_id', 'has-error')}}">
                    {{Form::label('technician_id', t('Technician'), ['class' => 'control-label'])}}
                    {{Form::select('technician_id', App\User::technicians()->selection('Select Technician'), null, ['class' => 'form-control'])}}
                    {!! $errors->first('technician_id', '<div class="help-block">:message</div>') !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-mail-forward"></i> {{t('Assign')}}</button>
            </div>
        </div>
    </div>
{{Form::close()}}