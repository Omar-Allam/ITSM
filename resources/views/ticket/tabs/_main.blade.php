<div class="well well-sm well-white">
    {!! nl2br(e($ticket->description)) !!}
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-user"></i> Requester Details</h4>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-condensed">
            <tr>
                <th>Name</th>
                <td>{{$ticket->requester->name}}</td>
                <th>Business Unit</th>
                <td>{{$ticket->request->business_unit->name or 'Not Assigned'}}</td>
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
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-ticket"></i> Request Details</h4>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-condensed">
            <tr>
                <th>Priority</th>
                <td>{{$ticket->priority->name or 'Not Assigned'}}</td>
                <th>Urgency</th>
                <td>{{$ticket->urgency->name or 'Not Assigned'}}</td>
            </tr>
            <tr>
                <th>Impact</th>
                <td>{{$ticket->imapct->name or 'Not Assigned'}}</td>
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
                <td>{{$request->business_unit->name or 'Not Assigned'}}</td>
                <th>Location</th>
                <td>{{$request->location->name or 'Not Assigned'}}</td>
            </tr>
        </table>
    </div>
</div>