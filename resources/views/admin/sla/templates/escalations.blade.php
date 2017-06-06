<escalation inline-template>
    <div id="escalation">
        <section class="panel panel-primary panel-sm">
            <div class="panel-heading">
                <div class="checkbox">
                    <div class="form-group ">
                        <label class="control-label" for="enableLeveL{{$i}}">
                            {{Form::checkbox('enableLeveL[]', null, $sla->level($i+1) , ['id' => 'enableLeveL'.$i])}}
                            Enable Level {{$i+1}} Escalation
                        </label>
                    </div>

                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td><label for="levelName"> Escalate to</label></td>
                    <td>
                        <div class="input-group {{$errors->has('level-'.$i)? 'has-error' : ''}}">
                            <input type="text" id="levelName" class="form-control " name="level-{{$i}}"
                            readonly
                            value="{{$sla->escalations->where('level',$i+1)->first()->user->name ?? ''}}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="modal"
                                data-target="#techModal" data-close="chooseTech">Choose</button>
                             </span>
                        </div>
                        @if($errors->has('level-'.$i)) <label class="alert alert-danger">Level {{$i+1}} is Required</label> @endif
                    </td>
                    <td></td>
                    <td>
                        <div class="checkbox">
                            <label class="control-label" for="assign{{$i}}">
                                {{Form::hidden('assign', false)}}
                                {{Form::checkbox('assign', 1, $sla->level($i+1)->assign ?? null, ['id' => 'assign'.$i,':disable'=>'!level_enabled'])}}
                                Assign
                            </label>
                        </div>
                    </td>

                </tr>
                <tr>
                    <td></td>
                    <td>Days</td>
                    <td>Hours</td>
                    <td>Minutes</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-md-3" :disabled="!level_enabled">
                        {{Form::select('when_escalate',['Before Due date','After Due date'],$sla->level($i+1)->when_escalate ?? null ,['class'=>'form-control'])}}

                    </td>

                    <td class="col-md-3 {{$errors->has('days-'.$i)? 'has-error' : ''}}">

                        {{ Form::input('text','days-'.$i, $sla->level($i+1)->days ?? null, ['class' => 'form-control input-sm']) }}
                        @if($errors->has('days-'.$i)) <label class="alert alert-danger">
                            Days of Level {{$i+1}} is Required and must be greater than 0 </label> @endif

                    </td>
                    <td class="col-md-3">
                        {{ Form::selectRange('level_hours-'.$i, 0, 59, $sla->level($i+1)->hours ?? null, ['class' => 'form-control input-sm']) }}

                    </td>
                    <td class="col-md-3">
                        {{ Form::selectRange('level_minutes-'.$i, 0, 59, $sla->level($i+1)->minutes ?? null, ['class' => 'form-control input-sm']) }}
                    </td>
                </tr>
                </tbody>
            </table>
        </section>

    </div>


</escalation>

