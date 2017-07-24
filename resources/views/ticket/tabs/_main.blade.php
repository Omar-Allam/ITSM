<div class="panel panel-default">
    <div class="panel-body">
        {!! $ticket->description !!}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-ticket"></i> {{t('Request Details')}}</h4>
    </div>
    <table class="table table-striped table-condensed">
        <tr>
            <th>{{t('Category')}}</th>
            <td>{{$ticket->category->name or 'Not Assigned'}}</td>
            <th>{{t('Subcategory')}}</th>
            <td>{{$ticket->subcategory->name or 'Not Assigned'}}</td>
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
            <th>{{t('First Response')}}</th>
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

@if ($ticket->fields->count())
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-asterisk"></i> {{t('Additional Information')}}</h4>
    </div>

    <table class="table table-bordered table-condensed table-striped">
        <tbody>
        @foreach($ticket->fields as $field)
            <tr>
                <td class="col-sm-4 text-right"><strong>{{$field->name}}</strong></td>
                <td>
                    {{$field->value}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-user"></i> {{t('Requester Details')}}</h4>
    </div>
    <table class="table table-striped table-condensed">
        <tr>
            <th>{{t('Name')}}</th>
            <td>{{$ticket->requester->name}}</td>
            <th>{{t('Business Unit')}}</th>
            <td>{{$ticket->requester->business_unit->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>{{t('Email')}}</th>
            <td>{{$ticket->requester->email or 'Not Assigned'}}</td>
            <th>{{t('Location')}}</th>
            <td>{{$ticket->requester->location->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>{{t('Phone')}}</th>
            <td>{{$ticket->requester->phone or 'Not Assigned'}}</td>
            <th>{{t('Mobile')}}</th>
            <td>{{$ticket->requester->mobile or 'Not Assigned'}}</td>
        </tr>
    </table>
</div>

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