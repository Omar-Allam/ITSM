<escalation inline-template>
    <div id="escalation">
        <section class="panel panel-primary panel-sm">
            <div class="panel-heading">
                <div class="checkbox">
                    <div class="form-group ">
                        <label class="control-label" for="enableLeveL{{$i}}">
                            {{Form::checkbox("levels[".($i)."][enableLeveL]", null, $sla->level($i) , ['id' => 'enableLeveL'.$i,"v-on:click='enableLevel($i)'"])}}
                            Enable Level {{$i}} Escalation
                        </label>
                    </div>

                </div>
            </div>

            <div class="panel-body">
                <div class="form-group col-md-6">

                    <label> Escalate to</label>
                    <div class="input-group {{$errors->has('level-'.$i)? 'has-error' : ''}}" >
                        <input type="text" id="levelName" class="form-control " name="levels[{{$i}}][technicians]"
                               readonly data-toggle="modal"
                               value="{{$sla->escalations->where('level',$i+1)->first()->user->name ?? ''}}" data-target="#techModal" data-close="chooseTech">

                        <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="modal"
                                        data-target="#techModal" data-close="chooseTech">Choose</button>
                        </span>
                    </div>


                </div>

                <div class="form-group col-md-6">
                    <label> Assign </label>
                    <div>
                        {{Form::select("levels[".($i)."][assign]",\App\User::technicians()->selection('Select Technician'), $sla->level($i)->assign ?? null,['class'=>'form-control'])}}
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label>When Escalation</label>
                    {{Form::select("levels[".($i)."][when_escalate]",[2=>'When to Escalate',-1=>'Before Due date',1=>'After Due date'],$sla->level($i)->when_escalate ?? null ,['class'=>'form-control'])}}
                </div>

                <div class="form-group col-md-3">
                    <label> Days</label>
                    <div>
                        {{ Form::input('text',"levels[".($i)."][days]", $sla->level($i)->days ?? 0, ['class' => 'form-control input-sm']) }}
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label> Hours</label>
                    {{ Form::selectRange("levels[".($i)."][hours]", 0, 59, $sla->level($i)->hours ?? null, ['class' => 'form-control input-sm']) }}
                </div>

                <div class="form-group col-md-3">
                    <label> Minutes</label>
                    {{ Form::selectRange("levels[".($i)."][minutes]", 0, 59, $sla->level($i)->minutes ?? null, ['class' => 'form-control input-sm']) }}
                </div>

            </div>


        </section>

    </div>
</escalation>



