@if ($ticket->approvals->count())
    <table class="listing-table">
        <thead>
        <tr>
            <th>Sent to</th>
            <th>By</th>
            <th>Sent at</th>
            <th>Stage</th>
            <th>Status</th>
            <th>Comment</th>
            <th colspan="3"></th>
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
                    @if ($approval->approver_id == \Auth::user()->id)
                        <a href="{{route('approval.show', $approval)}}" class="btn btn-xs btn-info"><i class="fa fa-gavel"></i></a>
                    @endif
                </td>
                <td>
                    @if ($approval->shouldSend())
                        @if (Auth::user()->id == $approval->creator_id)
                            <a title="Resend approval" href="{{route('approval.resend', $approval)}}" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i></a>
                        @endif
                    @endif
                </td>
                <td>
                    @if ($approval->status == \App\TicketApproval::PENDING_APPROVAL)
                        @if (Auth::user()->id == $approval->creator_id)
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
    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No approvals yet</div>
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
                {{Form::label('approver_id', 'Send approval to', ['class' => 'control-label'])}}
                {{Form::select('approver_id', App\User::selection('Select Approver'), null, ['class' => 'form-control select2'])}}
                @if ($errors->has('approver_id'))
                    <div class="error-message">{{$errors->first('approver_id')}}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group {{$errors->has('content')? 'has-error' : ''}}">
        {{Form::label('content', 'Description', ['class' => 'control-label'])}}
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
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Send approval</button>
    </div>
    {{Form::close()}}
</section>
@endif