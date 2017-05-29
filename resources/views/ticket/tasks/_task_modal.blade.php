{{Form::open(['route'=>'task.store','id'=>'task_form'])}}
{{csrf_field()}} {{method_field('POST')}}
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-tasks"></i> <span class="title-modal"> Add New Task </span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm {{$errors->has('title')? 'has-error' : ''}}">
                            {{Form::label('title', 'Title', ['class' => 'control-label'])}}
                            {{Form::text('title', null, ['class' => 'form-control'])}}
                            @if ($errors->has('title'))
                                <div class="error-message">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm {{$errors->has('description')? 'has-error' : ''}}">
                            {{Form::label('description', 'Description', ['class' => 'control-label'])}}
                            {{Form::textarea('description', null, ['class' => 'form-control'])}}
                            @if ($errors->has('description'))
                                <div class="error-message">{{$errors->first('description')}}</div>
                            @endif
                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm {{$errors->has('priority_id')? 'has-error' : ''}}">
                            {{Form::label('priority_id', 'Priority', ['class' => 'control-label'])}}
                            {{Form::select('priority_id', ['0'=>'Select Priority'] + \App\Priority::pluck('name','id')->toArray(),null, ['class' => 'form-control'])}}
                            @if ($errors->has('priority_id'))
                                <div class="error-message">{{$errors->first('priority_id')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-sm {{$errors->has('technician_id')? 'has-error' : ''}}">
                            {{Form::label('technician_id', 'Technician', ['class' => 'control-label'])}}
                            {{Form::select('technician_id',['0'=>'Select Technician'] +\App\User::technicians()->pluck('name','id')->toArray(),null, ['class' => 'form-control'])}}
                            @if ($errors->has('technician_id'))
                                <div class="error-message">{{$errors->first('technician_id')}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group form-group-sm {{$errors->has('group_id')? 'has-error' : ''}}">
                            {{Form::label('group_id', 'Group', ['class' => 'control-label'])}}
                            {{Form::select('group_id', ['0'=>'Select Group'] +\App\Group::pluck('name','id')->toArray(),null, ['class' => 'form-control'])}}
                            @if ($errors->has('group_id'))
                                <div class="error-message">{{$errors->first('group_id')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <input type="hidden" value="{{$ticket->id}}" name="ticket_id" id="ticket_id">
            </div>


            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{Form::close()}}