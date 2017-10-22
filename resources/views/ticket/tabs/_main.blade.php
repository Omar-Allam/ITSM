<div class="panel panel-default">
    <div class="panel-body ticket-description">
        {!! tidy_repair_string($ticket->description, [], 'utf8') !!}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-ticket"></i>
            @if(!$ticket->isTask())
                {{t('Request Details')}}
            @else
                {{t('Task Details')}}
            @endif
        </h4>
    </div>
    <table class="table table-striped table-condensed">
        <tr>
            <th class="col-sm-3">{{t('Category')}}</th>
            <td class="col-sm-3">{{$ticket->category->name or 'Not Assigned'}}</td>
            <th class="col-sm-3">{{t('Subcategory')}}</th>
            <td class="col-sm-3">{{$ticket->subcategory->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>{{t('Item')}}</th>
            <td>{{$ticket->Item->name or 'Not Assigned'}}</td>
            <th>&nbsp;</th>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <th>{{t('Urgency')}}</th>
            <td>{{$ticket->urgency->name or 'Not Assigned'}}</td>
            <th>{{t('SLA')}}</th>
            <td>{{$ticket->sla->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>{{t('Due Time')}}</th>
            <td>{{$ticket->due_date or 'Not Assigned'}}</td>
            <th>{{t('First Response Due Time')}}</th>
            <td>{{$ticket->first_response_date or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>{{t('Group')}}</th>
            <td>{{$ticket->group->name or 'Not Assigned'}}</td>
            <th>{{t('Technician')}}</th>
            <td>{{$ticket->technician->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>{{t('Business Unit')}}</th>
            <td>{{$ticket->business_unit->name or 'Not Assigned'}}</td>
            <th>{{t('Location')}}</th>
            <td>{{$ticket->location->name or 'Not Assigned'}}</td>
        </tr>
    </table>
</div>


@include('ticket.partials._ticket_additional_fields',['ticket'=>$ticket])
@include('ticket.partials._requester_details',['ticket'=>$ticket])

@if($ticket->notes->count())
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fa fa-sticky-note-o"></i> {{t('Discussion Notes')}}</h4>
        </div>
        <table class="table table-striped table-condensed">
            <thead>
            <tr>
                <th>{{t('Created By')}}</th>
                <th>{{t('Note')}}</th>
                <th>{{t('Created at')}}</th>
                <th>{{t('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ticket->notes as $note)
                <tr>
                    <td>{{$note->creator->name}}</td>
                    <td>@if($note->display_to_requester || Auth::user()->isSupport()) {!!$note->note !!} @else <b>private</b> @endif
                    </td>
                    <td>{{$note->created_at->format('d/m/Y H:i A') }}</td>
                    <td>
                        <button type="button" id="editNote" data-note="{{$note}}"
                                class="btn btn-primary btn-xs editNote" data-toggle="modal"
                                data-target="#ReplyModal">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" id="removeNote" data-note="{{$note}}"
                                class="btn btn-danger btn-xs removeNote" data-toggle="modal"
                                data-target="#removeNoteModal">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif

@section('javascript')
    <script>
        let ticket = {!! json_encode($ticket) !!}
    </script>
    <script src="{{asset('/js/ticket-note.js')}}"></script>
@endsection