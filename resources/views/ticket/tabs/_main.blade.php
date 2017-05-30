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

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-asterisk"></i> {{t('Ticket Options')}}</h4>
    </div>

    <table class="table table-bordered table-condensed table-striped">
        <tbody>
        @foreach($ticket->fields as $field)
            <tr>
                <td class="text-right"><strong>{{$field->custom_field->name}}</strong></td>
                <td>
                    @if ($field->custom_field->type == 'checkbox')
                        {{$field->value ? 'Yes' : 'No'}}
                    @elseif ($field->custom_field->type == 'date')
                        {{\Carbon\Carbon::parse($field->value)->format('d/m/Y')}}
                    @else
                        {{$field->value}}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

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