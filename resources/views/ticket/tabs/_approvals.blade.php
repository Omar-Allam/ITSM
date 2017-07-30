@if ($ticket->approvals->count())
    <table class="listing-table">
        <thead>
        <tr>
            <th>{{t('Sent to')}}</th>
            <th>{{t('By')}}</th>
            <th>{{'Sent at'}}</th>
            <th>{{t('Stage')}}</th>
            <th>{{t('Status')}}</th>
            <th>{{t('Comment')}}</th>
            <th colspan="3" class="text-center">{{t('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ticket->approvals as $approval)
            <tr>
                <td>{{$approval->approver->name}}</td>
                <td>{{$approval->created_by->name}}</td>
                <td>{{$approval->created_at->format('d/m/Y H:i')}}</td>
                <td>{{$approval->stage}}</td>
                <td>{{App\TicketApproval::$statuses[$approval->status]}}</td>
                <td>{{$approval->comment}}</td>
                <td>
                    @if ($approval->pending && $approval->approver_id == \Auth::user()->id)
                        <a href="{{route('approval.show', $approval)}}" class="btn btn-xs btn-info"><i
                                    class="fa fa-gavel"></i></a>
                    @endif
                </td>
                <td>
                    @if ($approval->shouldSend())
                        @if ($approval->pending && Auth::user()->id == $approval->creator_id)
                            <a title="Resend approval" href="{{route('approval.resend', $approval)}}"
                               class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i></a>
                        @endif
                    @endif
                </td>
                <td>
                    @if ($approval->pending)
                        @if (Auth::user()->id == $approval->creator_id || Auth::user()->id == $ticket->technician->id)
                            {{Form::open(['route' => ['approval.destroy', $approval], 'method' => 'delete'])}}
                            <button type="submit" title="Remove approval" class="btn btn-xs btn-warning">
                                <i class="fa fa-remove"></i>
                            </button>
                            {{Form::close()}}
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> {{t('No approvals yet')}}</div>
@endif

@if (Auth::user()->isSupport())
    <section id="approvalForm">
        {{Form::open(['route' => ['approval.send', $ticket]])}}

        @if ($ticket->hasApprovalStages())
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm {{$errors->has('approver_id')? 'has-error' : ''}}">
                        {{Form::label('stage', 'Approval Stage', ['class' => 'control-label'])}}
                        {{Form::select('stage', $ticket->approvalStages(), old('stage', $ticket->approvals->max('stage')), ['class' => 'form-control'])}}
                        @if ($errors->has('stage'))
                            <div class="error-message">{{$errors->first('stage')}}</div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm {{$errors->has('approver_id')? 'has-error' : ''}}">
                    {{Form::label('approver_id', t('Send approval to'), ['class' => 'control-label'])}}
                    <select class="form-control select2" name="approver_id" id="approver_id">
                        <option value="">{{t('Select Approver')}}</option>
                        @foreach(App\User::orderBy('name')->get() as $user)
                            <option value="{{$user->id}}">
                                {{$user->name}} ( {{$user->email}} )
                            </option>
                        @endforeach
                    </select>
{{--                    {{Form::select('approver_id', App\User::orderBy('email')->pluck('email','id') , null, ['class' => 'form-control select2'])}}--}}
                    @if ($errors->has('approver_id'))
                        <div class="error-message">{{$errors->first('approver_id')}}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group {{$errors->has('content')? 'has-error' : ''}}">
            {{Form::label('content', t('Description'), ['class' => 'control-label'])}}
            {{Form::textarea('content', null, ['class' => 'form-control richeditor'])}}

            @if ($errors->has('content'))
                <div class="error-message">{{$errors->first('content')}}</div>
            @endif
        </div>

        @if ($ticket->approvals->count())
            <div class="checkbox">
                <label>
                    {{Form::checkbox('add_stage')}} Add approval in a new stage
                </label>
            </div>
        @endif

        <div class="form-group">
            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> {{t('Send')}}</button>
        </div>
        {{Form::close()}}
    </section>
@endif