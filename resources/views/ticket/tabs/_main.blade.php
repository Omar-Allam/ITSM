<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-ticket"></i> Request Details</h4>
    </div>
    <table class="table table-striped table-condensed">
        <tr>
            <th>Urgency</th>
            <td>{{$ticket->urgency->name or 'Not Assigned'}}</td>
            <th>SLA</th>
            <td>{{$ticket->sla->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>Due Time</th>
            <td>{{$ticket->due_date or 'Not Assigned'}}</td>
            <th>First Response</th>
            <td>{{$ticket->first_response_date or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>Group</th>
            <td>{{$ticket->group->name or 'Not Assigned'}}</td>
            <th>Technician</th>
            <td>{{$ticket->technician->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>Business Unit</th>
            <td>{{$ticket->business_unit->name or 'Not Assigned'}}</td>
            <th>Location</th>
            <td>{{$ticket->location->name or 'Not Assigned'}}</td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-asterisk"></i> Ticket Options</h4>
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
        <h4 class="panel-title"><i class="fa fa-user"></i> Requester Details</h4>
    </div>
    <table class="table table-striped table-condensed">
        <tr>
            <th>Name</th>
            <td>{{$ticket->requester->name}}</td>
            <th>Business Unit</th>
            <td>{{$ticket->requester->business_unit->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{$ticket->requester->email or 'Not Assigned'}}</td>
            <th>Location</th>
            <td>{{$ticket->requester->location->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{$ticket->requester->phone or 'Not Assigned'}}</td>
            <th>Mobile</th>
            <td>{{$ticket->requester->mobile or 'Not Assigned'}}</td>
        </tr>
    </table>
</div>

<div class="well well-sm well-white">
    {!! $ticket->description !!}
</div>